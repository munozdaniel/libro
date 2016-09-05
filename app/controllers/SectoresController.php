<?php
/**
 * Created by PhpStorm.
 * User: dmunioz
 * Date: 19/08/2016
 * Time: 9:04
 */
use Phalcon\Paginator\Adapter\Model as Paginator;

class SectoresController extends ControllerBase
{
    public function cargarSectoresAjaxAction()
    {
        $this->view->disable();
        $retorno = array();
        $phql  = "SELECT DISTINCT (otrodestino) as destino FROM Memo ORDER BY destino";
        $sectores = $this->modelsManager->executeQuery($phql);
        foreach ($sectores as $sector) {
            $retorno[] = $sector->destino;
        }
        echo json_encode($retorno);
        return;
    }


}