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

    public function listarAction()
    {
        $this->setDatatables();
        $this->view->pick('nota/search');


        $numberPage = $this->request->getQuery("page", "int");
        $parameters["order"] = "fecha DESC";

        $nota = Nota::find($parameters);
        if (count($nota) == 0) {
            $this->flash->notice("The search did not find any nota");

            return $this->dispatcher->redireccionar(array(
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

            return $this->dispatcher->redireccionar(array(
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
    public function editarAction($id_documento)
    {

        $nota = Nota::findFirst(array('id_documento=' . $id_documento));
        if (!$nota) {
            $this->flash->error("La nota no se encontró");
            return $this->redireccionar("nota/search");
        }
        $this->view->nota_id = $nota->getIdDocumento();
        $this->view->form = new NotaForm($nota, array('edit' => true, 'required' => true));


    }

    /**
     * Creates a new nota
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->redireccionar(array(
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

            return $this->dispatcher->redireccionar(array(
                "controller" => "nota",
                "action" => "new"
            ));
        }

        $this->flash->success("nota was created successfully");

        return $this->dispatcher->redireccionar(array(
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
            return $this->redireccionar("nota/search");
        }

        $id = $this->request->getPost("id_documento", "int");

        $product = Nota::findFirst("id_documento=" . $id);
        if (!$product) {
            $this->flash->error("La nota no pudo ser editada.");
            return $this->redireccionar("nota/search");
        }

        $form = new NotaForm;
        $this->view->form = $form;

        $data = $this->request->getPost();

        if (!$form->isValid($data, $product)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('nota/editar/' . $id);
        }

        if ($product->save() == false) {
            foreach ($product->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('nota/editar/' . $id);
        }

        $form->clear();

        $this->flash->success("La nota ha sido actualizada correctamente");
        return $this->redireccionar("nota/search");
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

            return $this->dispatcher->redireccionar(array(
                "controller" => "nota",
                "action" => "index"
            ));
        }

        if (!$nota->delete()) {

            foreach ($nota->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->redireccionar(array(
                "controller" => "nota",
                "action" => "search"
            ));
        }

        $this->flash->success("nota was deleted successfully");

        return $this->dispatcher->redireccionar(array(
            "controller" => "nota",
            "action" => "index"
        ));
    }

    public function verAction($id_documento)
    {

        $nota = Nota::findFirst(array('id_documento=' . $id_documento));
        if (!$nota) {
            $this->flash->error("La nota no se encontró");
            return $this->redireccionar("nota/listar");
        }
        $this->view->nota_id = $nota->getIdDocumento();
        $this->view->form = new NotaForm($nota, array('edit' => true, 'readOnly' => true, 'required' => true));

    }

    public function eliminarAction($id_documento)
    {
        $this->view->id_documento = $id_documento;
    }

    public function eliminarLogicoAction()
    {
        if ($this->request->isPost()) {
            $id_documento = $this->request->getPost('id_documento', 'int');
            $nota = Nota::findFirst('id_documento=' . $id_documento);
            if (!$nota) {
                $this->flash->error("La nota no se encontró");
                return $this->redireccionar("nota/listar");
            }
            //TODO: Habria que controlar concurrencia?
            if ($nota->getUltimo() == 1) {
                /*Si es el ultimo, al anteultimo se lo deja ultimo, para que el
                 siguiente que se agregue continue con la numeracion*/
                $anterior = Nota::findFirst('id_documento=' . $id_documento-1);
                if (!$anterior) {
                }else
                {
                    $this->db->begin();
                    $nota->setUltimo(0);
                    $nota->setHabilitado(0);
                    $anterior->setUltimo(1);
                    if(!$nota->update())
                    {
                        $this->db->rollback();
                        foreach($nota->getMessages() as $mensaje){
                            $this->flash->error($mensaje);
                        }
                    }
                    else{
                        if(!$anterior->update())
                        {
                            $this->db->rollback();
                            foreach($nota->getMessages() as $mensaje){
                                $this->flash->error($mensaje);
                            }
                        }
                    }
                    $this->db->commit();
                    $this->flash->success('La nota '.$nota->getNroNota().' ha sido deshabilitada');
                }
            } else {
                /*Si no es el ultimo, se deshabilita*/
                $this->db->begin();
                $nota->setUltimo(0);
                $nota->setHabilitado(0);
                if(!$nota->update())
                {
                    $this->db->rollback();
                    foreach($nota->getMessages() as $mensaje){
                        $this->flash->error($mensaje);
                    }
                }
                $this->db->commit();
                $this->flash->success('La nota '.$nota->getNroNota().' ha sido deshabilitada');
            }
        }
    }


}
