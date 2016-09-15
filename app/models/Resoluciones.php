<?php

class Resoluciones extends \Phalcon\Mvc\Model
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
    protected $nro_resolucion;

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
     * @var string
     */
    protected $ultimo;

    /**
     *
     * @var string
     */
    protected $resoluciones_adjunto;

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
     * Method to set the value of field nro_resolucion
     *
     * @param integer $nro_resolucion
     * @return $this
     */
    public function setNroResolucion($nro_resolucion)
    {
        $this->nro_resolucion = $nro_resolucion;

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
     * @param string $ultimo
     * @return $this
     */
    public function setUltimo($ultimo)
    {
        $this->ultimo = $ultimo;

        return $this;
    }

    /**
     * Method to set the value of field resoluciones_adjunto
     *
     * @param string $resoluciones_adjunto
     * @return $this
     */
    public function setResolucionesAdjunto($resoluciones_adjunto)
    {
        $this->resoluciones_adjunto = $resoluciones_adjunto;

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
     * Returns the value of field nro_resolucion
     *
     * @return integer
     */
    public function getNroResolucion()
    {
        return $this->nro_resolucion;
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
     * @return string
     */
    public function getUltimo()
    {
        return $this->ultimo;
    }

    /**
     * Returns the value of field resoluciones_adjunto
     *
     * @return string
     */
    public function getResolucionesAdjunto()
    {
        return $this->resoluciones_adjunto;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('sector_id_oid', 'Sectores', 'sector_id', array('alias' => 'Sector'));
        $this->setSchema('libro');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'resoluciones';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Resoluciones[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Resoluciones
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
