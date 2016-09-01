<?php
/**
 * Created by PhpStorm.
 * User: dmunioz
 * Date: 01/09/2016
 * Time: 8:05
 */
use Phalcon\Paginator\Adapter\Model as Paginator;

class UsuariosController extends ControllerBase
{
    public function verUsuariosPorRolAction($rol_id)
    {
        $this->setDatatables();

        $numberPage = $this->request->getQuery("page", "int");
        $parameters["order"] = "id_documento DESC";

        $documento = Usuarioporrol::find(array('rol_id='.$rol_id));

        if (count($documento) == 0) {
            $this->flashSession->warning("<i class='fa fa-warning'></i> No se encontraron usuarios cargados");
        }

        $paginator = new Paginator(array(
            "data" => $documento,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();

    }


}