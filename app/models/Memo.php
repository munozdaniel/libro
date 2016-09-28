<?php

class Memo extends \Phalcon\Mvc\Model
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
    protected $destinosector_id_oid;

    /**
     *
     * @var integer
     */
    protected $nro_memo;

    /**
     *
     * @var string
     */
    protected $otrodestino;

    /**
     *
     * @var string
     */
    protected $adjunto;

    /**
     *
     * @var string
     */
    protected $adjuntar;

    /**
     *
     * @var string
     */
    protected $adjuntar_0;

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
     * @var integer
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
     * @var integer
     */
    protected $ultimodelanio;

    /**
     *
     * @var string
     */
    protected $version;

    /**
     *
     * @var string
     */
    protected $nro;

    /**
     *
     * @var string
     */
    protected $memo_adjunto;

    /**
     *
     * @var string
     */
    protected $memo_ultimaModificacion;

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
     * Method to set the value of field destinosector_id_oid
     *
     * @param integer $destinosector_id_oid
     * @return $this
     */
    public function setDestinosectorIdOid($destinosector_id_oid)
    {
        $this->destinosector_id_oid = $destinosector_id_oid;

        return $this;
    }

    /**
     * Method to set the value of field nro_memo
     *
     * @param integer $nro_memo
     * @return $this
     */
    public function setNroMemo($nro_memo)
    {
        $this->nro_memo = $nro_memo;

        return $this;
    }

    /**
     * Method to set the value of field otrodestino
     *
     * @param string $otrodestino
     * @return $this
     */
    public function setOtrodestino($otrodestino)
    {
        $this->otrodestino = $otrodestino;

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
     * @param integer $sector_id_oid
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
     * Method to set the value of field memo_adjunto
     *
     * @param string $memo_adjunto
     * @return $this
     */
    public function setMemoAdjunto($memo_adjunto)
    {
        $this->memo_adjunto = $memo_adjunto;

        return $this;
    }

    /**
     * Method to set the value of field memo_ultimaModificacion
     *
     * @param string $memo_ultimaModificacion
     * @return $this
     */
    public function setMemoUltimamodificacion($memo_ultimaModificacion)
    {
        $this->memo_ultimaModificacion = $memo_ultimaModificacion;

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
     * Returns the value of field destinosector_id_oid
     *
     * @return integer
     */
    public function getDestinosectorIdOid()
    {
        return $this->destinosector_id_oid;
    }

    /**
     * Returns the value of field nro_memo
     *
     * @return integer
     */
    public function getNroMemo()
    {
        return $this->nro_memo;
    }

    /**
     * Returns the value of field otrodestino
     *
     * @return string
     */
    public function getOtrodestino()
    {
        return $this->otrodestino;
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
     * @return string
     */
    public function getHabilitado()
    {
        return $this->habilitado;
    }

    /**
     * Returns the value of field sector_id_oid
     *
     * @return integer
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
     * Returns the value of field memo_adjunto
     *
     * @return string
     */
    public function getMemoAdjunto()
    {
        return $this->memo_adjunto;
    }

    /**
     * Returns the value of field memo_ultimaModificacion
     *
     * @return string
     */
    public function getMemoUltimamodificacion()
    {
        return $this->memo_ultimaModificacion;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema('libro_phalcon');
        $this->belongsTo('destinosector_id_oid', 'Sectores', 'sector_id', array('alias' => 'SectorDestino'));
        $this->belongsTo('sector_id_oid', 'Sectores', 'sector_id', array('alias' => 'SectorOrigen'));

    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'memo';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Memo[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Memo
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
