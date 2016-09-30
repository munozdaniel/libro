<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class MemoController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Memo');
        $this->importarFechaFirefox();
        parent::initialize();
    }
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
        $this->view->form = new MemoForm(null, array('edit' => true));

        $memo = Memo::find();
        $this->view->memo = $memo;
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
        $memo = Memo::findFirst(array('id_documento=' . $id_documento));
        if (!$memo) {
            $this->flash->error("El memo no se encontró");
            return $this->redireccionar("memo/search");
        }
        $this->view->memo = $memo;
        $this->view->form = new MemoForm($memo, array('edit' => true, 'required' => true));

    }

    /**
     * Guardar un nuevo memo
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->redireccionar("memo/listarData");
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

            if ($memo->getDestinosectorIdOid() == 1)
                if (trim($this->request->getPost('otrodestino')) != "")
                    $memo->setOtrodestino(mb_strtoupper($this->request->getPost('otrodestino')));
                else {
                    $this->flash->error("Ingrese otro destino");
                    $form->clear(array('destinosector_id_oid'));
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
                } else {
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
            return $this->response->redirect('memo/listarData');
        }
    }

    /**
     * Saves a memo edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->redireccionar("memo/listarData");
        }

        $id = $this->request->getPost("id_documento", "int");

        $memo = Memo::findFirst("id_documento=" . $id);
        if (!$memo) {
            $this->flash->error("El memo no pudo ser editado.");
            return $this->redireccionar("memo/listarData");

        }
        $this->db->begin();
        /*Validamos el formulario*/
        $form = new MemoForm;
        $this->view->form = $form;
        $data = $this->request->getPost();
        $form->bind($data, $memo);
        /*Validamos el formulario*/
        if (!$form->isValid()) {
            $this->db->rollback();
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('memo/editar/' . $id);
        }
        /*Guardamos el adjunto*/
        $archivos = $this->request->getUploadedFiles();
        if ($archivos[0]->getName() != "") {
            $nombreCarpeta = 'files/memo/' . date('Ymd') . '/' . $memo->getNroMemo();
            $path = $this->guardarAdjunto($this->request->getUploadedFiles(), $nombreCarpeta);
            if ($path == "") {
                $this->flash->error("Ocurrió un problema al guardar el archivo adjunto. Edite el memo para volver a adjuntar el archivo.");
            }
            $memo->setMemoAdjunto($path);
        }
        /*Actualizamos los datos*/
        $memo->setDescripcion(mb_strtoupper($memo->getDescripcion()));
        if ($memo->getDestinosectorIdOid() == 1)
            $memo->setOtrodestino(mb_strtoupper($memo->getOtrodestino()));

        if ($memo->save() == false) {
            $this->db->rollback();
            foreach ($memo->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('memo/editar/' . $id);
        }

        $form->clear();

        $this->db->commit();
        $this->flashSession->success("El Memo ha sido actualizado correctamente");
        return $this->response->redirect('memo/listarData');

    }

    public function verAction($id_documento)
    {
        $this->assets->collection('headerCss')
            ->addCss('plugins/select2/select2.min.css');
        $this->assets->collection('footerJs')
            ->addJs('plugins/select2/select2.full.min.js');
        $this->assets->collection('footerInlineJs')
            ->addInlineJs('
            $(".autocompletar").select2();

            ');
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
            return $this->response->redirect("memo/listarData");
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
        return $this->response->redirect("memo/listarData");
    }

    /**
     * Busqueda de memos
     */
    public function searchAction()
    {
        $this->setDatatables();

        $numberPage = 1;
        if ($this->request->isPost()) {
            $_POST['descripcion'] = strtoupper($_POST['descripcion']);
            $_POST['otrodestino'] = strtoupper($_POST['otrodestino']);
            if ($this->request->getPost('nro_memo_final', 'int') == null) {
                $_POST['nro_memo']=$this->request->getPost('nro_memo_inicial', 'int');
            }
            if ($this->request->getPost('fecha_final') == null) {
                $_POST['fecha']=$this->request->getPost('fecha_inicial');
            }
            $query = Criteria::fromInput($this->di, "Memo", $_POST);

            if ($this->request->getPost('nro_memo_final', 'int') != null
                && $this->request->getPost('nro_memo_inicial', 'int') != null) {
                $query->andWhere('nro_memo BETWEEN '. $this->request->getPost('nro_memo_inicial', 'int') ." AND ". $this->request->getPost('nro_memo_final', 'int'));
            }
            if ($this->request->getPost('fecha_final') != null) {
                if($this->request->getPost('fecha_inicial') != null) {
                    $query->betweenWhere('fecha', $this->request->getPost('fecha_inicial'), $this->request->getPost('fecha_final'));
                }
                else
                {
                    $this->flashSession->error("Verifique que la fecha inicial y final estén correctamente ingresadas");
                    return $this->response->redirect('memo/index');
                }
            }
            $rol_id = $this->session->get('auth')['rol_id'];
            if($rol_id != 2 )//2:Administrador
            {
                //Los que no son ADMIN solo pueden ver los doc del ultimo año. Y los habilitados
                $date = date_create(date('Y') . '-01-01');
                $ultimoAnio = date_format($date, "Y-m-d");//A pedido. los usuarios normales solo podrán ver las expedientes del ultimo año.
                $query->andWhere(" '$ultimoAnio' <= fecha AND habilitado=1 ");
            }
            //var_dump($query->getParams());
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }

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
     * Listar Memo
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
        /*
            SELECT M.nro_memo, M.fecha, S.sector_nombre, SS.sector_nombre,IF(M.destinosector_id_oid= 1, M.otrodestino, SS.sector_nombre) as DESTINY, M.descripcion
            FROM `memo` AS M, gestionusuarios.sectores AS S, gestionusuarios.sectores AS SS
            WHERE S.sector_id=M.sector_id_oid
            AND SS.sector_id=M.destinosector_id_oid
         */
        $this->view->disable();
        $select = array('M.nro_memo', 'DATE_FORMAT( M.fecha,  \'%d/%m/%Y\' ) AS fecha', 'S.sector_nombre AS origen',
            'IF(M.destinosector_id_oid= 1, M.otrodestino, SS.sector_nombre) as destino',
            'M.descripcion', 'M.habilitado', 'M.id_documento');
        $from = array('M' => 'Memo', 'S' => 'Sectores', 'SS' => 'Sectores');
        if ($this->session->get('auth')['rol_id'] == 2)//Administrador
        {
            $where = 'S.sector_id=M.sector_id_oid
            AND SS.sector_id=M.destinosector_id_oid ';
        } else {
            $ultimo_anio = date('Y');
            $desde = $ultimo_anio . "-01-01";
            $hasta = date('Y-m-d');
            $where = "S.sector_id=M.sector_id_oid
            AND SS.sector_id=M.destinosector_id_oid AND M.habilitado=1 AND (M.fecha BETWEEN '$desde' AND '$hasta')";
        }
        $order_default = "id_documento DESC";
        $columnas_dt = array(
            array('data' => 'nro_memo','db' => 'nro_memo', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return '$' . number_format($d);
                }),
            array('data' => 'fecha','db' => 'fecha', 'dt' => 1,
                'formatter' => function ($d, $row) {
                    return date('d/M/Y', strtotime($d));
                }),
            array('data' => 'origen','db' => 'S.sector_nombre', 'dt' => 2),
            array('data' => 'destino','db' => 'SS.sector_nombre', 'dt' => 3),
            array('data' => 'descripcion','db' => 'descripcion', 'dt' => 4)
        );
        $request = $this->request;
        $modelManager = $this->modelsManager;
        $retorno = ServerSide::simpleQuery($request, $modelManager, $select, $from, $where, $order_default, $columnas_dt);
        echo json_encode($retorno);
        return;
    }
}
