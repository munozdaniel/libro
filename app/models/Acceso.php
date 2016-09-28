<?php

class Acceso extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $acceso_id;

    /**
     *
     * @var integer
     */
    protected $rol_id;

    /**
     *
     * @var integer
     */
    protected $pagina_id;

    /**
     * Method to set the value of field acceso_id
     *
     * @param integer $acceso_id
     * @return $this
     */
    public function setAccesoId($acceso_id)
    {
        $this->acceso_id = $acceso_id;

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
     * Method to set the value of field pagina_id
     *
     * @param integer $pagina_id
     * @return $this
     */
    public function setPaginaId($pagina_id)
    {
        $this->pagina_id = $pagina_id;

        return $this;
    }

    /**
     * Returns the value of field acceso_id
     *
     * @return integer
     */
    public function getAccesoId()
    {
        return $this->acceso_id;
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
     * Returns the value of field pagina_id
     *
     * @return integer
     */
    public function getPaginaId()
    {
        return $this->pagina_id;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('pagina_id', 'Pagina', 'pagina_id', array('alias' => 'Pagina'));
        $this->belongsTo('rol_id', 'Rol', 'rol_id', array('alias' => 'Rol'));
        $this->setSchema('libro_phalcon');

    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'acceso';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Acceso[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Acceso
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
