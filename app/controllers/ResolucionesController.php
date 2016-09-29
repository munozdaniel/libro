<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ResolucionesController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Resolucion');
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
        $this->view->form = new ResolucionesForm(null, array('edit' => true));
    }




    /**
     * Muestra un formulario para crear una resolucion
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
        $this->view->form = new ResolucionesForm(null, array('edit' => true, 'required' => true));

    }

    /**
     * guarda una resoluciones nueva
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->redireccionar("resoluciones/listar");
        }
        $this->db->begin();

        $form = new ResolucionesForm();
        $documento = new Resoluciones();
        // Recuperamos los datos por post y seteanmos la entidad
        $data = $this->request->getPost();
        $form->bind($data, $documento);
        /*Obtenemos el ultimo numero de resoluciones*/
        $ultimo = Resoluciones::findFirst("ultimo=1");
        if (!$ultimo) {
            $documento->setNroResolucion(1);
            $documento->setUltimo(1);
        } else {
            $ultimo->setUltimo(0);
            if (!$ultimo->update()) {
                $this->db->rollback();
                foreach ($ultimo->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this->redireccionar('resoluciones/new');
            }
            $documento->setNroResolucion($ultimo->getNroResolucion() + 1);
            $documento->setUltimo(1);

        }
        /*Validamos el formulario*/
        if (!$form->isValid()) {
            $this->db->rollback();
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('resoluciones/new');
        }
        /*Seteamos los campos faltantes*/
        $documento->setHabilitado(1);
        $documento->setDescripcion(mb_strtoupper($documento->getDescripcion()));
        $documento->setTipo(3);
        /*Guardamos el adjunto*/
        $archivos = $this->request->getUploadedFiles();
        if ($archivos[0]->getName() != "") {

            $nombreCarpeta = 'files/resoluciones/' . date('Ymd') . '/' . $documento->getNroResolucion();
            $path = $this->guardarAdjunto($archivos, $nombreCarpeta);
            if ($path == "") {
                $this->flashSession->error("Edite la resoluciones para volver a adjuntar el archivo.");
            }
            else{
                $documento->setResolucionesAdjunto($path);
            }
        }
        /*Guardamos la instancia en la bd*/
        if ($documento->save() == false) {
            $this->db->rollback();
            foreach ($documento->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('resoluciones/new');
        }

        $form->clear();
        $this->db->commit();
        $this->flashSession->success("La Resolucion ha sido creada correctamente");
        return $this->response->redirect('resoluciones/listarData');
    }
    /**
     * Edits a resolucione
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
        $documento = Resoluciones::findFirst(array('id_documento=' . $id_documento));
        if (!$documento) {
            $this->flash->error("La resolucion no se encontró");
            return $this->redireccionar("resoluciones/search");
        }
        $this->view->resoluciones = $documento;
        $this->view->form = new ResolucionesForm($documento, array('edit' => true, 'required' => true));
    }
    /**
     * Saves a resolucione edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->redireccionar("resoluciones/listarData");
        }

        $id = $this->request->getPost("id_documento", "int");

        $documento = Resoluciones::findFirst("id_documento=" . $id);
        if (!$documento) {
            $this->flash->error("La resolucion no pudo ser editada.");
            return $this->redireccionar("resoluciones/listarData");
        }
        $this->db->begin();

        /*Validamos el formulario*/
        $form = new ResolucionesForm;
        $this->view->form = $form;
        $data = $this->request->getPost();
        $form->bind($data, $documento);
        /*Validamos el formulario*/
        if (!$form->isValid()) {
            $this->db->rollback();
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('resoluciones/editar/' . $id);
        }

        /*Guardamos el adjunto*/
        $archivos = $this->request->getUploadedFiles();
        if ($archivos[0]->getName() != "") {
            $nombreCarpeta = 'files/resoluciones/' . date('Ymd') . '/' . $documento->getNroResolucion();
            $path = $this->guardarAdjunto($this->request->getUploadedFiles(), $nombreCarpeta);
            if ($path == "") {
                $this->flash->error("Ocurrió un problema al guardar el archivo adjunto. Edite la resolucion para volver a adjuntar el archivo.");
            }
            $documento->setResolucionesAdjunto($path);
        }
        /*Actualizamos los datos*/
        $documento->setDescripcion(mb_strtoupper($documento->getDescripcion()));
        if ($documento->save() == false) {
            $this->db->rollback();
            foreach ($documento->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->redireccionar('resoluciones/editar/' . $id);
        }

        $form->clear();

        $this->db->commit();
        $this->flashSession->success("La Resolucion ha sido actualizada correctamente");
        return $this->response->redirect('resoluciones/listarData');

    }

    /**
     * Muestra los datos de la resolucion y ofrece las operaciones que se pueden realizar sobre la misma.
     * @param $id_documento
     * @return null
     */
    public function verAction($id_documento)
    {

        $documento = Resoluciones::findFirst(array('id_documento=' . $id_documento));
        if (!$documento) {
            $this->flash->error("La resoluciones no se encontró");
            return $this->redireccionar("resoluciones/listar");
        }
        $this->view->resolucion = $documento;
        $this->view->form = new ResolucionesForm($documento, array('edit' => true, 'readOnly' => true, 'required' => true));

    }

    /**
     * Pregunta si esta seguro de eliminar la resoluciones
     * @param $id_documento
     * @return null
     */
    public function eliminarAction($id_documento)
    {
        $documento = Resoluciones::findFirst('id_documento=' . $id_documento);
        if (!$documento) {
            $this->flashSession->error("La resoluciones no se encontró");
            return $this->response->redirect("resoluciones/listarData");
        }
        if ($documento->getHabilitado() == 0) {
            $this->flashSession->warning("La resoluciones ya fue eliminada");
            return $this->response->redirect("resoluciones/listarData");
        }
        $this->view->id_documento = $id_documento;
    }


    /**
     * Elimina la resoluciones de manera logica
     * Si es la ultima resoluciones: la resoluciones anterior  debera convertirse en la ultima para que la numeracion continue.
     * (debe ser del mismo año que la resoluciones a eliminar)
     * Si no es la ultima resoluciones: se la deshabilita nada mas.
     * @return null
     */
    public function eliminarLogicoAction()
    {
        if ($this->request->isPost()) {
            $id_documento = $this->request->getPost('id_documento', 'int');

            $documento = Resoluciones::findFirst('id_documento=' . $id_documento);
            if (!$documento) {
                $this->flashSession->warning("La Resolucion no se encontró");
                return $this->response->redirect("resoluciones/listarData");
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
                    $anterior = Resoluciones::findFirst('id_documento=' . $id_anterior . " AND fecha BETWEEN '$anio-01-01' AND '$anio-12-31'");
                    if (!$anterior)//Si no existe anterior, entonces empezaria en 0 la siguiente resoluciones que se ingrese
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
                                return $this->redireccionar('resoluciones/eliminar/' . $id_documento);
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
                    return $this->redireccionar('resoluciones/eliminar/' . $id_documento);
                }
                $this->db->commit();
                $this->flash->success('La resolucion ' . $documento->getNroResolucion() . ' ha sido deshabilitada');

            } else {
                /*Si no es el ultimo, se deshabilita*/
                $documento->setUltimo(0);
                $documento->setHabilitado(0);
                if (!$documento->update()) {
                    $this->db->rollback();
                    foreach ($documento->getMessages() as $mensaje) {
                        $this->flash->error($mensaje);
                    }
                    return $this->redireccionar('resoluciones/eliminar/' . $id_documento);
                }
                $this->db->commit();
                $this->flashSession->success('La resolucion ' . $documento->getNroResolucion() . ' ha sido deshabilitada');
            }
        }
        return $this->response->redirect("resoluciones/listarData");
    }

    /* ====================================================
        BUSQUEDAS
    =======================================================*/
    public function listarAction()
    {
        $this->setDatatables();
        $this->view->pick('resoluciones/search');


        $numberPage = $this->request->getQuery("page", "int");
        $parameters["order"] = "id_documento DESC";

        $documento = Resoluciones::find($parameters);
        if (count($documento) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron resoluciones cargadas en el sistema");
            return $this->response->redirect('resoluciones/index');
        }

        $paginator = new Paginator(array(
            "data" => $documento,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();

    }

    public function listarAjaxAction()
    {
        $this->view->disable();
        $retorno = array();
        $parameters["order"] = "id_documento DESC";
        $documentos = Resoluciones::find($parameters);
        if (count($documentos) == 0) {
            echo json_encode(array("data"=>""));
            return;
        }
        foreach ($documentos as $doc) {
            $item[] = "-";
            $item[] = $doc->getNroResolucion();
            $item[] = "SEC";
            $item[] = $doc->getFecha();
            $item[] = $doc->getDescripcion();
            $retorno[] = $item;
        }

        echo json_encode(
            array("data" =>
                    $retorno
            )
        );
        return;

    }

    public function listar2Action()
    {
        $this->setDatatables();
        $this->view->pick('resoluciones/search');


        $numberPage = $this->request->getQuery("page", "int");
        $parameters["order"] = "id_documento DESC";

        $resoluciones = Resoluciones::find($parameters);
        if (count($resoluciones) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron resoluciones cargadas en el sistema");
            return $this->response->redirect('resoluciones/index');
        }

        $paginator = new Paginator(array(
            "data" => $resoluciones,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Searches for resoluciones
     */
    public function searchAction()
    {
        $this->setDatatables();
        $numberPage = 1;
        if ($this->request->isPost()) {
            $_POST['descripcion'] = strtoupper($_POST['descripcion']);
            if ($this->request->getPost('nro_resolucion_final', 'int') == null) {
                $_POST['nro_resolucion']=$this->request->getPost('nro_resolucion_inicial', 'int');
            }
            if ($this->request->getPost('fecha_final') == null) {
                $_POST['fecha']=$this->request->getPost('fecha_inicial');
            }

            $query = Criteria::fromInput($this->di, "Resoluciones", $_POST);

            if ($this->request->getPost('nro_resolucion_final', 'int') != null
                && $this->request->getPost('nro_resolucion_inicial', 'int') != null) {
                $query->andWhere('nro_resolucion BETWEEN '. $this->request->getPost('nro_resolucion_inicial', 'int') ." AND ". $this->request->getPost('nro_resolucion_final', 'int'));
            }
            if ($this->request->getPost('fecha_final') != null) {
                if($this->request->getPost('fecha_inicial') != null) {
                    $query->betweenWhere('fecha', $this->request->getPost('fecha_inicial'), $this->request->getPost('fecha_final'));
                }
                else
                {
                    $this->flashSession->error("Verifique que la fecha inicial y final estén correctamente ingresadas");
                    return $this->response->redirect('resoluciones/index');
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

        $resoluciones = Resoluciones::find($parameters);
        if (count($resoluciones) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron resoluciones cargadas en el sistema que coincidan con su búsqueda");
            return $this->response->redirect('resoluciones/index');
        }

        $paginator = new Paginator(array(
            "data" => $resoluciones,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Listar Las Resoluciones
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
        $select = array('R.nro_resolucion','DATE_FORMAT( R.fecha,  \'%d/%m/%Y\' ) AS fecha','S.sector_nombre AS origen','R.descripcion','R.habilitado','R.id_documento');
        $from = array('R' => 'Resoluciones','S'=>'Sectores');
        if( $this->session->get('auth')['rol_id']==2)//Administrador
        {
            $where = 'S.sector_id=R.sector_id_oid ';
        }
        else
        {
            $ultimo_anio= date('Y');
            $desde = $ultimo_anio."-01-01";
            $hasta = date('Y-m-d');
            $where = "S.sector_id=R.sector_id_oid AND R.habilitado=1 AND (R.fecha BETWEEN '$desde' AND '$hasta')";
        }
        $order_default = "id_documento DESC";
        $columnas_dt = array(
            array('data'=>'nro_resolucion', 'db' => 'R.nro_resolucion', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '$'.number_format($d);
                } ),
            array('data'=>'origen', 'db' => 'S.sector_nombre',   'dt' => 2 ),
            array('data'=>'fecha', 'db' => 'F.fecha',  'dt' => 1,
                'formatter' => function( $d, $row ) {
                    return date( 'd/M/Y', strtotime($d));
                } ),
            array('data'=>'descripcion', 'db' => 'R.descripcion',     'dt' => 4 )
        );
        $retorno = ServerSide::simpleQuery($this->request,$this->modelsManager,$select,$from,$where,$order_default,$columnas_dt);
        echo json_encode($retorno);
        return;
    }
}
