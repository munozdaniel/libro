<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class NotaController extends ControllerBase
{

    /**
     * Formulario para hacer busquedas
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
        $this->view->form = new NotaForm(null, array('edit' => true));

    }

    /**
     * Muestra un formulario para crear una nota
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
        $this->view->form = new NotaForm(null, array('edit' => true, 'required' => true));

    }

    /**
     * Muestra el formulario para editar una nota
     *
     * @param string $id_documento
     * @return null
     */
    public function editarAction($id_documento)
    {

        $nota = Nota::findFirst(array('id_documento=' . $id_documento));
        if (!$nota) {
            $this->flash->error("La nota no se encontró");
            return $this->redireccionar("nota/search");
        }
        $this->view->nota = $nota;
        $this->view->form = new NotaForm($nota, array('edit' => true, 'required' => true));


    }

    /**
     * guarda una nota nueva
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->redireccionar("nota/listar");
        }
        $this->db->begin();

        $form = new NotaForm;
        $nota = new Nota();
        // Recuperamos los datos por post y seteanmos la entidad
        $data = $this->request->getPost();
        $form->bind($data, $nota);
        /*Obtenemos el ultimo numero de nota*/
        $ultimo = Nota::findFirst("ultimo=1");
        if (!$ultimo) {
            $nota->setNroNota(1);
            $nota->setUltimo(1);
        } else {
            $ultimo->setUltimo(0);
            if (!$ultimo->update()) {
                $this->db->rollback();
                foreach ($ultimo->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this->redireccionar('nota/new');
            }
            $nota->setNroNota($ultimo->getNroNota() + 1);
            $nota->setUltimo(1);

        }
        /*Validamos el formulario*/
        if (!$form->isValid()) {
            $this->db->rollback();
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('nota/new');
        }
        /*Seteamos los campos faltantes*/
        $nota->setHabilitado(1);
        $nota->setDescripcion(mb_strtoupper($nota->getDescripcion()));
        $nota->setDestino(mb_strtoupper($nota->getDestino()));
        $nota->setTipo(1);
        /*Guardamos el adjunto*/
        $archivos = $this->request->getUploadedFiles();
        if ($archivos[0]->getName() != "") {

            $nombreCarpeta = 'files/nota/' . date('Ymd') . '/' . $nota->getNroNota();
            $path = $this->guardarAdjunto($archivos, $nombreCarpeta);
            if ($path == "") {
                $this->flashSession->error("Edite la nota para volver a adjuntar el archivo.");
            }
            else{
                $nota->setNotaAdjunto($path);
            }
        }
        /*Guardamos la instancia en la bd*/
        if ($nota->save() == false) {
            $this->db->rollback();
            foreach ($nota->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('nota/new');
        }

        $form->clear();
        $this->db->commit();
        $this->flashSession->success("La Nota ha sido creada correctamente");
        return $this->response->redirect('nota/listar');
    }

    /**
     * Guarda los datos de la nota editada
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->redireccionar("nota/listar");
        }

        $id = $this->request->getPost("id_documento", "int");

        $nota = Nota::findFirst("id_documento=" . $id);
        if (!$nota) {
            $this->flash->error("La nota no pudo ser editada.");
            return $this->redireccionar("nota/listar");
        }
        $this->db->begin();

        /*Validamos el formulario*/
        $form = new NotaForm;
        $this->view->form = $form;
        $data = $this->request->getPost();
        $form->bind($data, $nota);
        /*Validamos el formulario*/
        if (!$form->isValid()) {
            $this->db->rollback();
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('nota/editar/' . $id);
        }

        /*Guardamos el adjunto*/
        $archivos = $this->request->getUploadedFiles();
        if ($archivos[0]->getName() != "") {
            $nombreCarpeta = 'files/nota/' . date('Ymd') . '/' . $nota->getNroNota();
            $path = $this->guardarAdjunto($this->request->getUploadedFiles(), $nombreCarpeta);
            if ($path == "") {
                $this->flash->error("Ocurrió un problema al guardar el archivo adjunto. Edite la nota para volver a adjuntar el archivo.");
            }
            $nota->setNotaAdjunto($path);
        }
        /*Actualizamos los datos*/
        $nota->setDescripcion(mb_strtoupper($nota->getDescripcion()));
        $nota->setDestino(mb_strtoupper($nota->getDestino()));
        if ($nota->save() == false) {
            $this->db->rollback();
            foreach ($nota->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('nota/editar/' . $id);
        }

        $form->clear();

        $this->db->commit();
        $this->flashSession->success("La Nota ha sido actualizada correctamente");
        return $this->response->redirect('nota/listar');
    }


    /**
     * Muestra los datos de la nota y ofrece las operaciones que se pueden realizar sobre la nota.
     * @param $id_documento
     * @return null
     */
    public function verAction($id_documento)
    {

        $nota = Nota::findFirst(array('id_documento=' . $id_documento));
        if (!$nota) {
            $this->flash->error("La nota no se encontró");
            return $this->redireccionar("nota/listar");
        }
        $this->view->nota = $nota;
        $this->view->form = new NotaForm($nota, array('edit' => true, 'readOnly' => true, 'required' => true));

    }

    /**
     * Pregunta si esta seguro de eliminar la nota
     * @param $id_documento
     * @return null
     */
    public function eliminarAction($id_documento)
    {
        $nota = Nota::findFirst('id_documento=' . $id_documento);
        if (!$nota) {
            $this->flashSession->error("La nota no se encontró");
            return $this->response->redirect("nota/listar");
        }
        if ($nota->getHabilitado() == 0) {
            $this->flashSession->warning("La nota ya fue eliminada");
            return $this->response->redirect("nota/listar");
        }
        $this->view->id_documento = $id_documento;
    }


    /**
     * Elimina la nota de manera logica
     * Si es la ultima nota: la nota anterior  debera convertirse en la ultima para que la numeracion continue.
     * (debe ser del mismo año que la nota a eliminar)
     * Si no es la ultima nota: se la deshabilita nada mas.
     * @return null
     */
    public function eliminarLogicoAction()
    {
        if ($this->request->isPost()) {
            $id_documento = $this->request->getPost('id_documento', 'int');

            $nota = Nota::findFirst('id_documento=' . $id_documento);
            if (!$nota) {
                $this->flashSession->warning("La nota no se encontró");
                return $this->response->redirect("nota/listar");
            }
            $this->db->begin();
            if ($nota->getUltimo() == 1) {

                /*Si es el ultimo, al anteultimo se lo deja ultimo, para que el
                 siguiente que se agregue continue con la numeracion*/
                //Buscamos el anterior habilitado
                $band = true;
                $date = DateTime::createFromFormat("Y-m-d", $nota->getFecha());
                $anioNota = $date->format("Y");
                $id = $id_documento;
                while ($band) {
                    $id_anterior = ($id - 1);
                    $anterior = Nota::findFirst('id_documento=' . $id_anterior . " AND fecha BETWEEN '$anioNota-01-01' AND '$anioNota-12-31'");
                    if (!$anterior)//Si no existe anterior, entonces empezaria en 0 la siguiente nota que se ingrese
                    {
                        $band = false;//Corta el bucle
                    } else {
                        if ($anterior->getHabilitado() == 1) {
                            $band = false;
                            $anterior->setUltimo(1);
                            if (!$anterior->update()) {
                                $this->db->rollback();
                                foreach ($anterior->getMessages() as $mensaje) {
                                    $this->flash->error($mensaje);
                                }
                                return $this->redireccionar('nota/eliminar/' . $id_documento);
                            }
                        }
                    }
                    $id = ($id - 1);
                }
                $nota->setUltimo(0);
                $nota->setHabilitado(0);
                if (!$nota->update()) {
                    $this->db->rollback();
                    foreach ($nota->getMessages() as $mensaje) {
                        $this->flash->error($mensaje);
                    }
                    return $this->redireccionar('nota/eliminar/' . $id_documento);
                }
                $this->db->commit();
                $this->flash->success('La nota ' . $nota->getNroNota() . ' ha sido deshabilitada');

            } else {
                /*Si no es el ultimo, se deshabilita*/
                $nota->setUltimo(0);
                $nota->setHabilitado(0);
                if (!$nota->update()) {
                    $this->db->rollback();
                    foreach ($nota->getMessages() as $mensaje) {
                        $this->flash->error($mensaje);
                    }
                    return $this->redireccionar('nota/eliminar/' . $id_documento);
                }
                $this->db->commit();
                $this->flashSession->success('La nota ' . $nota->getNroNota() . ' ha sido deshabilitada');
            }
        }
        return $this->response->redirect("nota/listar");
    }

    /* ====================================================
        BUSQUEDAS
    =======================================================*/
    public function listarAction()
    {
        $this->setDatatables();
        $this->view->pick('nota/search');


        $numberPage = $this->request->getQuery("page", "int");
        $parameters["order"] = "id_documento DESC";

        $nota = Nota::find($parameters);
        if (count($nota) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron notas cargadas en el sistema");
            return $this->response->redirect('nota/index');
        }

        $paginator = new Paginator(array(
            "data" => $nota,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Searches for nota
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
            $ultimoAno = date_format($date, "Y-m-d");//A pedido. los usuarios normales solo podrán ver las notas del ultimo año.
            $limitarAnio = "  '$ultimoAno'  <= fecha ";
        }
        if (isset($parameters['conditions']))
            if ($limitarAnio != "")
                $parameters['conditions'] .= "AND $limitarAnio ";
            else
                if ($limitarAnio != "")
                    $parameters['conditions'] = "$limitarAnio ";

        $parameters["order"] = "id_documento DESC";

        $nota = Nota::find($parameters);
        if (count($nota) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron notas cargadas en el sistema que coincidan con su búsqueda");
            return $this->response->redirect('nota/index');
        }

        $paginator = new Paginator(array(
            "data" => $nota,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    public function searchEntreFechasAction()
    {
        $this->setDatatables();
        $this->view->pick('nota/search');
        $numberPage = 1;

        $rol = $this->session->get('auth')['rol_nombre'];
        $limitarAnio = "";
        if ($rol != "ADMINISTRADOR") {
            $date = date_create(date('Y') . '-01-01');
            $ultimoAno = date_format($date, "Y-m-d");//A pedido. los usuarios normales solo podrán ver las notas del ultimo año.
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
        $nota = Nota::find($parameters);
        if (count($nota) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron notas cargadas en el sistema que coincidan con su búsqueda");
            return $this->response->redirect('nota/index');
        }

        $paginator = new Paginator(array(
            "data" => $nota,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Busqueda entre 2 nros
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function searchEntreNumerosAction()
    {
        $this->setDatatables();
        $this->view->pick('nota/search');
        $numberPage = 1;

        $rol = $this->session->get('auth')['rol_nombre'];
        $limitarAnio = "";
        if ($rol != "ADMINISTRADOR") {
            $date = date_create(date('Y') . '-01-01');
            $ultimoAno = date_format($date, "Y-m-d");//A pedido. los usuarios normales solo podrán ver las notas del ultimo año.
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
                $parameters['conditions'] .= " AND $limitarAnio  nro_nota >= $desde AND nro_nota <= $hasta";
            else
                $parameters['conditions'] = "$limitarAnio  nro_nota >= $desde AND nro_nota <= $hasta";
        }
        $nota = Nota::find($parameters);
        if (count($nota) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron notas cargadas en el sistema que coincidan con su búsqueda");
            return $this->response->redirect('nota/index');
        }

        $paginator = new Paginator(array(
            "data" => $nota,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Listar Las Notas
     */
    public function listarDataAction()
    {
        $this->setDatatables();

    }

    /**
     * Paginado del lado del servidor. Filtro y orden dinamico.
     */
    public function listarDataAjaxAction()
    {
        $this->view->disable();
        $select = array('N.nro_nota','DATE_FORMAT( fecha,  \'%d/%m/%Y\' ) AS fecha','S.sector_nombre','N.destino','N.descripcion','N.habilitado','N.id_documento');
        $from = array('N' => 'Nota','S'=>'Sectores');
        if( $this->session->get('auth')['rol_id']==2)//Administrador
        {
            $where = 'S.sector_id=N.sector_id_oid ';
        }
        else
        {
            $ultimo_anio= date('Y');
            $desde = $ultimo_anio."-01-01";
            $hasta = date('Y-m-d');
            $where = "S.sector_id=N.sector_id_oid AND N.habilitado=1 AND (fecha BETWEEN '$desde' AND '$hasta')";
        }
        $order_default = "id_documento DESC";
        $columnas_dt = array(
            array('data'=>'nro_nota', 'db' => 'nro_nota', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '$'.number_format($d);
                } ),
            array('data'=>'fecha', 'db' => 'fecha',  'dt' => 1,
                'formatter' => function( $d, $row ) {
                    return date( 'd/M/Y', strtotime($d));
                } ),
            array('data'=>'sector_nombre', 'db' => 'sector_nombre',   'dt' => 2 ),
            array('data'=>'destino', 'db' => 'destino',     'dt' => 3 ),
            array('data'=>'descripcion', 'db' => 'descripcion',     'dt' => 4 )
        );
        $retorno = ServerSide::simpleQuery($this->request,$this->modelsManager,$select,$from,$where,$order_default,$columnas_dt);
        echo json_encode($retorno);
        return;
    }




}
