<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected function initialize()
    {
        $this->tag->prependTitle('LIBRO | ');
        $this->view->setTemplateAfter('main');
        $this->importarFechaFirefox();
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
    protected function importarFechaFirefox()
    {

        $this->assets->collection('footerJs')
            ->addJs('http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js', false)
            ->addJs('http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js', false);
        $this->assets->collection('footerInlineJs')
            ->addInlineJs("webshims.setOptions('waitReady', false);
                            webshims.setOptions('forms-ext', {types: 'date'});
                            webshims.polyfill('forms forms-ext');");
    }
    protected function setDatatables()
    {
        $this->assets->collection('headerCss')
            ->addCss('plugins/datatables/dataTables.bootstrap.css')
            ->addCss('plugins/datatables/jquery.dataTables.min.css');
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


    /**
     * Guarda el archivo pdf en la carpeta : 'CLIENTE/fechaCreacionPlanilla/NombrePDF'
     * @param $archivos
     * @param $nombreCarpeta
     * @return array
     */
    public function guardarAdjunto($archivos, $nombreCarpeta)
    {
       /* $retorno = array();
        $retorno['path'] = '';//Nombre de la ruta en donde se guardo el archivo
        $retorno['success'] = false;//Si finaliza correctamente o no.
        $retorno['mensaje'] = '';//Mensaje de error en caso de que falle.*/
        $retorno= "";
        foreach ($archivos as $archivo) {

            //Creando Carpeta
            $nombreArchivo = $archivo->getName();
            if (!file_exists($nombreCarpeta)) {
                mkdir($nombreCarpeta, 0777, true);
            }
            $path = $nombreCarpeta . '/' . $nombreArchivo;
            #move the file and simultaneously check if everything was ok
            ($archivo->moveTo($path)) ? $band= true : $band = false;
            if (!$band)
                echo "No se pudo guardar el archivo $nombreArchivo.";
            else {
                $retorno = $path;
            }

        }
        return $retorno;

    }

}
