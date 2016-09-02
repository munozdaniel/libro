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
    }


    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a disposicion
     *
     * @param string $id_documento
     */
    public function editAction($id_documento)
    {

        if (!$this->request->isPost()) {

            $disposicion = Disposicion::findFirstByid_documento($id_documento);
            if (!$disposicion) {
                $this->flash->error("disposicion was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "disposicion",
                    "action" => "index"
                ));
            }

            $this->view->id_documento = $disposicion->id_documento;

            $this->tag->setDefault("id_documento", $disposicion->getIdDocumento());
            $this->tag->setDefault("nro_disposicion", $disposicion->getNroDisposicion());
            $this->tag->setDefault("creadopor", $disposicion->getCreadopor());
            $this->tag->setDefault("descripcion", $disposicion->getDescripcion());
            $this->tag->setDefault("fecha", $disposicion->getFecha());
            $this->tag->setDefault("habilitado", $disposicion->getHabilitado());
            $this->tag->setDefault("sector_id_oid", $disposicion->getSectorIdOid());
            $this->tag->setDefault("tipo", $disposicion->getTipo());
            $this->tag->setDefault("ultimo", $disposicion->getUltimo());
            $this->tag->setDefault("disposicion_adjunto", $disposicion->getDisposicionAdjunto());
            
        }
    }

    /**
     * Creates a new disposicion
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "disposicion",
                "action" => "index"
            ));
        }

        $disposicion = new Disposicion();

        $disposicion->setNroDisposicion($this->request->getPost("nro_disposicion"));
        $disposicion->setCreadopor($this->request->getPost("creadopor"));
        $disposicion->setDescripcion($this->request->getPost("descripcion"));
        $disposicion->setFecha($this->request->getPost("fecha"));
        $disposicion->setHabilitado($this->request->getPost("habilitado"));
        $disposicion->setSectorIdOid($this->request->getPost("sector_id_oid"));
        $disposicion->setTipo($this->request->getPost("tipo"));
        $disposicion->setUltimo($this->request->getPost("ultimo"));
        $disposicion->setDisposicionAdjunto($this->request->getPost("disposicion_adjunto"));
        

        if (!$disposicion->save()) {
            foreach ($disposicion->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "disposicion",
                "action" => "new"
            ));
        }

        $this->flash->success("disposicion was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "disposicion",
            "action" => "index"
        ));

    }

    /**
     * Saves a disposicion edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "disposicion",
                "action" => "index"
            ));
        }

        $id_documento = $this->request->getPost("id_documento");

        $disposicion = Disposicion::findFirstByid_documento($id_documento);
        if (!$disposicion) {
            $this->flash->error("disposicion does not exist " . $id_documento);

            return $this->dispatcher->forward(array(
                "controller" => "disposicion",
                "action" => "index"
            ));
        }

        $disposicion->setNroDisposicion($this->request->getPost("nro_disposicion"));
        $disposicion->setCreadopor($this->request->getPost("creadopor"));
        $disposicion->setDescripcion($this->request->getPost("descripcion"));
        $disposicion->setFecha($this->request->getPost("fecha"));
        $disposicion->setHabilitado($this->request->getPost("habilitado"));
        $disposicion->setSectorIdOid($this->request->getPost("sector_id_oid"));
        $disposicion->setTipo($this->request->getPost("tipo"));
        $disposicion->setUltimo($this->request->getPost("ultimo"));
        $disposicion->setDisposicionAdjunto($this->request->getPost("disposicion_adjunto"));
        

        if (!$disposicion->save()) {

            foreach ($disposicion->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "disposicion",
                "action" => "edit",
                "params" => array($disposicion->id_documento)
            ));
        }

        $this->flash->success("disposicion was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "disposicion",
            "action" => "index"
        ));

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