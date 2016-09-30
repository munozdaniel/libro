<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class DisposicionController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Disposicion');
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
        $this->view->form = new DisposicionForm(null, array('edit' => true));    }


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
        $this->view->form = new DisposicionForm(null, array('edit' => true, 'required' => true));

    }
    /**
     * Creates a new disposicion
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->redireccionar("disposicion/listarData");
        }
        $this->db->begin();

        $form = new DisposicionForm();
        $documento = new Disposicion();
        // Recuperamos los datos por post y seteanmos la entidad
        $data = $this->request->getPost();
        $form->bind($data, $documento);
        /*Obtenemos el ultimo numero de disposicion*/
        $ultimo = Disposicion::findFirst("ultimo=1");
        if (!$ultimo) {
            $documento->setNroDisposicion(1);
            $documento->setUltimo(1);
        } else {
            $ultimo->setUltimo(0);
            if (!$ultimo->update()) {
                $this->db->rollback();
                foreach ($ultimo->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this->redireccionar('disposicion/new');
            }
            $documento->setNroDisposicion($ultimo->getNroDisposicion() + 1);
            $documento->setUltimo(1);

        }
        /*Validamos el formulario*/
        if (!$form->isValid()) {
            $this->db->rollback();
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('disposicion/new');
        }
        /*Seteamos los campos faltantes*/
        $documento->setHabilitado(1);
        $documento->setDescripcion(mb_strtoupper($documento->getDescripcion()));
        $documento->setTipo(4);
        /*Guardamos el adjunto*/
        $archivos = $this->request->getUploadedFiles();
        if ($archivos[0]->getName() != "") {

            $nombreCarpeta = 'files/disposicion/' . date('Ymd') . '/' . $documento->getNroDisposicion();
            $path = $this->guardarAdjunto($archivos, $nombreCarpeta);
            if ($path == "") {
                $this->flashSession->error("Edite la disposicion para volver a adjuntar el archivo.");
            }
            else{
                $documento->setDisposicionAdjunto($path);
            }
        }
        /*Guardamos la instancia en la bd*/
        if ($documento->save() == false) {
            $this->db->rollback();
            foreach ($documento->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('disposicion/new');
        }

        $form->clear();
        $this->db->commit();
        $this->flashSession->success("La Disposicion ha sido creada correctamente");
        return $this->response->redirect('disposicion/listarData');

    }

    /**
     * Edits a expediente
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
        $documento = Disposicion::findFirst(array('id_documento=' . $id_documento));
        if (!$documento) {
            $this->flash->error("La disposicion no se encontró");
            return $this->redireccionar("disposicion/search");
        }
        $this->view->disposicion = $documento;
        $this->view->form = new DisposicionForm($documento, array('edit' => true, 'required' => true));
    }
    /**
     * Saves a disposicione edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->redireccionar("disposicion/listarData");
        }

        $id = $this->request->getPost("id_documento", "int");

        $documento = Disposicion::findFirst("id_documento=" . $id);
        if (!$documento) {
            $this->flash->error("La disposicion no pudo ser editada.");
            return $this->redireccionar("disposicion/listar");
        }
        $this->db->begin();

        /*Validamos el formulario*/
        $form = new DisposicionForm;
        $this->view->form = $form;
        $data = $this->request->getPost();
        $form->bind($data, $documento);
        /*Validamos el formulario*/
        if (!$form->isValid()) {
            $this->db->rollback();
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('disposicion/editar/' . $id);
        }

        /*Guardamos el adjunto*/
        $archivos = $this->request->getUploadedFiles();
        if ($archivos[0]->getName() != "") {
            $nombreCarpeta = 'files/disposicion/' . date('Ymd') . '/' . $documento->getNroDisposicion();
            $path = $this->guardarAdjunto($this->request->getUploadedFiles(), $nombreCarpeta);
            if ($path == "") {
                $this->flash->error("Ocurrió un problema al guardar el archivo adjunto. Edite la disposicion para volver a adjuntar el archivo.");
            }
            $documento->setDisposicionAdjunto($path);
        }
        /*Actualizamos los datos*/
        $documento->setDescripcion(mb_strtoupper($documento->getDescripcion()));
        if ($documento->save() == false) {
            $this->db->rollback();
            foreach ($documento->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('disposicion/editar/' . $id);
        }

        $form->clear();

        $this->db->commit();
        $this->flashSession->success("La Disposicion ha sido actualizada correctamente");
        return $this->response->redirect('disposicion/listarData');

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
    /**
     * Muestra los datos de la disposicion y ofrece las operaciones que se pueden realizar sobre la misma.
     * @param $id_documento
     * @return null
     */
    public function verAction($id_documento)
    {

        $documento = Disposicion::findFirst(array('id_documento=' . $id_documento));
        if (!$documento) {
            $this->flash->error("La disposicion no se encontró");
            return $this->redireccionar("disposicion/listarData");
        }
        $this->view->disposicion = $documento;
        $this->view->form = new DisposicionForm($documento, array('edit' => true, 'readOnly' => true, 'required' => true));

    }

    /**
     * Pregunta si esta seguro de eliminar la disposicion
     * @param $id_documento
     * @return null
     */
    public function eliminarAction($id_documento)
    {
        $documento = Disposicion::findFirst('id_documento=' . $id_documento);
        if (!$documento) {
            $this->flashSession->error("La disposicion no se encontró");
            return $this->response->redirect("disposicion/listarData");
        }
        if ($documento->getHabilitado() == 0) {
            $this->flashSession->warning("La disposicion ya fue eliminada");
            return $this->response->redirect("disposicion/listarData");
        }
        $this->view->id_documento = $id_documento;
    }


    /**
     * Elimina la disposicion de manera logica
     * Si es la ultima disposicion: la disposicion anterior  debera convertirse en la ultima para que la numeracion continue.
     * (debe ser del mismo año que la disposicion a eliminar)
     * Si no es la ultima disposicion: se la deshabilita nada mas.
     * @return null
     */
    public function eliminarLogicoAction()
    {
        if ($this->request->isPost()) {
            $id_documento = $this->request->getPost('id_documento', 'int');

            $documento = Disposicion::findFirst('id_documento=' . $id_documento);
            if (!$documento) {
                $this->flashSession->warning("La Disposicion no se encontró");
                return $this->response->redirect("disposicion/listarData");
            }
            $this->db->begin();
            if ($documento->getUltimo() == 1) {

                /*Si es el ultimo, al anteultimo se lo deja ultimo, para que el
                 siguiente que se agregue continue con la numeracion*/
                //Buscamos el anterior habilitado
                $band = true;
                $date = DateTime::createFromFormat("Y-m-d", $documento->getFecha());
                $anio = $date->format("Y");
                $id = $id_documento;
                while ($band) {
                    $id_anterior = ($id - 1);
                    $anterior = Disposicion::findFirst('id_documento=' . $id_anterior . " AND fecha BETWEEN '$anio-01-01' AND '$anio-12-31'");
                    if (!$anterior)//Si no existe anterior, entonces empezaria en 0 la siguiente disposicion que se ingrese
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
                                return $this->redireccionar('disposicion/eliminar/' . $id_documento);
                            }
                        }
                    }
                    $id = ($id - 1);
                }
                $documento->setUltimo(0);
                $documento->setHabilitado(0);
                if (!$documento->update()) {
                    $this->db->rollback();
                    foreach ($documento->getMessages() as $mensaje) {
                        $this->flash->error($mensaje);
                    }
                    return $this->redireccionar('disposicion/eliminar/' . $id_documento);
                }
                $this->db->commit();
                $this->flash->success('La disposicion ' . $documento->getNroDisposicion() . ' ha sido deshabilitada');

            } else {
                /*Si no es el ultimo, se deshabilita*/
                $documento->setUltimo(0);
                $documento->setHabilitado(0);
                if (!$documento->update()) {
                    $this->db->rollback();
                    foreach ($documento->getMessages() as $mensaje) {
                        $this->flash->error($mensaje);
                    }
                    return $this->redireccionar('disposicion/eliminar/' . $id_documento);
                }
                $this->db->commit();
                $this->flashSession->success('La disposicion ' . $documento->getNroDisposicion() . ' ha sido deshabilitada');
            }
        }
        return $this->response->redirect("disposicion/listarData");
    }

    /**
     * Searches for disposicion
     */
    public function searchAction()
    {
        $this->setDatatables();
        $numberPage = 1;
        if ($this->request->isPost()) {
            $_POST['descripcion'] = strtoupper($_POST['descripcion']);
            if ($this->request->getPost('nro_disposicion_final', 'int') == null) {
                $_POST['nro_disposicion']=$this->request->getPost('nro_disposicion_inicial', 'int');
            }
            if ($this->request->getPost('fecha_final') == null) {
                $_POST['fecha']=$this->request->getPost('fecha_inicial');
            }
            $query = Criteria::fromInput($this->di, "Disposicion", $_POST);
            if ($this->request->getPost('nro_disposicion_final', 'int') != null
                && $this->request->getPost('nro_disposicion_inicial', 'int') != null) {
                $query->andWhere('nro_disposicion BETWEEN '. $this->request->getPost('nro_disposicion_inicial', 'int') ." AND ". $this->request->getPost('nro_disposicion_final', 'int'));
            }
            if ($this->request->getPost('fecha_final') != null) {
                if($this->request->getPost('fecha_inicial') != null) {
                    $query->betweenWhere('fecha', $this->request->getPost('fecha_inicial'), $this->request->getPost('fecha_final'));
                }
                else
                {
                    $this->flashSession->error("Verifique que la fecha inicial y final estén correctamente ingresadas");
                    return $this->response->redirect('disposicion/index');
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

    /**
     * Listar Las Disposiciones
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
        $select = array('D.nro_disposicion','DATE_FORMAT( D.fecha,  \'%d/%m/%Y\' ) AS fecha','S.sector_nombre AS origen','D.descripcion','D.habilitado','D.id_documento');
        $from = array('D' => 'Disposicion','S'=>'Sectores');
        if( $this->session->get('auth')['rol_id']==2)//Administrador
        {
            $where = 'S.sector_id=D.sector_id_oid ';
        }
        else
        {
            $ultimo_anio= date('Y');
            $desde = $ultimo_anio."-01-01";
            $hasta = date('Y-m-d');
            $where = "S.sector_id=D.sector_id_oid AND D.habilitado=1 AND (D.fecha BETWEEN '$desde' AND '$hasta')";
        }
        $order_default = "id_documento DESC";
        $columnas_dt = array(
            array('data'=>'nro_disposicion', 'db' => 'D.nro_disposicion', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '$'.number_format($d);
                } ),
            array('data'=>'origen', 'db' => 'S.sector_nombre',   'dt' => 2 ),
            array('data'=>'fecha', 'db' => 'F.fecha',  'dt' => 1,
                'formatter' => function( $d, $row ) {
                    return date( 'd/M/Y', strtotime($d));
                } ),
            array('data'=>'descripcion', 'db' => 'D.descripcion',     'dt' => 4 )
        );
        $retorno = ServerSide::simpleQuery($this->request,$this->modelsManager,$select,$from,$where,$order_default,$columnas_dt);
        echo json_encode($retorno);
        return;
    }
}
