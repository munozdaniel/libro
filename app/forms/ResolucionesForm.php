<?php
/**
 * Created by PhpStorm.
 * User: dmunioz
 * Date: 31/08/2016
 * Time: 8:57
 */
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;
use \Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\Hidden;
use \Phalcon\Forms\Element\Select;

class ResolucionesForm extends Form{
    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array())
    {
        $opcion['required'] = '';
        $opcion['readOnly'] = '';
        $opcion['asterisco'] = '';
        $opcion['disabled'] = '';
        if (isset($options['readOnly'])) {
            $opcion['readOnly'] = 'readOnly';
            $opcion['disabled'] = 'disabled';
        }
        if (isset($options['required'])) {
            $opcion['required'] = 'required';
            $opcion['asterisco'] = '<strong class="text-danger "> * </strong>';
        }
        /*========================== ID DOCUMENTO ==========================*/
        if (!isset($options['edit'])) {
            $elemento = new Text('id_documento',
                array(
                    'class' => 'form-control',
                    'maxlength' => 70,
                    $opcion['required'] => '',
                    $opcion['readOnly'] => ''
                ));
            $elemento->setLabel(' ID');
            $this->add($elemento);
        } else {
            $this->add(new Hidden("id_documento"));
        }
        /*========================== NRO ==========================*/
        $elemento = new Text('nro_resolucion',
            array(
                'class' => 'form-control',
                'placeholder' => 'Autogenerado',
                'maxlength' => 70,
                $opcion['required'] => '',
                "readOnly" => 'true'
            ));
        $elemento->setLabel($opcion['asterisco'] . ' Nro de Resolución');
        $elemento->setFilters(array('int'));
        $this->add($elemento);
        /*========================== FECHA ==========================*/
        $elemento = new Date('fecha',
            array(
                'class' => 'form-control',
                'placeholder' => 'FECHA',
                $opcion['required'] => '',
                'readOnly' => ''
            ));
        $elemento->setLabel($opcion['asterisco'] . ' Fecha ');
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'La Fecha es requerida'
            ))
        ));
        $this->add($elemento);
        /*========================== SECTOR ORIGEN ==========================*/
        $sectores = $this->modelsManager->createBuilder()
            ->columns(array('S.sector_id','S.sector_nombre'))
            ->from(
                array('S' => 'Sectores','D' => 'Detallesector')
            )
            ->where(' S.sector_activo=1 AND  S.sector_id!=1
                        AND D.detalleSector_resolucion=1
                            AND S.sector_id=D.detalleSector_sectorId ')
            ->orderBy("S.sector_nombre ASC")
            ->getQuery()
            ->execute();

        $sectores = Sectores::query()
            ->columns("Sectores.sector_id, Sectores.sector_nombre")
            ->join("DetalleSector") //This should work without a condition if you defined a relation between Robots and Manufacturers
            ->where("DetalleSector.detalleSector_resolucion=1 AND Sectores.sector_id=DetalleSector.detalleSector_sectorId")
            ->execute();


        $elemento = new Select('sector_id_oid', $sectores, array(
            'using' => array('sector_id', 'sector_nombre'),
            'useEmpty' => true,
            'emptyText' => 'Seleccionar ',
            'emptyValue' => '',
            'class' => 'form-control autocompletar',
            $opcion['required'] => '',
            $opcion['readOnly'] => '',
            $opcion['disabled'] => '',
            'style' => "width: 100%; height:40px !important;"
        ));
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'Seleccione el sector de origen'
            ))
        ));
        $elemento->setLabel($opcion['asterisco'] . 'Sector Origen');
        $this->add($elemento);

        /*========================== DESCRIPCION ==========================*/
        $elemento = new TextArea('descripcion',
            array(
                'class' => 'form-control',
                'placeholder' => 'Ingrese la descripción',
                'maxlength' => 240,
                $opcion['required'] => '',
                $opcion['readOnly'] => ''
            ));
        $elemento->setLabel($opcion['asterisco'] . ' Descripción');
        $elemento->setFilters(array('striptags', 'string'));
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'La descripción es requerida.'
            ))
        ));
        $this->add($elemento);
        /*========================== CREADO POR ==========================*/

        $elemento = new Text('creadopor',
            array(
                'class' => 'form-control',
                'placeholder' => 'Creado Por',
                'maxlength' => 70,
                $opcion['required'] => '',
                "readOnly" => 'true'
            ));
        $elemento->setLabel($opcion['asterisco'] . ' Creado Por');
        $miSesion = $this->session->get('auth');
        $elemento->setDefault($miSesion['usuario_nombreCompleto']);
        $elemento->setFilters(array('striptags', 'string'));
        $this->add($elemento);
    }
}