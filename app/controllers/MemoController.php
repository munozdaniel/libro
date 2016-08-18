<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class MemoController extends ControllerBase
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
     * Edits a memo
     *
     * @param string $id_documento
     */
    public function editAction($id_documento)
    {

        if (!$this->request->isPost()) {

            $memo = Memo::findFirstByid_documento($id_documento);
            if (!$memo) {
                $this->flash->error("memo was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "memo",
                    "action" => "index"
                ));
            }

            $this->view->id_documento = $memo->id_documento;

            $this->tag->setDefault("id_documento", $memo->getIdDocumento());
            $this->tag->setDefault("destinosector_id_oid", $memo->getDestinosectorIdOid());
            $this->tag->setDefault("nro_memo", $memo->getNroMemo());
            $this->tag->setDefault("otrodestino", $memo->getOtrodestino());
            $this->tag->setDefault("adjunto", $memo->getAdjunto());
            $this->tag->setDefault("adjuntar", $memo->getAdjuntar());
            $this->tag->setDefault("adjuntar_0", $memo->getAdjuntar0());
            $this->tag->setDefault("creadopor", $memo->getCreadopor());
            $this->tag->setDefault("descripcion", $memo->getDescripcion());
            $this->tag->setDefault("fecha", $memo->getFecha());
            $this->tag->setDefault("habilitado", $memo->getHabilitado());
            $this->tag->setDefault("sector_id_oid", $memo->getSectorIdOid());
            $this->tag->setDefault("tipo", $memo->getTipo());
            $this->tag->setDefault("ultimo", $memo->getUltimo());
            $this->tag->setDefault("ultimodelanio", $memo->getUltimodelanio());
            $this->tag->setDefault("version", $memo->getVersion());
            $this->tag->setDefault("nro", $memo->getNro());
            $this->tag->setDefault("memo_adjunto", $memo->getMemoAdjunto());
            $this->tag->setDefault("memo_ultimaModificacion", $memo->getMemoUltimamodificacion());
            
        }
    }

    /**
     * Creates a new memo
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "memo",
                "action" => "index"
            ));
        }

        $memo = new Memo();

        $memo->setDestinosectorIdOid($this->request->getPost("destinosector_id_oid"));
        $memo->setNroMemo($this->request->getPost("nro_memo"));
        $memo->setOtrodestino($this->request->getPost("otrodestino"));
        $memo->setAdjunto($this->request->getPost("adjunto"));
        $memo->setAdjuntar($this->request->getPost("adjuntar"));
        $memo->setAdjuntar0($this->request->getPost("adjuntar_0"));
        $memo->setCreadopor($this->request->getPost("creadopor"));
        $memo->setDescripcion($this->request->getPost("descripcion"));
        $memo->setFecha($this->request->getPost("fecha"));
        $memo->setHabilitado($this->request->getPost("habilitado"));
        $memo->setSectorIdOid($this->request->getPost("sector_id_oid"));
        $memo->setTipo($this->request->getPost("tipo"));
        $memo->setUltimo($this->request->getPost("ultimo"));
        $memo->setUltimodelanio($this->request->getPost("ultimodelanio"));
        $memo->setVersion($this->request->getPost("version"));
        $memo->setNro($this->request->getPost("nro"));
        $memo->setMemoAdjunto($this->request->getPost("memo_adjunto"));
        $memo->setMemoUltimamodificacion($this->request->getPost("memo_ultimaModificacion"));
        

        if (!$memo->save()) {
            foreach ($memo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "memo",
                "action" => "new"
            ));
        }

        $this->flash->success("memo was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "memo",
            "action" => "index"
        ));

    }

    /**
     * Saves a memo edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "memo",
                "action" => "index"
            ));
        }

        $id_documento = $this->request->getPost("id_documento");

        $memo = Memo::findFirstByid_documento($id_documento);
        if (!$memo) {
            $this->flash->error("memo does not exist " . $id_documento);

            return $this->dispatcher->forward(array(
                "controller" => "memo",
                "action" => "index"
            ));
        }

        $memo->setDestinosectorIdOid($this->request->getPost("destinosector_id_oid"));
        $memo->setNroMemo($this->request->getPost("nro_memo"));
        $memo->setOtrodestino($this->request->getPost("otrodestino"));
        $memo->setAdjunto($this->request->getPost("adjunto"));
        $memo->setAdjuntar($this->request->getPost("adjuntar"));
        $memo->setAdjuntar0($this->request->getPost("adjuntar_0"));
        $memo->setCreadopor($this->request->getPost("creadopor"));
        $memo->setDescripcion($this->request->getPost("descripcion"));
        $memo->setFecha($this->request->getPost("fecha"));
        $memo->setHabilitado($this->request->getPost("habilitado"));
        $memo->setSectorIdOid($this->request->getPost("sector_id_oid"));
        $memo->setTipo($this->request->getPost("tipo"));
        $memo->setUltimo($this->request->getPost("ultimo"));
        $memo->setUltimodelanio($this->request->getPost("ultimodelanio"));
        $memo->setVersion($this->request->getPost("version"));
        $memo->setNro($this->request->getPost("nro"));
        $memo->setMemoAdjunto($this->request->getPost("memo_adjunto"));
        $memo->setMemoUltimamodificacion($this->request->getPost("memo_ultimaModificacion"));
        

        if (!$memo->save()) {

            foreach ($memo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "memo",
                "action" => "edit",
                "params" => array($memo->id_documento)
            ));
        }

        $this->flash->success("memo was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "memo",
            "action" => "index"
        ));

    }

    /**
     * Deletes a memo
     *
     * @param string $id_documento
     */
    public function deleteAction($id_documento)
    {

        $memo = Memo::findFirstByid_documento($id_documento);
        if (!$memo) {
            $this->flash->error("memo was not found");

            return $this->dispatcher->forward(array(
                "controller" => "memo",
                "action" => "index"
            ));
        }

        if (!$memo->delete()) {

            foreach ($memo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "memo",
                "action" => "search"
            ));
        }

        $this->flash->success("memo was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "memo",
            "action" => "index"
        ));
    }
    /* ====================================================
           BUSQUEDAS
       =======================================================*/
    public function listarAction()
    {
        $this->setDatatables();
        $this->view->pick('memo/search');


        $numberPage = $this->request->getQuery("page", "int");
        $parameters["order"] = "id_documento DESC";

        $nota = Memo::find($parameters);
        if (count($nota) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron memo cargados en el sistema que coincidan con su búsqueda");
            return $this->response->redirect('memo/index');
        }

        $paginator = new Paginator(array(
            "data" => $nota,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Busqueda de notas
     */
    public function searchAction()
    {
        $this->setDatatables();

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Memo", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        /*Control de visualizacion por rol*/
        $rol = $this->session->get('auth')['rol_nombre'];
        $limitarAnio = "";
        if ($rol != "ADMINISTRADOR") {
            $date = date_create(date('Y') . '-01-01');
            $ultimoAno = date_format($date, "Y-m-d");//A pedido. los usuarios normales solo podrán ver los memos del ultimo año.
            $limitarAnio = "  '$ultimoAno'  <= fecha ";
        }
        if (isset($parameters['conditions']))
            if ($limitarAnio != "")
                $parameters['conditions'] .= "AND $limitarAnio ";
            else
                if ($limitarAnio != "")
                    $parameters['conditions'] = "$limitarAnio ";

        $parameters["order"] = "id_documento DESC";

        $memo = Memo::find($parameters);
        if (count($memo) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron memo cargados en el sistema que coincidan con su búsqueda");
            return $this->response->redirect('memo/index');
        }

        $paginator = new Paginator(array(
            "data" => $memo,
            "limit"=> 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
    public function searchEntreFechasAction()
    {
        $this->setDatatables();
        $this->view->pick('memo/search');
        $numberPage = 1;

        $rol = $this->session->get('auth')['rol_nombre'];
        $limitarAnio = "";
        if ($rol != "ADMINISTRADOR") {
            $date = date_create(date('Y') . '-01-01');
            $ultimoAno = date_format($date, "Y-m-d");//A pedido. los usuarios normales solo podrán ver los memo del ultimo año.
            $limitarAnio = "  '$ultimoAno'  <= fecha AND ";
        }
        $desde = $this->request->getPost('fecha_desde');
        $hasta = $this->request->getPost('fecha_hasta');
        if ($this->request->isPost()) {

            $query = Criteria::fromInput($this->di, "Memo", $_POST);
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
        $memo = Memo::find($parameters);
        if (count($memo) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron memo cargados en el sistema que coincidan con su búsqueda");
            return $this->response->redirect('memo/index');
        }

        $paginator = new Paginator(array(
            "data" => $memo,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }


    public function searchEntreNumerosAction()
    {
        $this->setDatatables();
        $this->view->pick('memo/search');
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
                $parameters['conditions'] .= " AND $limitarAnio  nro_memo >= $desde AND nro_nota <= $hasta";
            else
                $parameters['conditions'] = "$limitarAnio  nro_memo >= $desde AND nro_nota <= $hasta";
        }
        $memo = Memo::find($parameters);
        if (count($memo) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron memo cargados en el sistema que coincidan con su búsqueda");
            return $this->response->redirect('nota/index');
        }

        $paginator = new Paginator(array(
            "data" => $memo,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

}