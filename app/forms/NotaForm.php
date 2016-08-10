<?php
/**
 * Created by PhpStorm.
 * User: dmunioz
 * Date: 03/03/2016
 * Time: 15:09
 */
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;
use \Phalcon\Forms\Element\Date;
use \Phalcon\Forms\Element\Email;
use Phalcon\Forms\Element\Hidden;
use \Phalcon\Forms\Element\Select;

class NotaForm extends Form {
    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array())
    {
        if(!isset($options['readOnly']))
        {
            $readOnly="readOnly='true'";
        }else{
            $readOnly="";
        }
        if(!isset($options['required']))
        {
            $required="required=true";
            $asterisco='<strong class="text-danger "> * </strong>';
        }else{
            $required="";
            $asterisco='';
        }
        /*========================== ID DOCUMENTO ==========================*/
        if (!isset($options['edit'])) {
            $elemento = new Text('id_documento',
                array(
                    'class'=>'form-control',
                    'maxlength'=>70,
                    $required,
                    'readOnly'=>'true'
                ));
            $elemento->setLabel(' ID');
            $this->add($elemento);
        } else {
            $this->add(new Hidden("id_documento"));
        }
        /*========================== NRO ==========================*/
        $elemento = new Text('nro_nota',
            array(
                'class'=>'form-control',
                'placeholder'=>'Autogenerado',
                'maxlength'=>70,
                $required,
                $readOnly
            ));
        $elemento->setLabel($asterisco.' Nro de Nota');
        $elemento->setFilters(array('int'));
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'El Número es requerido'
            ))
        ));
        $this->add($elemento);
        /*========================== FECHA ==========================*/
        $elemento = new Date('fecha',
            array('class'=>'form-control','required'=>''));
        $elemento->setLabel($asterisco.' Fecha ');
        $elemento->setFilters(array('striptags', 'string'));
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'La Fecha es requerida'
            ))
        ));
        $this->add($elemento);
        /*========================== SECTOR ORIGEN ==========================*/
        $elemento = new Select('nota_sectorOrigenId',  Sectores::find(), array(
            'using'      => array('sector_id', 'sector_nombre'),
            'useEmpty'   => true,
            'emptyText'  => 'Seleccionar ',
            'emptyValue' => '',
            'class'      => 'form-control autocompletar',
            $required,
            $readOnly,
        ));
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'Seleccione el sector'
            ))
        ));
            $elemento->setLabel($asterisco.' Sector Origen');
        $this->add($elemento);
        /*========================== DESTINO ==========================*/
        $elemento = new Text('destino',
            array(
                'class'=>'form-control',
                'placeholder'=>'Ingrese el destino',
                'maxlength'=>70,
                $required[0]=>'',
                $readOnly
            ));
        $elemento->setLabel($asterisco.' Destino');
            $elemento->setFilters(array('striptags', 'string'));
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'El destino es requerido'
            ))
        ));
        $this->add($elemento);
        /*========================== DESCRIPCION ==========================*/
        $elemento = new TextArea('descripcion',
            array(
                'class'=>'form-control',
                'placeholder'=>'Ingrese la descripción',
                'maxlength'=>240,
                $required[0]=>'',
                $readOnly
            ));
        $elemento->setLabel($asterisco.' Descripción');
        $elemento->setFilters(array('striptags', 'string'));
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'La descripción es requerida.'
            ))
        ));
        $this->add($elemento);
        /*========================== DESTINO ==========================*/
        $elemento = new Text('creadopor',
            array(
                'class'=>'form-control',
                'placeholder'=>'Creado Por',
                'maxlength'=>70,
                $required[0]=>'',
                $readOnly
            ));
        $elemento->setFilters(array('striptags', 'string'));
        $this->add($elemento);
    }

}