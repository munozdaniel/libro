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
            'nro' => $nota->getNroNota(),
            'fecha' =>  date('d/m/Y', strtotime($nota->getFecha())),
            'origen' => $nota->getSectores()->getSectorNombre(),
            'descripcion' => $nota->getDescripcion(),
            'destino' => $nota->getDestino()

        ));
        $pdf = new mpdf();
        $pdf->WriteHTML($html, 2);
        $pdf->Output('nota_'.$nota->getNroNota().'_'.$nota->getFecha().'.pdf', "I");

    }
    public function memoAction($id_documento)
    {
        $this->view->disable();
        $memo = Memo::findFirst('id_documento=' . $id_documento);
        if (!$memo) {
            $this->flash->error("El memo no se encontró");
            return $this->redireccionar("memo/listar");
        }
        $this->tag->setTitle('');//Para que no muestre el titulo en el pdf.

        ini_set('max_execution_time', 300); //300 seconds = 5 minutes // si funciona pero la pagina anterior se corrompe



        // Get the view data
        if($memo->getDestinosectorIdOid()==1)
            $destino = $memo->getOtrodestino();
        else
            $destino = $memo->getSectorDestino()->getSectorNombre();
        $html = $this->view->getRender('caratula', 'memo', array(
            'nro' => $memo->getNroMemo(),
            'fecha' =>  date('d/m/Y', strtotime($memo->getFecha())),
            'origen' => $memo->getSectorOrigen()->getSectorNombre(),
            'descripcion' => $memo->getDescripcion(),
            'destino' => $destino

        ));
        $pdf = new mpdf();
        $pdf->WriteHTML($html, 2);
        $pdf->Output('nota_'.$memo->getNroMemo().'_'.$memo->getFecha().'.pdf', "I");

    }
    public function resolucionesAction($id_documento)
    {
        $this->view->disable();
        $documento = Resoluciones::findFirst('id_documento=' . $id_documento);
        if (!$documento) {
            $this->flash->error("La Resolucion no se encontró");
            return $this->redireccionar("resoluciones/listar");
        }
        $this->tag->setTitle('');//Para que no muestre el titulo en el pdf.

        ini_set('max_execution_time', 300); //300 seconds = 5 minutes // si funciona pero la pagina anterior se corrompe



        // Get the view data

        $html = $this->view->getRender('caratula', 'resoluciones', array(
            'nro' => $documento->getNroResolucion(),
            'fecha' =>  date('d/m/Y', strtotime($documento->getFecha())),
            'origen' => $documento->getSector()->getSectorNombre(),
            'descripcion' => $documento->getDescripcion()

        ));
        $pdf = new mpdf();
        $pdf->WriteHTML($html, 2);
        $pdf->Output('resoluciones_'.$documento->getNroResolucion().'_'.$documento->getFecha().'.pdf', "I");

    }

    public function disposicionAction($id_documento)
    {
        $this->view->disable();
        $documento = Disposicion::findFirst('id_documento=' . $id_documento);
        if (!$documento) {
            $this->flash->error("La Disposicion no se encontró");
            return $this->redireccionar("disposicion/listar");
        }
        $this->tag->setTitle('');//Para que no muestre el titulo en el pdf.

        ini_set('max_execution_time', 300); //300 seconds = 5 minutes // si funciona pero la pagina anterior se corrompe



        // Get the view data

        $html = $this->view->getRender('caratula', 'disposicion', array(
            'nro' => $documento->getNroDisposicion(),
            'fecha' =>  date('d/m/Y', strtotime($documento->getFecha())),
            'origen' => $documento->getSectores()->getSectorNombre(),
            'descripcion' => $documento->getDescripcion()

        ));
        $pdf = new mpdf();
        $pdf->WriteHTML($html, 2);
        $pdf->Output('disposicion'.$documento->getNroDisposicion().'_'.$documento->getFecha().'.pdf', "I");

    }
    public function expedienteAction($id_documento)
    {
        $this->view->disable();
        $documento = Expediente::findFirst('id_documento=' . $id_documento);
        if (!$documento) {
            $this->flash->error("El Expediente no se encontró");
            return $this->redireccionar("expediente/listar");
        }
        $this->tag->setTitle('');//Para que no muestre el titulo en el pdf.

        ini_set('max_execution_time', 300); //300 seconds = 5 minutes // si funciona pero la pagina anterior se corrompe



        // Get the view data

        $html = $this->view->getRender('caratula', 'expediente', array(
            'nro' => $documento->getNroExpediente(),
            'fecha' =>  date('d/m/Y', strtotime($documento->getFecha())),
            'origen' => $documento->getSectores()->getSectorNombre(),
            'descripcion' => $documento->getDescripcion()

        ));
        $pdf = new mpdf();
        $pdf->WriteHTML($html, 2);
        $pdf->Output('expediente'.$documento->getNroExpediente().'_'.$documento->getFecha().'.pdf', "I");

    }
}