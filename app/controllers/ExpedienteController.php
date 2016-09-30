<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ExpedienteController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Expediente');
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
        $this->view->form = new ExpedienteForm(null, array('edit' => true));
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
        $this->view->form = new ExpedienteForm(null, array('edit' => true, 'required' => true));
    }
    /**
     * Creates a new expediente
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->redireccionar("expediente/listar");
        }
        $this->db->begin();

        $form = new ExpedienteForm();
        $documento = new Expediente();
        // Recuperamos los datos por post y seteanmos la entidad
        $data = $this->request->getPost();
        $form->bind($data, $documento);
        /*Obtenemos el ultimo numero de expediente*/
        $ultimo = Expediente::findFirst("ultimo=1");
        if (!$ultimo) {
            $documento->setNroExpediente(1);
            $documento->setUltimo(1);
        } else {
            $ultimo->setUltimo(0);
            if (!$ultimo->update()) {
                $this->db->rollback();
                foreach ($ultimo->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this->redireccionar('expediente/new');
            }
            $documento->setNroExpediente($ultimo->getNroExpediente() + 1);
            $documento->setUltimo(1);

        }
        /*Validamos el formulario*/
        if (!$form->isValid()) {
            $this->db->rollback();
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('expediente/new');
        }
        /*Seteamos los campos faltantes*/
        $documento->setHabilitado(1);
        $documento->setTipo(5);
        $documento->setExpteCodAnio(date('Y'));
        $documento->setExpteCodEmpresa("IMPS");
        $documento->setExpteCodLetra(mb_strtoupper($documento->getExpteCodLetra()));
        $documento->setDescripcion(mb_strtoupper($documento->getDescripcion()));
        $documento->setExpteCodNumero($documento->getNroExpediente());
        /*Guardamos el adjunto*/
        $archivos = $this->request->getUploadedFiles();
        if ($archivos[0]->getName() != "") {

            $nombreCarpeta = 'files/expediente/' . date('Ymd') . '/' . $documento->getNroExpediente();
            $path = $this->guardarAdjunto($archivos, $nombreCarpeta);
            if ($path == "") {
                $this->flashSession->error("Edite el expediente para volver a adjuntar el archivo.");
            }
            else{
                $documento->setExpedienteAdjunto($path);
            }
        }
        /*Guardamos la instancia en la bd*/
        if ($documento->save() == false) {
            $this->db->rollback();
            foreach ($documento->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('expediente/new');
        }

        $form->clear();
        $this->db->commit();
        $this->flashSession->success("El Expediente ha sido creada correctamente");
        return $this->response->redirect('expediente/listarData');

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
        $documento = Expediente::findFirst(array('id_documento=' . $id_documento));
        if (!$documento) {
            $this->flash->error("El expediente no se encontró");
            return $this->redireccionar("expediente/search");
        }
        $this->view->expediente = $documento;
        $this->view->form = new ExpedienteForm($documento, array('edit' => true, 'required' => true));
    }

    /**
     * Saves a expediente edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->redireccionar("expediente/listar");
        }

        $id = $this->request->getPost("id_documento", "int");

        $documento = Expediente::findFirst("id_documento=" . $id);
        if (!$documento) {
            $this->flash->error("El expediente no pudo ser editada.");
            return $this->redireccionar("expediente/listarData");
        }
        $this->db->begin();

        /*Validamos el formulario*/
        $form = new ExpedienteForm;
        $this->view->form = $form;
        $data = $this->request->getPost();
        $form->bind($data, $documento);
        /*Validamos el formulario*/
        if (!$form->isValid()) {
            $this->db->rollback();
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('expediente/editar/' . $id);
        }

        /*Guardamos el adjunto*/
        $archivos = $this->request->getUploadedFiles();
        if ($archivos[0]->getName() != "") {
            $nombreCarpeta = 'files/expediente/' . date('Ymd') . '/' . $documento->getNroExpediente();
            $path = $this->guardarAdjunto($this->request->getUploadedFiles(), $nombreCarpeta);
            if ($path == "") {
                $this->flash->error("Ocurrió un problema al guardar el archivo adjunto. Edite el expediente para volver a adjuntar el archivo.");
            }
            $documento->setExpedienteAdjunto($path);
        }
        /*Actualizamos los datos*/
        //$documento->setExpteCodAnio(date('Y'));
        //$documento->setExpteCodEmpresa("IMPS");
        $documento->setExpteCodLetra(mb_strtoupper($documento->getExpteCodLetra()));
        $documento->setDescripcion(mb_strtoupper($documento->getDescripcion()));
        //$documento->setExpteCodNumero($documento->getNroExpediente());
        if ($documento->save() == false) {
            $this->db->rollback();
            foreach ($documento->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('expediente/editar/' . $id);
        }

        $form->clear();

        $this->db->commit();
        $this->flashSession->success("El Expediente ha sido actualizada correctamente");
        return $this->response->redirect('expediente/listarData');

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
            $this->flash->error("El expediente no se encontró");

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

    /**
     * Muestra los datos del expediente y ofrece las operaciones que se pueden realizar sobre la misma.
     * @param $id_documento
     * @return null
     */
    public function verAction($id_documento)
    {

        $documento = Expediente::findFirst(array('id_documento=' . $id_documento));
        if (!$documento) {
            $this->flash->error("El expediente no se encontró");
            return $this->redireccionar("expediente/listarData");
        }
        $this->view->expediente = $documento;
        $this->view->form = new ExpedienteForm($documento, array('edit' => true, 'readOnly' => true, 'required' => true));

    }
    /**
     * Pregunta si esta seguro de eliminar el expediente
     * @param $id_documento
     * @return null
     */
    public function eliminarAction($id_documento)
    {
        $documento = Expediente::findFirst('id_documento=' . $id_documento);
        if (!$documento) {
            $this->flashSession->error("La expediente no se encontró");
            return $this->response->redirect("expediente/listar");
        }
        if ($documento->getHabilitado() == 0) {
            $this->flashSession->warning("La expediente ya fue eliminada");
            return $this->response->redirect("expediente/listarData");
        }
        $this->view->id_documento = $id_documento;
    }


    /**
     * Elimina el expediente de manera logica
     * Si es la ultima expediente: el expediente anterior  debera convertirse en la ultima para que la numeracion continue.
     * (debe ser del mismo año que el expediente a eliminar)
     * Si no es la ultima expediente: se la deshabilita nada mas.
     * @return null
     */
    public function eliminarLogicoAction()
    {
        if ($this->request->isPost()) {
            $id_documento = $this->request->getPost('id_documento', 'int');

            $documento = Expediente::findFirst('id_documento=' . $id_documento);
            if (!$documento) {
                $this->flashSession->warning("La Expediente no se encontró");
                return $this->response->redirect("expediente/listarData");
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
                    $anterior = Expediente::findFirst('id_documento=' . $id_anterior . " AND fecha BETWEEN '$anio-01-01' AND '$anio-12-31'");
                    if (!$anterior)//Si no existe anterior, entonces empezaria en 0 la siguiente expediente que se ingrese
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
                                return $this->redireccionar('expediente/eliminar/' . $id_documento);
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
                    return $this->redireccionar('expediente/eliminar/' . $id_documento);
                }
                $this->db->commit();
                $this->flash->success('El Expediente ' . $documento->getNroExpediente() . ' ha sido deshabilitada');

            } else {
                /*Si no es el ultimo, se deshabilita*/
                $documento->setUltimo(0);
                $documento->setHabilitado(0);
                if (!$documento->update()) {
                    $this->db->rollback();
                    foreach ($documento->getMessages() as $mensaje) {
                        $this->flash->error($mensaje);
                    }
                    return $this->redireccionar('expediente/eliminar/' . $id_documento);
                }
                $this->db->commit();
                $this->flashSession->success('El Expediente ' . $documento->getNroExpediente() . ' ha sido deshabilitada');
            }
        }
        return $this->response->redirect("expediente/listarData");
    }


    /**
     * Searches for expediente
     */
    public function searchAction()
    {
        $this->setDatatables();
        $numberPage = 1;
        if ($this->request->isPost()) {
            $_POST['descripcion'] = strtoupper($_POST['descripcion']);
            $_POST['expte_cod_letra'] = strtoupper($_POST['expte_cod_letra']);
            if ($this->request->getPost('nro_expediente_final', 'int') == null) {
                $_POST['nro_expediente']=$this->request->getPost('nro_expediente_inicial', 'int');
            }
            if ($this->request->getPost('fecha_final') == null) {
                $_POST['fecha']=$this->request->getPost('fecha_inicial');
            }
            $query = Criteria::fromInput($this->di, "Expediente", $_POST);
            if ($this->request->getPost('nro_expediente_final', 'int') != null
                && $this->request->getPost('nro_expediente_inicial', 'int') != null) {
                $query->andWhere('nro_expediente BETWEEN '. $this->request->getPost('nro_expediente_inicial', 'int') ." AND ". $this->request->getPost('nro_expediente_final', 'int'));
            }
            if ($this->request->getPost('fecha_final') != null) {
                if($this->request->getPost('fecha_inicial') != null) {
                    $query->betweenWhere('fecha', $this->request->getPost('fecha_inicial'), $this->request->getPost('fecha_final'));
                }
                else
                {
                    $this->flashSession->error("Verifique que la fecha inicial y final estén correctamente ingresadas");
                    return $this->response->redirect('expediente/index');
                }
            }
            $rol_id = $this->session->get('auth')['rol_id'];
            if($rol_id != 2 )
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


    /**
     * Listar Expedientes
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
        $select = array('E.nro_expediente','DATE_FORMAT( E.fecha,  \'%d/%m/%Y\' ) AS fecha','S.sector_nombre AS origen','E.expte_cod_empresa AS empresa','E.expte_cod_letra AS letra','E.expte_cod_anio AS anio','E.descripcion','E.habilitado','E.id_documento');
        $from = array('E' => 'Expediente','S'=>'Sectores');
        if( $this->session->get('auth')['rol_id']==2)//Administrador
        {
            $where = 'S.sector_id=E.sector_id_oid ';
        }
        else
        {
            $ultimo_anio= date('Y');
            $desde = $ultimo_anio."-01-01";
            $hasta = date('Y-m-d');
            $where = "S.sector_id=E.sector_id_oid AND E.habilitado=1 AND (E.fecha BETWEEN '$desde' AND '$hasta')";
        }
        $order_default = "id_documento DESC";
        $columnas_dt = array(
            array('data'=>'nro_expediente', 'db' => 'E.nro_expediente', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '$'.number_format($d);
                } ),
            array('data'=>'fecha', 'db' => 'F.fecha',  'dt' => 1,
                'formatter' => function( $d, $row ) {
                    return date( 'd/M/Y', strtotime($d));
                } ),
            array('data'=>'origen', 'db' => 'S.sector_nombre',   'dt' => 2 ),
            array('data'=>'empresa', 'db' => 'E.expte_cod_empresa',   'dt' => 2 ),
            array('data'=>'letra', 'db' => 'E.expte_cod_letra',   'dt' => 2 ),
            array('data'=>'anio', 'db' => 'E.expte_cod_anio',   'dt' => 2 ),
            array('data'=>'descripcion', 'db' => 'E.descripcion',     'dt' => 4 )
        );
        $retorno = ServerSide::simpleQuery($this->request,$this->modelsManager,$select,$from,$where,$order_default,$columnas_dt);
        echo json_encode($retorno);
        return;
    }
}
