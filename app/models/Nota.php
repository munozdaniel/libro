<?php

class Nota extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     */
    protected $id_documento;

    /**
     *
     * @var string
     */
    protected $destino;

    /**
     *
     * @var integer
     */
    protected $nro_nota;

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
     * @var integer
     */
    protected $habilitado;

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
     * @var integer
     */
    protected $ultimodelanio;


    /**
     *
     * @var string
     */
    protected $nota_ultimaModificacion;

    /**
     *
     * @var integer
     */
    protected $nota_sectorOrigenId;

    /**
     *
     * @var integer
     */
    protected $nota_adjunto;

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
     * Method to set the value of field destino
     *
     * @param string $destino
     * @return $this
     */
    public function setDestino($destino)
    {
        $this->destino = $destino;

        return $this;
    }

    /**
     * Method to set the value of field nro_nota
     *
     * @param integer $nro_nota
     * @return $this
     */
    public function setNroNota($nro_nota)
    {
        $this->nro_nota = $nro_nota;

        return $this;
    }

    /**
     * Method to set the value of field adjunto
     *
     * @param string $adjunto
     * @return $this
     */
    public function setAdjunto($adjunto)
    {
        $this->adjunto = $adjunto;

        return $this;
    }

    /**
     * Method to set the value of field adjuntar
     *
     * @param string $adjuntar
     * @return $this
     */
    public function setAdjuntar($adjuntar)
    {
        $this->adjuntar = $adjuntar;

        return $this;
    }

    /**
     * Method to set the value of field adjuntar_0
     *
     * @param string $adjuntar_0
     * @return $this
     */
    public function setAdjuntar0($adjuntar_0)
    {
        $this->adjuntar_0 = $adjuntar_0;

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
     * @param integer $habilitado
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
     * Method to set the value of field ultimodelanio
     *
     * @param integer $ultimodelanio
     * @return $this
     */
    public function setUltimodelanio($ultimodelanio)
    {
        $this->ultimodelanio = $ultimodelanio;

        return $this;
    }

    /**
     * Method to set the value of field version
     *
     * @param string $version
     * @return $this
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Method to set the value of field nro
     *
     * @param string $nro
     * @return $this
     */
    public function setNro($nro)
    {
        $this->nro = $nro;

        return $this;
    }

    /**
     * Method to set the value of field nota_ultimaModificacion
     *
     * @param string $nota_ultimaModificacion
     * @return $this
     */
    public function setNotaUltimamodificacion($nota_ultimaModificacion)
    {
        $this->nota_ultimaModificacion = $nota_ultimaModificacion;

        return $this;
    }

    /**
     * Method to set the value of field nota_sectorOrigenId
     *
     * @param integer $nota_sectorOrigenId
     * @return $this
     */
    public function setNotaSectororigenid($nota_sectorOrigenId)
    {
        $this->nota_sectorOrigenId = $nota_sectorOrigenId;

        return $this;
    }

    /**
     * Method to set the value of field nota_adjunto
     *
     * @param integer $nota_adjunto
     * @return $this
     */
    public function setNotaAdjunto($nota_adjunto)
    {
        $this->nota_adjunto = $nota_adjunto;

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
     * Returns the value of field destino
     *
     * @return string
     */
    public function getDestino()
    {
        return $this->destino;
    }

    /**
     * Returns the value of field nro_nota
     *
     * @return integer
     */
    public function getNroNota()
    {
        return $this->nro_nota;
    }

    /**
     * Returns the value of field adjunto
     *
     * @return string
     */
    public function getAdjunto()
    {
        return $this->adjunto;
    }

    /**
     * Returns the value of field adjuntar
     *
     * @return string
     */
    public function getAdjuntar()
    {
        return $this->adjuntar;
    }

    /**
     * Returns the value of field adjuntar_0
     *
     * @return string
     */
    public function getAdjuntar0()
    {
        return $this->adjuntar_0;
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
     * @return integer
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
     * Returns the value of field ultimodelanio
     *
     * @return integer
     */
    public function getUltimodelanio()
    {
        return $this->ultimodelanio;
    }

    /**
     * Returns the value of field version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Returns the value of field nro
     *
     * @return string
     */
    public function getNro()
    {
        return $this->nro;
    }

    /**
     * Returns the value of field nota_ultimaModificacion
     *
     * @return string
     */
    public function getNotaUltimamodificacion()
    {
        return $this->nota_ultimaModificacion;
    }

    /**
     * Returns the value of field nota_sectorOrigenId
     *
     * @return integer
     */
    public function getNotaSectororigenid()
    {
        return $this->nota_sectorOrigenId;
    }

    /**
     * Returns the value of field nota_adjunto
     *
     * @return integer
     */
    public function getNotaAdjunto()
    {
        return $this->nota_adjunto;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('nota_sectorOrigenId', 'Sectores', 'sector_id', array('alias' => 'Sectores'));
        $this->setSchema('libro_phalcon');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'nota';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Nota[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Nota
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
