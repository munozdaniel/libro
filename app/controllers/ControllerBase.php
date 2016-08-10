<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected function initialize()
    {
        $this->tag->prependTitle('LIBRO | ');
        $this->view->setTemplateAfter('main');
    }
    protected function redireccionar($uri)
    {
        $uriParts = explode('/', $uri);
        $params = array_slice($uriParts, 2);
        return $this->dispatcher->forward(
            array(
                'controller' => $uriParts[0],
                'action' => $uriParts[1],
                'params' => $params
            )
        );
    }
    protected function setDatatables()
    {
        $this->assets->collection('headerCss')
            ->addCss('plugins/datatables/dataTables.bootstrap.css');
        $this->assets->collection('footerJs')
            ->addJs('plugins/datatables/jquery.dataTables.min.js')
            ->addJs('plugins/datatables/dataTables.bootstrap.min.js');
        $this->assets->collection('footerInlineJs')
            ->addInlineJs('
                        $(function () {
                            var table = $(\'#tabla\').DataTable({
                                paging: false,
                                lengthChange: false,
                                searching: false,
                                ordering: true,
                                info: true,
                                autoWidth: true,
                                scrollX: true,
                                scrollCollapse: true,

                            });
                        });
            ');
    }
}
