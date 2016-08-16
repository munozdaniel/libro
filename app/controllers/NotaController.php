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
        $parameters["order"] = "id_documento DESC";

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
        $parameters["order"] = "id_documento DESC";

        $nota = Nota::find($parameters);
        if (count($nota) == 0) {
            $this->flash->notice("No hay notas cargadas en el sistema");

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
        $this->assets->collection('headerCss')
            ->addCss('plugins/select2/select2.min.css');
        $this->assets->collection('footerJs')
            ->addJs('plugins/select2/select2.full.min.js');
        $this->assets->collection('footerInlineJs')
            ->addInlineJs(' $(".autocompletar").select2();');
        $this->view->form = new NotaForm(null, array('edit' => true));

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
                foreach ($nota->getMessages() as $message) {
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
        $nota->setTipo(1);
        /*Guardamos el adjunto*/
        $nombreCarpeta = 'files/nota/' . date('Ymd') . '/' . $nota->getNroNota();
        $path = $this->guardarAdjunto($this->request->getUploadedFiles(), $nombreCarpeta);
        if ($path == "") {
            $this->flashSession->error("Ocurrió un problema al guardar el archivo adjunto. Edite la nota para volver a adjuntar el archivo.");
        }
        $nota->setAdjunto($path);
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
     * Saves a nota edited
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
        /*Obtenemos el ultimo numero de nota*/
        $ultimo = Nota::findFirst("ultimo=1");
        if (!$ultimo) {
            $nota->setNroNota(1);
            $nota->setUltimo(1);
        } else {
            $ultimo->setUltimo(0);
            if (!$ultimo->update()) {
                $this->db->rollback();
                foreach ($nota->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this->redireccionar('nota/editar/' . $id);
            }
            $nota->setNroNota($ultimo->getNroNota() + 1);
        }

        if (!$form->isValid($data, $nota)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('nota/editar/' . $id);
        }

        /*Guardamos el adjunto*/
        $nombreCarpeta = 'files/nota/' . date('Ymd') . '/' . $nota->getNroNota();
        $path = $this->guardarAdjunto($this->request->getUploadedFiles(), $nombreCarpeta);
        if ($path == "") {
            $this->flash->error("Ocurrió un problema al guardar el archivo adjunto. Edite la nota para volver a adjuntar el archivo.");
        }
        $nota->setAdjunto($path);
        /*Actualizamos los datos*/
        if ($nota->save() == false) {
            $this->db->rollback();
            foreach ($nota->getMessages() as $message) {
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
                $anterior = Nota::findFirst('id_documento=' . $id_documento - 1);
                if (!$anterior) {
                } else {
                    $this->db->begin();
                    $nota->setUltimo(0);
                    $nota->setHabilitado(0);
                    $anterior->setUltimo(1);
                    if (!$nota->update()) {
                        $this->db->rollback();
                        foreach ($nota->getMessages() as $mensaje) {
                            $this->flash->error($mensaje);
                        }
                    } else {
                        if (!$anterior->update()) {
                            $this->db->rollback();
                            foreach ($nota->getMessages() as $mensaje) {
                                $this->flash->error($mensaje);
                            }
                        }
                    }
                    $this->db->commit();
                    $this->flash->success('La nota ' . $nota->getNroNota() . ' ha sido deshabilitada');
                }
            } else {
                /*Si no es el ultimo, se deshabilita*/
                $this->db->begin();
                $nota->setUltimo(0);
                $nota->setHabilitado(0);
                if (!$nota->update()) {
                    $this->db->rollback();
                    foreach ($nota->getMessages() as $mensaje) {
                        $this->flash->error($mensaje);
                    }
                }
                $this->db->commit();
                $this->flash->success('La nota ' . $nota->getNroNota() . ' ha sido deshabilitada');
            }
        }
    }


}
