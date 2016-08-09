<?php

class Rol extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $rol_id;

    /**
     *
     * @var string
     */
    protected $rol_nombre;

    /**
     *
     * @var string
     */
    protected $rol_descripcion;

    /**
     * Method to set the value of field rol_id
     *
     * @param integer $rol_id
     * @return $this
     */
    public function setRolId($rol_id)
    {
        $this->rol_id = $rol_id;

        return $this;
    }

    /**
     * Method to set the value of field rol_nombre
     *
     * @param string $rol_nombre
     * @return $this
     */
    public function setRolNombre($rol_nombre)
    {
        $this->rol_nombre = $rol_nombre;

        return $this;
    }

    /**
     * Method to set the value of field rol_descripcion
     *
     * @param string $rol_descripcion
     * @return $this
     */
    public function setRolDescripcion($rol_descripcion)
    {
        $this->rol_descripcion = $rol_descripcion;

        return $this;
    }

    /**
     * Returns the value of field rol_id
     *
     * @return integer
     */
    public function getRolId()
    {
        return $this->rol_id;
    }

    /**
     * Returns the value of field rol_nombre
     *
     * @return string
     */
    public function getRolNombre()
    {
        return $this->rol_nombre;
    }

    /**
     * Returns the value of field rol_descripcion
     *
     * @return string
     */
    public function getRolDescripcion()
    {
        return $this->rol_descripcion;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('rol_id', 'Acceso', 'rol_id', array('alias' => 'Acceso'));
        $this->hasMany('rol_id', 'Usuarioporrol', 'rol_id', array('alias' => 'Usuarioporrol'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'rol';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Rol[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Rol
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
