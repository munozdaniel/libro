<?php

class Pagina extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $pagina_id;

    /**
     *
     * @var string
     */
    protected $pagina_nombreControlador;

    /**
     *
     * @var string
     */
    protected $pagina_nombreAccion;

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
     * Method to set the value of field pagina_nombreControlador
     *
     * @param string $pagina_nombreControlador
     * @return $this
     */
    public function setPaginaNombrecontrolador($pagina_nombreControlador)
    {
        $this->pagina_nombreControlador = $pagina_nombreControlador;

        return $this;
    }

    /**
     * Method to set the value of field pagina_nombreAccion
     *
     * @param string $pagina_nombreAccion
     * @return $this
     */
    public function setPaginaNombreaccion($pagina_nombreAccion)
    {
        $this->pagina_nombreAccion = $pagina_nombreAccion;

        return $this;
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
     * Returns the value of field pagina_nombreControlador
     *
     * @return string
     */
    public function getPaginaNombrecontrolador()
    {
        return $this->pagina_nombreControlador;
    }

    /**
     * Returns the value of field pagina_nombreAccion
     *
     * @return string
     */
    public function getPaginaNombreaccion()
    {
        return $this->pagina_nombreAccion;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema('libro_phalcon');
        $this->hasMany('pagina_id', 'Acceso', 'pagina_id', array('alias' => 'Acceso'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'pagina';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Pagina[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Pagina
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
