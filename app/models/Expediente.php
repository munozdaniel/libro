<?php

class Expediente extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     */
    protected $id_documento;

    /**
     *
     * @var integer
     */
    protected $expte_cod_anio;

    /**
     *
     * @var string
     */
    protected $expte_cod_empresa;

    /**
     *
     * @var string
     */
    protected $expte_cod_letra;

    /**
     *
     * @var integer
     */
    protected $expte_cod_numero;

    /**
     *
     * @var integer
     */
    protected $nro_expediente;

    /**
     *
     * @var string
     */
    protected $creadopor;

    /**
     *
     * @var string
     */
    protected $descripcion;

    /**
     *
     * @var string
     */
    protected $fecha;

    /**
     *
     * @var string
     */
    protected $habilitado;

    /**
     *
     * @var string
     */
    protected $sector_id_oid;

    /**
     *
     * @var integer
     */
    protected $tipo;

    /**
     *
     * @var integer
     */
    protected $ultimo;

    /**
     *
     * @var string
     */
    protected $expediente_ultimaModificacion;

    /**
     *
     * @var string
     */
    protected $expediente_adjunto;

    /**
     * Method to set the value of field id_documento
     *
     * @param string $id_documento
     * @return $this
     */
    public function setIdDocumento($id_documento)
    {
        $this->id_documento = $id_documento;

        return $this;
    }

    /**
     * Method to set the value of field expte_cod_anio
     *
     * @param integer $expte_cod_anio
     * @return $this
     */
    public function setExpteCodAnio($expte_cod_anio)
    {
        $this->expte_cod_anio = $expte_cod_anio;

        return $this;
    }

    /**
     * Method to set the value of field expte_cod_empresa
     *
     * @param string $expte_cod_empresa
     * @return $this
     */
    public function setExpteCodEmpresa($expte_cod_empresa)
    {
        $this->expte_cod_empresa = $expte_cod_empresa;

        return $this;
    }

    /**
     * Method to set the value of field expte_cod_letra
     *
     * @param string $expte_cod_letra
     * @return $this
     */
    public function setExpteCodLetra($expte_cod_letra)
    {
        $this->expte_cod_letra = $expte_cod_letra;

        return $this;
    }

    /**
     * Method to set the value of field expte_cod_numero
     *
     * @param integer $expte_cod_numero
     * @return $this
     */
    public function setExpteCodNumero($expte_cod_numero)
    {
        $this->expte_cod_numero = $expte_cod_numero;

        return $this;
    }

    /**
     * Method to set the value of field nro_expediente
     *
     * @param integer $nro_expediente
     * @return $this
     */
    public function setNroExpediente($nro_expediente)
    {
        $this->nro_expediente = $nro_expediente;

        return $this;
    }

    /**
     * Method to set the value of field creadopor
     *
     * @param string $creadopor
     * @return $this
     */
    public function setCreadopor($creadopor)
    {
        $this->creadopor = $creadopor;

        return $this;
    }

    /**
     * Method to set the value of field descripcion
     *
     * @param string $descripcion
     * @return $this
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Method to set the value of field fecha
     *
     * @param string $fecha
     * @return $this
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Method to set the value of field habilitado
     *
     * @param string $habilitado
     * @return $this
     */
    public function setHabilitado($habilitado)
    {
        $this->habilitado = $habilitado;

        return $this;
    }

    /**
     * Method to set the value of field sector_id_oid
     *
     * @param string $sector_id_oid
     * @return $this
     */
    public function setSectorIdOid($sector_id_oid)
    {
        $this->sector_id_oid = $sector_id_oid;

        return $this;
    }

    /**
     * Method to set the value of field tipo
     *
     * @param integer $tipo
     * @return $this
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Method to set the value of field ultimo
     *
     * @param integer $ultimo
     * @return $this
     */
    public function setUltimo($ultimo)
    {
        $this->ultimo = $ultimo;

        return $this;
    }

    /**
     * Method to set the value of field expediente_ultimaModificacion
     *
     * @param string $expediente_ultimaModificacion
     * @return $this
     */
    public function setExpedienteUltimamodificacion($expediente_ultimaModificacion)
    {
        $this->expediente_ultimaModificacion = $expediente_ultimaModificacion;

        return $this;
    }

    /**
     * Method to set the value of field expediente_adjunto
     *
     * @param string $expediente_adjunto
     * @return $this
     */
    public function setExpedienteAdjunto($expediente_adjunto)
    {
        $this->expediente_adjunto = $expediente_adjunto;

        return $this;
    }

    /**
     * Returns the value of field id_documento
     *
     * @return string
     */
    public function getIdDocumento()
    {
        return $this->id_documento;
    }

    /**
     * Returns the value of field expte_cod_anio
     *
     * @return integer
     */
    public function getExpteCodAnio()
    {
        return $this->expte_cod_anio;
    }

    /**
     * Returns the value of field expte_cod_empresa
     *
     * @return string
     */
    public function getExpteCodEmpresa()
    {
        return $this->expte_cod_empresa;
    }

    /**
     * Returns the value of field expte_cod_letra
     *
     * @return string
     */
    public function getExpteCodLetra()
    {
        return $this->expte_cod_letra;
    }

    /**
     * Returns the value of field expte_cod_numero
     *
     * @return integer
     */
    public function getExpteCodNumero()
    {
        return $this->expte_cod_numero;
    }

    /**
     * Returns the value of field nro_expediente
     *
     * @return integer
     */
    public function getNroExpediente()
    {
        return $this->nro_expediente;
    }

    /**
     * Returns the value of field creadopor
     *
     * @return string
     */
    public function getCreadopor()
    {
        return $this->creadopor;
    }

    /**
     * Returns the value of field descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Returns the value of field fecha
     *
     * @return string
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Returns the value of field habilitado
     *
     * @return string
     */
    public function getHabilitado()
    {
        return $this->habilitado;
    }

    /**
     * Returns the value of field sector_id_oid
     *
     * @return string
     */
    public function getSectorIdOid()
    {
        return $this->sector_id_oid;
    }

    /**
     * Returns the value of field tipo
     *
     * @return integer
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Returns the value of field ultimo
     *
     * @return integer
     */
    public function getUltimo()
    {
        return $this->ultimo;
    }

    /**
     * Returns the value of field expediente_ultimaModificacion
     *
     * @return string
     */
    public function getExpedienteUltimamodificacion()
    {
        return $this->expediente_ultimaModificacion;
    }

    /**
     * Returns the value of field expediente_adjunto
     *
     * @return string
     */
    public function getExpedienteAdjunto()
    {
        return $this->expediente_adjunto;
    }
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('sector_id_oid', 'Sectores', 'sector_id', array('alias' => 'Sectores'));
        $this->setSchema('libro_phalcon');
    }
    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'expediente';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Expediente[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Expediente
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
