<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class NotaController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
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
        $parameters["order"] = "id_documento";

        $nota = Nota::find($parameters);
        if (count($nota) == 0) {
            $this->flash->notice("The search did not find any nota");

            return $this->dispatcher->forward(array(
                "controller" => "nota",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $nota,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a nota
     *
     * @param string $id_documento
     */
    public function editAction($id_documento)
    {

        if (!$this->request->isPost()) {

            $nota = Nota::findFirstByid_documento($id_documento);
            if (!$nota) {
                $this->flash->error("nota was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "nota",
                    "action" => "index"
                ));
            }

            $this->view->id_documento = $nota->id_documento;

            $this->tag->setDefault("id_documento", $nota->getIdDocumento());
            $this->tag->setDefault("destino", $nota->getDestino());
            $this->tag->setDefault("nro_nota", $nota->getNroNota());
            $this->tag->setDefault("adjunto", $nota->getAdjunto());
            $this->tag->setDefault("adjuntar", $nota->getAdjuntar());
            $this->tag->setDefault("adjuntar_0", $nota->getAdjuntar0());
            $this->tag->setDefault("creadopor", $nota->getCreadopor());
            $this->tag->setDefault("descripcion", $nota->getDescripcion());
            $this->tag->setDefault("fecha", $nota->getFecha());
            $this->tag->setDefault("habilitado", $nota->getHabilitado());
            $this->tag->setDefault("sector_id_oid", $nota->getSectorIdOid());
            $this->tag->setDefault("tipo", $nota->getTipo());
            $this->tag->setDefault("ultimo", $nota->getUltimo());
            $this->tag->setDefault("ultimodelanio", $nota->getUltimodelanio());
            $this->tag->setDefault("version", $nota->getVersion());
            $this->tag->setDefault("nro", $nota->getNro());
            $this->tag->setDefault("nota_ultimaModificacion", $nota->getNotaUltimamodificacion());
            $this->tag->setDefault("nota_sectorOrigenId", $nota->getNotaSectororigenid());
            $this->tag->setDefault("nota_adjunto", $nota->getNotaAdjunto());

        }
    }

    /**
     * Creates a new nota
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "nota",
                "action" => "index"
            ));
        }

        $nota = new Nota();

        $nota->setDestino($this->request->getPost("destino"));
        $nota->setNroNota($this->request->getPost("nro_nota"));
        $nota->setAdjunto($this->request->getPost("adjunto"));
        $nota->setAdjuntar($this->request->getPost("adjuntar"));
        $nota->setAdjuntar0($this->request->getPost("adjuntar_0"));
        $nota->setCreadopor($this->request->getPost("creadopor"));
        $nota->setDescripcion($this->request->getPost("descripcion"));
        $nota->setFecha($this->request->getPost("fecha"));
        $nota->setHabilitado($this->request->getPost("habilitado"));
        $nota->setSectorIdOid($this->request->getPost("sector_id_oid"));
        $nota->setTipo($this->request->getPost("tipo"));
        $nota->setUltimo($this->request->getPost("ultimo"));
        $nota->setUltimodelanio($this->request->getPost("ultimodelanio"));
        $nota->setVersion($this->request->getPost("version"));
        $nota->setNro($this->request->getPost("nro"));
        $nota->setNotaUltimamodificacion($this->request->getPost("nota_ultimaModificacion"));
        $nota->setNotaSectororigenid($this->request->getPost("nota_sectorOrigenId"));
        $nota->setNotaAdjunto($this->request->getPost("nota_adjunto"));


        if (!$nota->save()) {
            foreach ($nota->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "nota",
                "action" => "new"
            ));
        }

        $this->flash->success("nota was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "nota",
            "action" => "index"
        ));

    }

    /**
     * Saves a nota edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "nota",
                "action" => "index"
            ));
        }

        $id_documento = $this->request->getPost("id_documento");

        $nota = Nota::findFirstByid_documento($id_documento);
        if (!$nota) {
            $this->flash->error("nota does not exist " . $id_documento);

            return $this->dispatcher->forward(array(
                "controller" => "nota",
                "action" => "index"
            ));
        }

        $nota->setDestino($this->request->getPost("destino"));
        $nota->setNroNota($this->request->getPost("nro_nota"));
        $nota->setAdjunto($this->request->getPost("adjunto"));
        $nota->setAdjuntar($this->request->getPost("adjuntar"));
        $nota->setAdjuntar0($this->request->getPost("adjuntar_0"));
        $nota->setCreadopor($this->request->getPost("creadopor"));
        $nota->setDescripcion($this->request->getPost("descripcion"));
        $nota->setFecha($this->request->getPost("fecha"));
        $nota->setHabilitado($this->request->getPost("habilitado"));
        $nota->setSectorIdOid($this->request->getPost("sector_id_oid"));
        $nota->setTipo($this->request->getPost("tipo"));
        $nota->setUltimo($this->request->getPost("ultimo"));
        $nota->setUltimodelanio($this->request->getPost("ultimodelanio"));
        $nota->setVersion($this->request->getPost("version"));
        $nota->setNro($this->request->getPost("nro"));
        $nota->setNotaUltimamodificacion($this->request->getPost("nota_ultimaModificacion"));
        $nota->setNotaSectororigenid($this->request->getPost("nota_sectorOrigenId"));
        $nota->setNotaAdjunto($this->request->getPost("nota_adjunto"));


        if (!$nota->save()) {

            foreach ($nota->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "nota",
                "action" => "edit",
                "params" => array($nota->id_documento)
            ));
        }

        $this->flash->success("nota was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "nota",
            "action" => "index"
        ));

    }

    /**
     * Deletes a nota
     *
     * @param string $id_documento
     */
    public function deleteAction($id_documento)
    {

        $nota = Nota::findFirstByid_documento($id_documento);
        if (!$nota) {
            $this->flash->error("nota was not found");

            return $this->dispatcher->forward(array(
                "controller" => "nota",
                "action" => "index"
            ));
        }

        if (!$nota->delete()) {

            foreach ($nota->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "nota",
                "action" => "search"
            ));
        }

        $this->flash->success("nota was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "nota",
            "action" => "index"
        ));
    }

    public function verAction($id_documento)
    {

        $nota = Nota::findFirst(array('id_documento='.$id_documento));
        if (!$nota) {
            $this->flash->error("La nota no se encontró");
            return $this->redireccionar("nota/search");
        }
        $this->view->nota_id= $nota->getIdDocumento();
        $this->view->form = new NotaForm($nota, array('edit' => true,'readOnly'=>'true'));

    }
}
