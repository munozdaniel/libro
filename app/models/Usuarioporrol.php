<?php

class Usuarioporrol extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $usuario_id;

    /**
     *
     * @var integer
     */
    protected $rol_id;

    /**
     * Method to set the value of field usuario_id
     *
     * @param integer $usuario_id
     * @return $this
     */
    public function setUsuarioId($usuario_id)
    {
        $this->usuario_id = $usuario_id;

        return $this;
    }

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
     * Returns the value of field usuario_id
     *
     * @return integer
     */
    public function getUsuarioId()
    {
        return $this->usuario_id;
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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema('libro_phalcon');
        $this->belongsTo('rol_id', 'Rol', 'rol_id', array('alias' => 'Rol'));
        $this->belongsTo('usuario_id', 'Usuarios', 'usuario_id', array('alias' => 'Usuarios'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'usuarioporrol';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Usuarioporrol[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Usuarioporrol
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
