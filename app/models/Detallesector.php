<?php

class Detallesector extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $detalleSector_id;

    /**
     *
     * @var integer
     */
    protected $detalleSector_expediente;

    /**
     *
     * @var integer
     */
    protected $detalleSector_resolucion;

    /**
     *
     * @var integer
     */
    protected $detalleSector_disposicion;

    /**
     *
     * @var integer
     */
    protected $detalleSector_sectorId;

    /**
     *
     * @var integer
     */
    protected $detalleSector_habilitado;

    /**
     * Method to set the value of field detalleSector_id
     *
     * @param integer $detalleSector_id
     * @return $this
     */
    public function setDetallesectorId($detalleSector_id)
    {
        $this->detalleSector_id = $detalleSector_id;

        return $this;
    }

    /**
     * Method to set the value of field detalleSector_expediente
     *
     * @param integer $detalleSector_expediente
     * @return $this
     */
    public function setDetallesectorExpediente($detalleSector_expediente)
    {
        $this->detalleSector_expediente = $detalleSector_expediente;

        return $this;
    }

    /**
     * Method to set the value of field detalleSector_resolucion
     *
     * @param integer $detalleSector_resolucion
     * @return $this
     */
    public function setDetallesectorResolucion($detalleSector_resolucion)
    {
        $this->detalleSector_resolucion = $detalleSector_resolucion;

        return $this;
    }

    /**
     * Method to set the value of field detalleSector_disposicion
     *
     * @param integer $detalleSector_disposicion
     * @return $this
     */
    public function setDetallesectorDisposicion($detalleSector_disposicion)
    {
        $this->detalleSector_disposicion = $detalleSector_disposicion;

        return $this;
    }

    /**
     * Method to set the value of field detalleSector_sectorId
     *
     * @param integer $detalleSector_sectorId
     * @return $this
     */
    public function setDetallesectorSectorid($detalleSector_sectorId)
    {
        $this->detalleSector_sectorId = $detalleSector_sectorId;

        return $this;
    }

    /**
     * Method to set the value of field detalleSector_habilitado
     *
     * @param integer $detalleSector_habilitado
     * @return $this
     */
    public function setDetallesectorHabilitado($detalleSector_habilitado)
    {
        $this->detalleSector_habilitado = $detalleSector_habilitado;

        return $this;
    }

    /**
     * Returns the value of field detalleSector_id
     *
     * @return integer
     */
    public function getDetallesectorId()
    {
        return $this->detalleSector_id;
    }

    /**
     * Returns the value of field detalleSector_expediente
     *
     * @return integer
     */
    public function getDetallesectorExpediente()
    {
        return $this->detalleSector_expediente;
    }

    /**
     * Returns the value of field detalleSector_resolucion
     *
     * @return integer
     */
    public function getDetallesectorResolucion()
    {
        return $this->detalleSector_resolucion;
    }

    /**
     * Returns the value of field detalleSector_disposicion
     *
     * @return integer
     */
    public function getDetallesectorDisposicion()
    {
        return $this->detalleSector_disposicion;
    }

    /**
     * Returns the value of field detalleSector_sectorId
     *
     * @return integer
     */
    public function getDetallesectorSectorid()
    {
        return $this->detalleSector_sectorId;
    }

    /**
     * Returns the value of field detalleSector_habilitado
     *
     * @return integer
     */
    public function getDetallesectorHabilitado()
    {
        return $this->detalleSector_habilitado;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('detalleSector_sectorId', 'Sectores', 'sector_id', array('alias' => 'Sectores'));
        $this->setSchema('libro_phalcon');

    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'detallesector';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Detallesector[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Detallesector
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
