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
        $this->view->form = new MemoForm(null, array('edit' => true, 'required' => true));
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
     * Guardar un nuevo memo
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->redireccionar("memo/listar");
        }
        $this->db->begin();
        $form = new MemoForm;
        $memo = new Memo();
        // Recuperamos los datos por post y seteanmos la entidad
        $data = $this->request->getPost();
        $form->bind($data, $memo);
        /*Obtenemos el ultimo numero de memo*/
        $ultimo = Memo::findFirst("ultimo=1");
        if (!$ultimo) {
            $memo->setNroMemo(1);
            $memo->setUltimo(1);
        } else {
            $ultimo->setUltimo(0);
            if (!$ultimo->update()) {
                $this->db->rollback();
                foreach ($ultimo->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this->redireccionar('memo/new');
            }
            $memo->setNroMemo($ultimo->getNroMemo() + 1);
            $memo->setUltimo(1);
            /*Validamos el formulario*/
            if (!$form->isValid()) {
                $this->db->rollback();
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this->redireccionar('memo/new');
            }
            /*Seteamos los campos faltantes*/
            $memo->setHabilitado(1);
            $memo->setDescripcion(mb_strtoupper($memo->getDescripcion()));
            if($memo->getDestinosectorIdOid()==1)
                if(trim($memo->getOtrodestino())!="")
                    $memo->setOtrodestino(mb_strtoupper($memo->getOtrodestino()));
                else
                {
                    $this->flash->error("Ingrese el destino");
                    return $this->redireccionar('memo/new');
                }
            else
                $memo->setOtrodestino(null);
            $memo->setTipo(2);
            /*Guardamos el adjunto*/
            $archivos = $this->request->getUploadedFiles();
            if ($archivos[0]->getName() != "") {
                $nombreCarpeta = 'files/memo/' . date('Ymd') . '/' . $memo->getNroMemo();
                $path = $this->guardarAdjunto($archivos, $nombreCarpeta);
                if ($path == "") {
                    $this->flashSession->error("Edite el memo para volver a adjuntar el archivo.");
                }
                else {
                    $memo->setMemoAdjunto($path);
                }
            }
            /*Guardamos la instancia en la bd*/
            if ($memo->save() == false) {
                $this->db->rollback();
                foreach ($memo->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this->redireccionar('memo/new');
            }

            $form->clear();
            $this->db->commit();
            $this->flashSession->success("El Memo ha sido creado correctamente");
            return $this->response->redirect('memo/listar');
        }
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
    public function verAction($id_documento)
    {
        $memo = Memo::findFirst(array('id_documento=' . $id_documento));
        if (!$memo) {
            $this->flash->error("El memo no se encontró");
            return $this->redireccionar("memo/listar");
        }
        $this->view->memo = $memo;
        $this->view->form = new MemoForm($memo, array('edit' => true, 'readOnly' => true, 'required' => true));

    }
    /**
     * Pregunta si esta seguro de eliminar la memo
     * @param $id_documento
     * @return null
     */
    public function eliminarAction($id_documento)
    {
        $memo = Memo::findFirst('id_documento=' . $id_documento);
        if (!$memo) {
            $this->flashSession->error("El memo no se encontró");
            return $this->response->redirect("memo/listar");
        }
        if ($memo->getHabilitado() == 0) {
            $this->flashSession->warning("El memo ya fue eliminado");
            return $this->response->redirect("memo/listar");
        }
        $this->view->id_documento = $id_documento;
    }


    /**
     * Elimina la memo de manera logica
     * Si es la ultima memo: la memo anterior  debera convertirse en la ultima para que la numeracion continue.
     * (debe ser del mismo año que la memo a eliminar)
     * Si no es la ultima memo: se la deshabilita nada mas.
     * @return null
     */
    public function eliminarLogicoAction()
    {
        if ($this->request->isPost()) {
            $id_documento = $this->request->getPost('id_documento', 'int');

            $memo = Memo::findFirst('id_documento=' . $id_documento);
            if (!$memo) {
                $this->flashSession->warning("El memo no se encontró");
                return $this->response->redirect("memo/listar");
            }
            $this->db->begin();
            if ($memo->getUltimo() == 1) {

                /*Si es el ultimo, al anteultimo se lo deja ultimo, para que el
                 siguiente que se agregue continue con la numeracion*/
                //Buscamos el anterior habilitado
                $band = true;
                $date = DateTime::createFromFormat("Y-m-d", $memo->getFecha());
                $anio = $date->format("Y");
                $id = $id_documento;
                while ($band) {
                    $id_anterior = ($id - 1);
                    $anterior = Memo::findFirst('id_documento=' . $id_anterior . " AND fecha BETWEEN '$anio-01-01' AND '$anio-12-31'");
                    if (!$anterior)//Si no existe anterior, entonces empezaria en 0 la siguiente memo que se ingrese
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
                                return $this->redireccionar('memo/eliminar/' . $id_documento);
                            }
                        }
                    }
                    $id = ($id - 1);
                }
                $memo->setUltimo(0);
                $memo->setHabilitado(0);
                if (!$memo->update()) {
                    $this->db->rollback();
                    foreach ($memo->getMessages() as $mensaje) {
                        $this->flash->error($mensaje);
                    }
                    return $this->redireccionar('memo/eliminar/' . $id_documento);
                }
                $this->db->commit();
                $this->flash->success('El memo ' . $memo->getNroMemo() . ' ha sido deshabilitado');

            } else {
                /*Si no es el ultimo, se deshabilita*/
                $memo->setUltimo(0);
                $memo->setHabilitado(0);
                if (!$memo->update()) {
                    $this->db->rollback();
                    foreach ($memo->getMessages() as $mensaje) {
                        $this->flash->error($mensaje);
                    }
                    return $this->redireccionar('memo/eliminar/' . $id_documento);
                }
                $this->db->commit();
                $this->flashSession->success('El memo ' . $memo->getNroMemo() . ' ha sido deshabilitado');
            }
        }
        return $this->response->redirect("memo/listar");
    }
    /* ====================================================
           BUSQUEDAS
       =======================================================*/
    public function listarAction()
    {
        $this->setDatatables();
        $this->view->pick('memo/search');


        $numberPage = $this->request->getQuery("page", "int");
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
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Busqueda de memos
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
            "limit" => 10,
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
            $ultimoAno = date_format($date, "Y-m-d");//A pedido. los usuarios normales solo podrán ver las memos del ultimo año.
            $limitarAnio = " '$ultimoAno'  <= fecha AND ";
        }
        $desde = $this->request->getPost('nroInicial');
        $hasta = $this->request->getPost('nroFinal');
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
                $parameters['conditions'] .= " AND $limitarAnio  nro_memo >= $desde AND nro_memo <= $hasta";
            else
                $parameters['conditions'] = "$limitarAnio  nro_memo >= $desde AND nro_memo <= $hasta";
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

}
