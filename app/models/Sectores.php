<?php

class Sectores extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $sector_id;

    /**
     *
     * @var string
     */
    protected $sector_nombre;

    /**
     *
     * @var string
     */
    protected $sector_nombreAbreviado;

    /**
     *
     * @var integer
     */
    protected $sector_activo;

    /**
     * Method to set the value of field sector_id
     *
     * @param integer $sector_id
     * @return $this
     */
    public function setSectorId($sector_id)
    {
        $this->sector_id = $sector_id;

        return $this;
    }

    /**
     * Method to set the value of field sector_nombre
     *
     * @param string $sector_nombre
     * @return $this
     */
    public function setSectorNombre($sector_nombre)
    {
        $this->sector_nombre = $sector_nombre;

        return $this;
    }

    /**
     * Method to set the value of field sector_nombreAbreviado
     *
     * @param string $sector_nombreAbreviado
     * @return $this
     */
    public function setSectorNombreabreviado($sector_nombreAbreviado)
    {
        $this->sector_nombreAbreviado = $sector_nombreAbreviado;

        return $this;
    }

    /**
     * Method to set the value of field sector_activo
     *
     * @param integer $sector_activo
     * @return $this
     */
    public function setSectorActivo($sector_activo)
    {
        $this->sector_activo = $sector_activo;

        return $this;
    }

    /**
     * Returns the value of field sector_id
     *
     * @return integer
     */
    public function getSectorId()
    {
        return $this->sector_id;
    }

    /**
     * Returns the value of field sector_nombre
     *
     * @return string
     */
    public function getSectorNombre()
    {
        return $this->sector_nombre;
    }

    /**
     * Returns the value of field sector_nombreAbreviado
     *
     * @return string
     */
    public function getSectorNombreabreviado()
    {
        return $this->sector_nombreAbreviado;
    }

    /**
     * Returns the value of field sector_activo
     *
     * @return integer
     */
    public function getSectorActivo()
    {
        return $this->sector_activo;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setConnectionService('dbUsuarios');
        //Deberia ser de solo lectura
        $this->setReadConnectionService('dbUsuarios');
        $this->hasMany('sector_id', 'Usuarios', 'usuario_sector', array('alias' => 'Usuarios'));
        $this->setSchema('gestionusuarios');

    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sectores';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Sectores[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Sectores
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
