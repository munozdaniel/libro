<?php
/**
 * Created by PhpStorm.
 * User: dmunioz
 * Date: 02/09/2016
 * Time: 11:29
 */
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;
use \Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\Hidden;
use \Phalcon\Forms\Element\Select;

class ExpedienteForm extends Form
{

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
        $elemento = new Text('nro_expediente',
            array(
                'class' => 'form-control',
                'placeholder' => 'Autogenerado',
                'maxlength' => 70,
                $opcion['required'] => '',
                "readOnly" => 'true'
            ));
        $elemento->setLabel($opcion['asterisco'] . ' Nro de Nota');
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
                        AND D.detalleSector_expediente=1
                            AND S.sector_id=D.detalleSector_sectorId ')
            ->getQuery()
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
        /*========================== LETRA   ==========================*/
        $elemento = new Text('expte_cod_letra',
            array(
                'class' => 'form-control only-text',
                'placeholder' => 'Ingrese una Letra',
                'maxlength' => 1,
                $opcion['required'] => '',
                $opcion['readOnly'] => ''
            ));
        $elemento->setLabel($opcion['asterisco'] . ' Código');
        $elemento->setFilters(array('striptags', 'string'));
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