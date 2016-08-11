<?php
/**
 * Created by PhpStorm.
 * User: dmunioz
 * Date: 11/08/2016
 * Time: 12:58
 */

class CaratulaController  extends ControllerBase
{

    public function notaAction($id_documento)
    {
        $this->view->disable();
        $nota = Nota::findFirst('id_documento=' . $id_documento);
        if (!$nota) {
            $this->flash->error("La nota no se encontró");
            return $this->redireccionar("nota/listar");
        }
        $this->tag->setTitle('');//Para que no muestre el titulo en el pdf.

        ini_set('max_execution_time', 300); //300 seconds = 5 minutes // si funciona pero la pagina anterior se corrompe



        // Get the view data
        $html = $this->view->getRender('caratula', 'nota', array(
            'nro_nota' => $nota->getNroNota(),
            'fecha' =>  date('d/m/Y', strtotime($nota->getFecha())),
            'origen' => $nota->getSectores()->getSectorNombre(),
            'descripcion' => $nota->getDescripcion(),
            'destino' => $nota->getDestino()

        ));
        $pdf = new mpdf();
        $pdf->WriteHTML($html, 2);
        $pdf->Output('nota_'.$nota->getNroNota().'_'.$nota->getFecha().'.pdf', "I");

    }
}