<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class DisposicionController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;

        $this->assets->collection('headerCss')
            ->addCss('plugins/select2/select2.min.css');
        $this->assets->collection('footerJs')
            ->addJs('plugins/select2/select2.full.min.js');
        $this->assets->collection('footerInlineJs')
            ->addInlineJs(' $(".autocompletar").select2();');
        $this->view->form = new DisposicionForm(null, array('edit' => true));    }


    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->persistent->parameters = null;

        $this->assets->collection('headerCss')
            ->addCss('plugins/select2/select2.min.css');
        $this->assets->collection('footerJs')
            ->addJs('plugins/select2/select2.full.min.js');
        $this->assets->collection('footerInlineJs')
            ->addInlineJs('
            $(".autocompletar").select2();
            $(document).ready( function() {
                var now = new Date();
                var day = ("0" + now.getDate()).slice(-2);
                var month = ("0" + (now.getMonth() + 1)).slice(-2);
                var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
                $(\'#fecha\').val(today);
                });
            ');
        $this->view->form = new DisposicionForm(null, array('edit' => true, 'required' => true));

    }
    /**
     * Creates a new disposicion
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->redireccionar("disposicion/listar");
        }
        $this->db->begin();

        $form = new DisposicionForm();
        $documento = new Disposicion();
        // Recuperamos los datos por post y seteanmos la entidad
        $data = $this->request->getPost();
        $form->bind($data, $documento);
        /*Obtenemos el ultimo numero de disposicion*/
        $ultimo = Disposicion::findFirst("ultimo=1");
        if (!$ultimo) {
            $documento->setNroDisposicion(1);
            $documento->setUltimo(1);
        } else {
            $ultimo->setUltimo(0);
            if (!$ultimo->update()) {
                $this->db->rollback();
                foreach ($ultimo->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this->redireccionar('disposicion/new');
            }
            $documento->setNroDisposicion($ultimo->getNroDisposicion() + 1);
            $documento->setUltimo(1);

        }
        /*Validamos el formulario*/
        if (!$form->isValid()) {
            $this->db->rollback();
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('disposicion/new');
        }
        /*Seteamos los campos faltantes*/
        $documento->setHabilitado(1);
        $documento->setDescripcion(mb_strtoupper($documento->getDescripcion()));
        $documento->setTipo(4);
        /*Guardamos el adjunto*/
        $archivos = $this->request->getUploadedFiles();
        if ($archivos[0]->getName() != "") {

            $nombreCarpeta = 'files/disposicion/' . date('Ymd') . '/' . $documento->getNroDisposicion();
            $path = $this->guardarAdjunto($archivos, $nombreCarpeta);
            if ($path == "") {
                $this->flashSession->error("Edite la disposicion para volver a adjuntar el archivo.");
            }
            else{
                $documento->setDisposicionAdjunto($path);
            }
        }
        /*Guardamos la instancia en la bd*/
        if ($documento->save() == false) {
            $this->db->rollback();
            foreach ($documento->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('disposicion/new');
        }

        $form->clear();
        $this->db->commit();
        $this->flashSession->success("La Disposicion ha sido creada correctamente");
        return $this->response->redirect('disposicion/listar');

    }

    /**
     * Edits a expediente
     *
     * @param string $id_documento
     */
    public function editarAction($id_documento)
    {
        $this->assets->collection('headerCss')
            ->addCss('plugins/select2/select2.min.css');
        $this->assets->collection('footerJs')
            ->addJs('plugins/select2/select2.full.min.js');
        $this->assets->collection('footerInlineJs')
            ->addInlineJs('
            $(".autocompletar").select2();

            ');
        $documento = Disposicion::findFirst(array('id_documento=' . $id_documento));
        if (!$documento) {
            $this->flash->error("La disposicion no se encontró");
            return $this->redireccionar("disposicion/search");
        }
        $this->view->disposicion = $documento;
        $this->view->form = new DisposicionForm($documento, array('edit' => true, 'required' => true));
    }
    /**
     * Saves a disposicione edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->redireccionar("disposicion/listar");
        }

        $id = $this->request->getPost("id_documento", "int");

        $documento = Disposicion::findFirst("id_documento=" . $id);
        if (!$documento) {
            $this->flash->error("La disposicion no pudo ser editada.");
            return $this->redireccionar("disposicion/listar");
        }
        $this->db->begin();

        /*Validamos el formulario*/
        $form = new DisposicionForm;
        $this->view->form = $form;
        $data = $this->request->getPost();
        $form->bind($data, $documento);
        /*Validamos el formulario*/
        if (!$form->isValid()) {
            $this->db->rollback();
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('disposicion/editar/' . $id);
        }

        /*Guardamos el adjunto*/
        $archivos = $this->request->getUploadedFiles();
        if ($archivos[0]->getName() != "") {
            $nombreCarpeta = 'files/disposicion/' . date('Ymd') . '/' . $documento->getNroDisposicion();
            $path = $this->guardarAdjunto($this->request->getUploadedFiles(), $nombreCarpeta);
            if ($path == "") {
                $this->flash->error("Ocurrió un problema al guardar el archivo adjunto. Edite la disposicion para volver a adjuntar el archivo.");
            }
            $documento->setDisposicionAdjunto($path);
        }
        /*Actualizamos los datos*/
        $documento->setDescripcion(mb_strtoupper($documento->getDescripcion()));
        if ($documento->save() == false) {
            $this->db->rollback();
            foreach ($documento->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('disposicion/editar/' . $id);
        }

        $form->clear();

        $this->db->commit();
        $this->flashSession->success("La Disposicion ha sido actualizada correctamente");
        return $this->response->redirect('disposicion/listar');

    }



    /**
     * Deletes a disposicion
     *
     * @param string $id_documento
     */
    public function deleteAction($id_documento)
    {

        $disposicion = Disposicion::findFirstByid_documento($id_documento);
        if (!$disposicion) {
            $this->flash->error("disposicion was not found");

            return $this->dispatcher->forward(array(
                "controller" => "disposicion",
                "action" => "index"
            ));
        }

        if (!$disposicion->delete()) {

            foreach ($disposicion->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "disposicion",
                "action" => "search"
            ));
        }

        $this->flash->success("disposicion was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "disposicion",
            "action" => "index"
        ));
    }
    /**
     * Muestra los datos de la disposicion y ofrece las operaciones que se pueden realizar sobre la misma.
     * @param $id_documento
     * @return null
     */
    public function verAction($id_documento)
    {

        $documento = Disposicion::findFirst(array('id_documento=' . $id_documento));
        if (!$documento) {
            $this->flash->error("La disposicion no se encontró");
            return $this->redireccionar("disposicion/listar");
        }
        $this->view->disposicion = $documento;
        $this->view->form = new DisposicionForm($documento, array('edit' => true, 'readOnly' => true, 'required' => true));

    }


    /* ====================================================
           BUSQUEDAS
       =======================================================*/
    public function listarAction()
    {
        $this->setDatatables();
        $this->view->pick('disposicion/search');


        $numberPage = $this->request->getQuery("page", "int");
        $parameters["order"] = "id_documento DESC";

        $disposicion = Disposicion::find($parameters);
        if (count($disposicion) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron disposiciones cargadas en el sistema");
            return $this->response->redirect('disposicion/index');
        }

        $paginator = new Paginator(array(
            "data" => $disposicion,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Searches for disposicion
     */
    public function searchAction()
    {
        $this->setDatatables();
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Disposicion", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $rol = $this->session->get('auth')['rol_nombre'];
        $limitarAnio = "";
        if ($rol != "ADMINISTRADOR") {
            $date = date_create(date('Y') . '-01-01');
            $ultimoAno = date_format($date, "Y-m-d");//A pedido. los usuarios normales solo podrán ver las disposiciones del ultimo año.
            $limitarAnio = "  '$ultimoAno'  <= fecha ";
        }
        if (isset($parameters['conditions']))
            if ($limitarAnio != "")
                $parameters['conditions'] .= "AND $limitarAnio ";
            else
                if ($limitarAnio != "")
                    $parameters['conditions'] = "$limitarAnio ";

        $parameters["order"] = "id_documento DESC";

        $disposicion = Disposicion::find($parameters);
        if (count($disposicion) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron disposiciones cargadas en el sistema que coincidan con su búsqueda");
            return $this->response->redirect('disposicion/index');
        }

        $paginator = new Paginator(array(
            "data" => $disposicion,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    public function searchEntreFechasAction()
    {
        $this->setDatatables();
        $this->view->pick('disposicion/search');
        $numberPage = 1;

        $rol = $this->session->get('auth')['rol_nombre'];
        $limitarAnio = "";
        if ($rol != "ADMINISTRADOR") {
            $date = date_create(date('Y') . '-01-01');
            $ultimoAno = date_format($date, "Y-m-d");//A pedido. los usuarios normales solo podrán ver las disposiciones del ultimo año.
            $limitarAnio = "  '$ultimoAno'  <= fecha AND ";
        }
        $desde = $this->request->getPost('fecha_desde');
        $hasta = $this->request->getPost('fecha_hasta');
        if ($this->request->isPost()) {

            $query = Criteria::fromInput($this->di, "Disposicion", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id_documento DESC";
        if ($desde != null && $hasta != null) {
            if (isset($parameters['conditions']))
                $parameters['conditions'] .= " AND $limitarAnio  fecha BETWEEN '$desde' AND '$hasta'";
            else
                $parameters['conditions'] = "$limitarAnio  fecha BETWEEN '$desde' AND '$hasta'";
        }
        $disposicion = Disposicion::find($parameters);
        if (count($disposicion) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron disposiciones cargadas en el sistema que coincidan con su búsqueda");
            return $this->response->redirect('disposicion/index');
        }

        $paginator = new Paginator(array(
            "data" => $disposicion,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }


    public function searchEntreNumerosAction()
    {
        $this->setDatatables();
        $this->view->pick('disposicion/search');
        $numberPage = 1;

        $rol = $this->session->get('auth')['rol_nombre'];
        $limitarAnio = "";
        if ($rol != "ADMINISTRADOR") {
            $date = date_create(date('Y') . '-01-01');
            $ultimoAno = date_format($date, "Y-m-d");//A pedido. los usuarios normales solo podrán ver las disposiciones del ultimo año.
            $limitarAnio = " '$ultimoAno'  <= fecha AND ";
        }
        $desde = $this->request->getPost('nroInicial');
        $hasta = $this->request->getPost('nroFinal');
        if ($this->request->isPost()) {

            $query = Criteria::fromInput($this->di, "Disposicion", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id_documento DESC";

        if ($desde != null && $hasta != null) {
            if (isset($parameters['conditions']))
                $parameters['conditions'] .= " AND $limitarAnio  nro_disposicion >= $desde AND nro_disposicion <= $hasta";
            else
                $parameters['conditions'] = "$limitarAnio  nro_disposicion >= $desde AND nro_disposicion <= $hasta";
        }
        $disposicion = Disposicion::find($parameters);
        if (count($disposicion) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron disposiciones cargadas en el sistema que coincidan con su búsqueda");
            return $this->response->redirect('disposicion/index');
        }

        $paginator = new Paginator(array(
            "data" => $disposicion,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

}
