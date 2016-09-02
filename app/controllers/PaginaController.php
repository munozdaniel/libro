<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class PaginaController extends ControllerBase
{
    public function verPermisosPorRolAction($rol_id)
    {
        $this->setDatatables();

        $numberPage = $this->request->getQuery("page", "int");
        $parameters["order"] = "id_documento DESC";

        $acceso = Acceso::find(array('rol_id='.$rol_id));

        if (count($acceso) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron permisos cargados");
        }

        $paginator = new Paginator(array(
            "data" => $acceso,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

}
