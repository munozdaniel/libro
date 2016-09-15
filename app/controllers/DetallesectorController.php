<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class DetallesectorController extends ControllerBase
{


    public function verSectoresAction()
    {
        $this->setDatatables();

        $numberPage = $this->request->getQuery("page", "int");
        $parameters["order"] = "detalleSector_id DESC";

        $documento = Detallesector::find($parameters);

        if (count($documento) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron sectores cargados");
        }

        $paginator = new Paginator(array(
            "data" => $documento,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();

    }
    /**
     * Edits a detallesector
     *
     * @param string $detalleSector_id
     */
    public function editAction($detalleSector_id)
    {

        if (!$this->request->isPost()) {

            $detallesector = Detallesector::findFirstBydetalleSector_id($detalleSector_id);
            if (!$detallesector) {
                $this->flash->error("detallesector was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "detallesector",
                    "action" => "index"
                ));
            }

            $this->view->detalleSector_id = $detallesector->detalleSector_id;

            $this->tag->setDefault("detalleSector_id", $detallesector->getDetallesectorId());
            $this->tag->setDefault("detalleSector_expediente", $detallesector->getDetallesectorExpediente());
            $this->tag->setDefault("detalleSector_resolucion", $detallesector->getDetallesectorResolucion());
            $this->tag->setDefault("detalleSector_disposicion", $detallesector->getDetallesectorDisposicion());
            $this->tag->setDefault("detalleSector_sectorId", $detallesector->getSectores()->getSectorNombre());
            $this->tag->setDefault("detalleSector_habilitado", $detallesector->getDetallesectorHabilitado());

        }
    }


    /**
     * Saves a detallesector edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "detallesector",
                "action" => "index"
            ));
        }
        $detalleSector_id = $this->request->getPost("detalleSector_id");

        $detallesector = Detallesector::findFirst("detalleSector_id=".$detalleSector_id);
        if (!$detallesector) {
            $this->flash->error("El sector no existe " );

            return $this->dispatcher->forward(array(
                "controller" => "detallesector",
                "action" => "index"
            ));
        }
        if($this->request->getPost("detalleSector_expediente")<0 ||$this->request->getPost("detalleSector_expediente")>1)
        {
            $this->flash->error("Ingrese 0 o 1 para el expediente");

            return $this->dispatcher->forward(array(
                "controller" => "detallesector",
                "action" => "edit",
                "params" => array($detallesector->getDetallesectorId())
            ));
        }
        if($this->request->getPost("detalleSector_resolucion")<0 ||$this->request->getPost("detalleSector_resolucion")>1)
        {
            $this->flash->error("Ingrese 0 o 1 para la resolucion");

            return $this->dispatcher->forward(array(
                "controller" => "detallesector",
                "action" => "edit",
                "params" => array($detallesector->getDetallesectorId())
            ));
        }
        if($this->request->getPost("detalleSector_disposicion")<0 ||$this->request->getPost("detalleSector_disposicion")>1)
        {
            $this->flash->error("Ingrese 0 o 1 para la disposicion");

            return $this->dispatcher->forward(array(
                "controller" => "detallesector",
                "action" => "edit",
                "params" => array($detallesector->getDetallesectorId())
            ));
        }


        $detallesector->setDetallesectorExpediente($this->request->getPost("detalleSector_expediente",'int'));
        $detallesector->setDetallesectorResolucion($this->request->getPost("detalleSector_resolucion",'int'));
        $detallesector->setDetallesectorDisposicion($this->request->getPost("detalleSector_disposicion",'int'));

        if (!$detallesector->save()) {

            foreach ($detallesector->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "detallesector",
                "action" => "edit",
                "params" => array($detallesector->getDetallesectorId())
            ));
        }

        $this->flash->success("El sector ha sido actualizado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "detallesector",
            "action" => "verSectores"
        ));

    }



}
