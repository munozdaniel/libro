<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ResolucionesController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }



    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a resolucione
     *
     * @param string $id_documento
     */
    public function editAction($id_documento)
    {

        if (!$this->request->isPost()) {

            $resolucione = Resoluciones::findFirstByid_documento($id_documento);
            if (!$resolucione) {
                $this->flash->error("resolucione was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "resoluciones",
                    "action" => "index"
                ));
            }

            $this->view->id_documento = $resolucione->id_documento;

            $this->tag->setDefault("id_documento", $resolucione->getIdDocumento());
            $this->tag->setDefault("nro_resolucion", $resolucione->getNroResolucion());
            $this->tag->setDefault("creadopor", $resolucione->getCreadopor());
            $this->tag->setDefault("descripcion", $resolucione->getDescripcion());
            $this->tag->setDefault("fecha", $resolucione->getFecha());
            $this->tag->setDefault("habilitado", $resolucione->getHabilitado());
            $this->tag->setDefault("sector_id_oid", $resolucione->getSectorIdOid());
            $this->tag->setDefault("tipo", $resolucione->getTipo());
            $this->tag->setDefault("ultimo", $resolucione->getUltimo());
            $this->tag->setDefault("resoluciones_adjunto", $resolucione->getResolucionesAdjunto());
            
        }
    }

    /**
     * Creates a new resolucione
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "resoluciones",
                "action" => "index"
            ));
        }

        $resolucione = new Resoluciones();

        $resolucione->setNroResolucion($this->request->getPost("nro_resolucion"));
        $resolucione->setCreadopor($this->request->getPost("creadopor"));
        $resolucione->setDescripcion($this->request->getPost("descripcion"));
        $resolucione->setFecha($this->request->getPost("fecha"));
        $resolucione->setHabilitado($this->request->getPost("habilitado"));
        $resolucione->setSectorIdOid($this->request->getPost("sector_id_oid"));
        $resolucione->setTipo($this->request->getPost("tipo"));
        $resolucione->setUltimo($this->request->getPost("ultimo"));
        $resolucione->setResolucionesAdjunto($this->request->getPost("resoluciones_adjunto"));
        

        if (!$resolucione->save()) {
            foreach ($resolucione->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "resoluciones",
                "action" => "new"
            ));
        }

        $this->flash->success("resolucione was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "resoluciones",
            "action" => "index"
        ));

    }

    /**
     * Saves a resolucione edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "resoluciones",
                "action" => "index"
            ));
        }

        $id_documento = $this->request->getPost("id_documento");

        $resolucione = Resoluciones::findFirstByid_documento($id_documento);
        if (!$resolucione) {
            $this->flash->error("resolucione does not exist " . $id_documento);

            return $this->dispatcher->forward(array(
                "controller" => "resoluciones",
                "action" => "index"
            ));
        }

        $resolucione->setNroResolucion($this->request->getPost("nro_resolucion"));
        $resolucione->setCreadopor($this->request->getPost("creadopor"));
        $resolucione->setDescripcion($this->request->getPost("descripcion"));
        $resolucione->setFecha($this->request->getPost("fecha"));
        $resolucione->setHabilitado($this->request->getPost("habilitado"));
        $resolucione->setSectorIdOid($this->request->getPost("sector_id_oid"));
        $resolucione->setTipo($this->request->getPost("tipo"));
        $resolucione->setUltimo($this->request->getPost("ultimo"));
        $resolucione->setResolucionesAdjunto($this->request->getPost("resoluciones_adjunto"));
        

        if (!$resolucione->save()) {

            foreach ($resolucione->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "resoluciones",
                "action" => "edit",
                "params" => array($resolucione->id_documento)
            ));
        }

        $this->flash->success("resolucione was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "resoluciones",
            "action" => "index"
        ));

    }

    /**
     * Deletes a resolucione
     *
     * @param string $id_documento
     */
    public function deleteAction($id_documento)
    {

        $resolucione = Resoluciones::findFirstByid_documento($id_documento);
        if (!$resolucione) {
            $this->flash->error("resolucione was not found");

            return $this->dispatcher->forward(array(
                "controller" => "resoluciones",
                "action" => "index"
            ));
        }

        if (!$resolucione->delete()) {

            foreach ($resolucione->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "resoluciones",
                "action" => "search"
            ));
        }

        $this->flash->success("resolucione was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "resoluciones",
            "action" => "index"
        ));
    }
    /**
     * Muestra los datos de la resolucion y ofrece las operaciones que se pueden realizar sobre la misma.
     * @param $id_documento
     * @return null
     */
    public function verAction($id_documento)
    {

        $documento = Resoluciones::findFirst(array('id_documento=' . $id_documento));
        if (!$documento) {
            $this->flash->error("La nota no se encontró");
            return $this->redireccionar("nota/listar");
        }
        $this->view->resolucion = $documento;
        $this->view->form = new ResolucionesForm($documento, array('edit' => true, 'readOnly' => true, 'required' => true));

    }
    /* ====================================================
        BUSQUEDAS
    =======================================================*/
    public function listarAction()
    {
        $this->setDatatables();
        $this->view->pick('resoluciones/search');


        $numberPage = $this->request->getQuery("page", "int");
        $parameters["order"] = "id_documento DESC";

        $documento = Resoluciones::find($parameters);
        if (count($documento) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron notas cargadas en el sistema");
            return $this->response->redirect('resoluciones/index');
        }

        $paginator = new Paginator(array(
            "data" => $documento,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();

    }

    public function listarAjaxAction()
    {
        $this->view->disable();
        $retorno = array();
        $parameters["order"] = "id_documento DESC";
        $documentos = Resoluciones::find($parameters);
        if (count($documentos) == 0) {
            echo json_encode(array("data"=>""));
            return;
        }
        foreach ($documentos as $doc) {
            $item[] = "-";
            $item[] = $doc->getNroResolucion();
            $item[] = "SEC";
            $item[] = $doc->getFecha();
            $item[] = $doc->getDescripcion();
            $retorno[] = $item;
        }

        echo json_encode(
            array("data" =>
                    $retorno
            )
        );
        return;

    }

    public function listar2Action()
    {
        $this->setDatatables();
        $this->view->pick('resoluciones/search');


        $numberPage = $this->request->getQuery("page", "int");
        $parameters["order"] = "id_documento DESC";

        $resoluciones = Resoluciones::find($parameters);
        if (count($resoluciones) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron resoluciones cargadas en el sistema");
            return $this->response->redirect('resoluciones/index');
        }

        $paginator = new Paginator(array(
            "data" => $resoluciones,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Searches for resoluciones
     */
    public function searchAction()
    {
        $this->setDatatables();
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Nota", $_POST);
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
            $ultimoAno = date_format($date, "Y-m-d");//A pedido. los usuarios normales solo podrán ver las resoluciones del ultimo año.
            $limitarAnio = "  '$ultimoAno'  <= fecha ";
        }
        if (isset($parameters['conditions']))
            if ($limitarAnio != "")
                $parameters['conditions'] .= "AND $limitarAnio ";
            else
                if ($limitarAnio != "")
                    $parameters['conditions'] = "$limitarAnio ";

        $parameters["order"] = "id_documento DESC";

        $resoluciones = Nota::find($parameters);
        if (count($resoluciones) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron resoluciones cargadas en el sistema que coincidan con su búsqueda");
            return $this->response->redirect('resoluciones/index');
        }

        $paginator = new Paginator(array(
            "data" => $resoluciones,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    public function searchEntreFechasAction()
    {
        $this->setDatatables();
        $this->view->pick('resoluciones/search');
        $numberPage = 1;

        $rol = $this->session->get('auth')['rol_nombre'];
        $limitarAnio = "";
        if ($rol != "ADMINISTRADOR") {
            $date = date_create(date('Y') . '-01-01');
            $ultimoAno = date_format($date, "Y-m-d");//A pedido. los usuarios normales solo podrán ver las resoluciones del ultimo año.
            $limitarAnio = "  '$ultimoAno'  <= fecha AND ";
        }
        $desde = $this->request->getPost('fecha_desde');
        $hasta = $this->request->getPost('fecha_hasta');
        if ($this->request->isPost()) {

            $query = Criteria::fromInput($this->di, "Nota", $_POST);
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
        $resoluciones = Nota::find($parameters);
        if (count($resoluciones) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron resoluciones cargadas en el sistema que coincidan con su búsqueda");
            return $this->response->redirect('resoluciones/index');
        }

        $paginator = new Paginator(array(
            "data" => $resoluciones,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }


    public function searchEntreNumerosAction()
    {
        $this->setDatatables();
        $this->view->pick('resoluciones/search');
        $numberPage = 1;

        $rol = $this->session->get('auth')['rol_nombre'];
        $limitarAnio = "";
        if ($rol != "ADMINISTRADOR") {
            $date = date_create(date('Y') . '-01-01');
            $ultimoAno = date_format($date, "Y-m-d");//A pedido. los usuarios normales solo podrán ver las resoluciones del ultimo año.
            $limitarAnio = " '$ultimoAno'  <= fecha AND ";
        }
        $desde = $this->request->getPost('nroInicial');
        $hasta = $this->request->getPost('nroFinal');
        if ($this->request->isPost()) {

            $query = Criteria::fromInput($this->di, "Nota", $_POST);
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
                $parameters['conditions'] .= " AND $limitarAnio  nro_resolucion >= $desde AND nro_resolucion <= $hasta";
            else
                $parameters['conditions'] = "$limitarAnio  nro_resolucion >= $desde AND nro_resolucion <= $hasta";
        }
        $resoluciones = Nota::find($parameters);
        if (count($resoluciones) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron resoluciones cargadas en el sistema que coincidan con su búsqueda");
            return $this->response->redirect('resoluciones/index');
        }

        $paginator = new Paginator(array(
            "data" => $resoluciones,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

}
