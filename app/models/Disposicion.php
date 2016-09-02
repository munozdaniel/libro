<?php

class Disposicion extends \Phalcon\Mvc\Model
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
    protected $nro_disposicion;

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
    protected $disposicion_adjunto;

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
     * Method to set the value of field nro_disposicion
     *
     * @param integer $nro_disposicion
     * @return $this
     */
    public function setNroDisposicion($nro_disposicion)
    {
        $this->nro_disposicion = $nro_disposicion;

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
     * Method to set the value of field disposicion_adjunto
     *
     * @param string $disposicion_adjunto
     * @return $this
     */
    public function setDisposicionAdjunto($disposicion_adjunto)
    {
        $this->disposicion_adjunto = $disposicion_adjunto;

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
     * Returns the value of field nro_disposicion
     *
     * @return integer
     */
    public function getNroDisposicion()
    {
        return $this->nro_disposicion;
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
     * Returns the value of field disposicion_adjunto
     *
     * @return string
     */
    public function getDisposicionAdjunto()
    {
        return $this->disposicion_adjunto;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'disposicion';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Disposicion[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Disposicion
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
