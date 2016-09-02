<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ExpedienteController extends ControllerBase
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
     * Edits a expediente
     *
     * @param string $id_documento
     */
    public function editAction($id_documento)
    {

        if (!$this->request->isPost()) {

            $expediente = Expediente::findFirstByid_documento($id_documento);
            if (!$expediente) {
                $this->flash->error("expediente was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "expediente",
                    "action" => "index"
                ));
            }

            $this->view->id_documento = $expediente->id_documento;

            $this->tag->setDefault("id_documento", $expediente->getIdDocumento());
            $this->tag->setDefault("expte_cod_anio", $expediente->getExpteCodAnio());
            $this->tag->setDefault("expte_cod_empresa", $expediente->getExpteCodEmpresa());
            $this->tag->setDefault("expte_cod_letra", $expediente->getExpteCodLetra());
            $this->tag->setDefault("expte_cod_numero", $expediente->getExpteCodNumero());
            $this->tag->setDefault("nro_expediente", $expediente->getNroExpediente());
            $this->tag->setDefault("creadopor", $expediente->getCreadopor());
            $this->tag->setDefault("descripcion", $expediente->getDescripcion());
            $this->tag->setDefault("fecha", $expediente->getFecha());
            $this->tag->setDefault("habilitado", $expediente->getHabilitado());
            $this->tag->setDefault("sector_id_oid", $expediente->getSectorIdOid());
            $this->tag->setDefault("tipo", $expediente->getTipo());
            $this->tag->setDefault("ultimo", $expediente->getUltimo());
            $this->tag->setDefault("expediente_ultimaModificacion", $expediente->getExpedienteUltimamodificacion());
            $this->tag->setDefault("expediente_adjunto", $expediente->getExpedienteAdjunto());
            
        }
    }

    /**
     * Creates a new expediente
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "expediente",
                "action" => "index"
            ));
        }

        $expediente = new Expediente();

        $expediente->setExpteCodAnio($this->request->getPost("expte_cod_anio"));
        $expediente->setExpteCodEmpresa($this->request->getPost("expte_cod_empresa"));
        $expediente->setExpteCodLetra($this->request->getPost("expte_cod_letra"));
        $expediente->setExpteCodNumero($this->request->getPost("expte_cod_numero"));
        $expediente->setNroExpediente($this->request->getPost("nro_expediente"));
        $expediente->setCreadopor($this->request->getPost("creadopor"));
        $expediente->setDescripcion($this->request->getPost("descripcion"));
        $expediente->setFecha($this->request->getPost("fecha"));
        $expediente->setHabilitado($this->request->getPost("habilitado"));
        $expediente->setSectorIdOid($this->request->getPost("sector_id_oid"));
        $expediente->setTipo($this->request->getPost("tipo"));
        $expediente->setUltimo($this->request->getPost("ultimo"));
        $expediente->setExpedienteUltimamodificacion($this->request->getPost("expediente_ultimaModificacion"));
        $expediente->setExpedienteAdjunto($this->request->getPost("expediente_adjunto"));
        

        if (!$expediente->save()) {
            foreach ($expediente->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "expediente",
                "action" => "new"
            ));
        }

        $this->flash->success("expediente was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "expediente",
            "action" => "index"
        ));

    }

    /**
     * Saves a expediente edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "expediente",
                "action" => "index"
            ));
        }

        $id_documento = $this->request->getPost("id_documento");

        $expediente = Expediente::findFirstByid_documento($id_documento);
        if (!$expediente) {
            $this->flash->error("expediente does not exist " . $id_documento);

            return $this->dispatcher->forward(array(
                "controller" => "expediente",
                "action" => "index"
            ));
        }

        $expediente->setExpteCodAnio($this->request->getPost("expte_cod_anio"));
        $expediente->setExpteCodEmpresa($this->request->getPost("expte_cod_empresa"));
        $expediente->setExpteCodLetra($this->request->getPost("expte_cod_letra"));
        $expediente->setExpteCodNumero($this->request->getPost("expte_cod_numero"));
        $expediente->setNroExpediente($this->request->getPost("nro_expediente"));
        $expediente->setCreadopor($this->request->getPost("creadopor"));
        $expediente->setDescripcion($this->request->getPost("descripcion"));
        $expediente->setFecha($this->request->getPost("fecha"));
        $expediente->setHabilitado($this->request->getPost("habilitado"));
        $expediente->setSectorIdOid($this->request->getPost("sector_id_oid"));
        $expediente->setTipo($this->request->getPost("tipo"));
        $expediente->setUltimo($this->request->getPost("ultimo"));
        $expediente->setExpedienteUltimamodificacion($this->request->getPost("expediente_ultimaModificacion"));
        $expediente->setExpedienteAdjunto($this->request->getPost("expediente_adjunto"));
        

        if (!$expediente->save()) {

            foreach ($expediente->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "expediente",
                "action" => "edit",
                "params" => array($expediente->id_documento)
            ));
        }

        $this->flash->success("expediente was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "expediente",
            "action" => "index"
        ));

    }

    /**
     * Deletes a expediente
     *
     * @param string $id_documento
     */
    public function deleteAction($id_documento)
    {

        $expediente = Expediente::findFirstByid_documento($id_documento);
        if (!$expediente) {
            $this->flash->error("expediente was not found");

            return $this->dispatcher->forward(array(
                "controller" => "expediente",
                "action" => "index"
            ));
        }

        if (!$expediente->delete()) {

            foreach ($expediente->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "expediente",
                "action" => "search"
            ));
        }

        $this->flash->success("expediente was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "expediente",
            "action" => "index"
        ));
    }
    /* ====================================================
           BUSQUEDAS
       =======================================================*/
    public function listarAction()
    {
        $this->setDatatables();
        $this->view->pick('expediente/search');


        $numberPage = $this->request->getQuery("page", "int");
        $parameters["order"] = "id_documento DESC";

        $expediente = Expediente::find($parameters);
        if (count($expediente) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron expedientes cargadas en el sistema");
            return $this->response->redirect('expediente/index');
        }

        $paginator = new Paginator(array(
            "data" => $expediente,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Searches for expediente
     */
    public function searchAction()
    {
        $this->setDatatables();
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Expediente", $_POST);
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
            $ultimoAno = date_format($date, "Y-m-d");//A pedido. los usuarios normales solo podrán ver las expedientes del ultimo año.
            $limitarAnio = "  '$ultimoAno'  <= fecha ";
        }
        if (isset($parameters['conditions']))
            if ($limitarAnio != "")
                $parameters['conditions'] .= "AND $limitarAnio ";
            else
                if ($limitarAnio != "")
                    $parameters['conditions'] = "$limitarAnio ";

        $parameters["order"] = "id_documento DESC";

        $expediente = Expediente::find($parameters);
        if (count($expediente) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron expedientes cargadas en el sistema que coincidan con su búsqueda");
            return $this->response->redirect('expediente/index');
        }

        $paginator = new Paginator(array(
            "data" => $expediente,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    public function searchEntreFechasAction()
    {
        $this->setDatatables();
        $this->view->pick('expediente/search');
        $numberPage = 1;

        $rol = $this->session->get('auth')['rol_nombre'];
        $limitarAnio = "";
        if ($rol != "ADMINISTRADOR") {
            $date = date_create(date('Y') . '-01-01');
            $ultimoAno = date_format($date, "Y-m-d");//A pedido. los usuarios normales solo podrán ver las expedientes del ultimo año.
            $limitarAnio = "  '$ultimoAno'  <= fecha AND ";
        }
        $desde = $this->request->getPost('fecha_desde');
        $hasta = $this->request->getPost('fecha_hasta');
        if ($this->request->isPost()) {

            $query = Criteria::fromInput($this->di, "Expediente", $_POST);
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
        $expediente = Expediente::find($parameters);
        if (count($expediente) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron expedientes cargadas en el sistema que coincidan con su búsqueda");
            return $this->response->redirect('expediente/index');
        }

        $paginator = new Paginator(array(
            "data" => $expediente,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }


    public function searchEntreNumerosAction()
    {
        $this->setDatatables();
        $this->view->pick('expediente/search');
        $numberPage = 1;

        $rol = $this->session->get('auth')['rol_nombre'];
        $limitarAnio = "";
        if ($rol != "ADMINISTRADOR") {
            $date = date_create(date('Y') . '-01-01');
            $ultimoAno = date_format($date, "Y-m-d");//A pedido. los usuarios normales solo podrán ver las expedientes del ultimo año.
            $limitarAnio = " '$ultimoAno'  <= fecha AND ";
        }
        $desde = $this->request->getPost('nroInicial');
        $hasta = $this->request->getPost('nroFinal');
        if ($this->request->isPost()) {

            $query = Criteria::fromInput($this->di, "Expediente", $_POST);
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
                $parameters['conditions'] .= " AND $limitarAnio  nro_expediente >= $desde AND nro_expediente <= $hasta";
            else
                $parameters['conditions'] = "$limitarAnio  nro_expediente >= $desde AND nro_expediente <= $hasta";
        }
        $expediente = Expediente::find($parameters);
        if (count($expediente) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron expedientes cargadas en el sistema que coincidan con su búsqueda");
            return $this->response->redirect('expediente/index');
        }

        $paginator = new Paginator(array(
            "data" => $expediente,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

}
