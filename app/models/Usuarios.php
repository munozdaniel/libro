<?php

class Usuarios extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $usuario_id;

    /**
     *
     * @var string
     */
    protected $usuario_nick;

    /**
     *
     * @var string
     */
    protected $usuario_nombreCompleto;

    /**
     *
     * @var string
     */
    protected $usuario_contrasenia;

    /**
     *
     * @var integer
     */
    protected $usuario_sector;

    /**
     *
     * @var string
     */
    protected $usuario_email;

    /**
     *
     * @var integer
     */
    protected $usuario_activo;

    /**
     *
     * @var string
     */
    protected $usuario_fechaCreacion;

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
     * Method to set the value of field usuario_nick
     *
     * @param string $usuario_nick
     * @return $this
     */
    public function setUsuarioNick($usuario_nick)
    {
        $this->usuario_nick = $usuario_nick;

        return $this;
    }

    /**
     * Method to set the value of field usuario_nombreCompleto
     *
     * @param string $usuario_nombreCompleto
     * @return $this
     */
    public function setUsuarioNombrecompleto($usuario_nombreCompleto)
    {
        $this->usuario_nombreCompleto = $usuario_nombreCompleto;

        return $this;
    }

    /**
     * Method to set the value of field usuario_contrasenia
     *
     * @param string $usuario_contrasenia
     * @return $this
     */
    public function setUsuarioContrasenia($usuario_contrasenia)
    {
        $this->usuario_contrasenia = $usuario_contrasenia;

        return $this;
    }

    /**
     * Method to set the value of field usuario_sector
     *
     * @param integer $usuario_sector
     * @return $this
     */
    public function setUsuarioSector($usuario_sector)
    {
        $this->usuario_sector = $usuario_sector;

        return $this;
    }

    /**
     * Method to set the value of field usuario_email
     *
     * @param string $usuario_email
     * @return $this
     */
    public function setUsuarioEmail($usuario_email)
    {
        $this->usuario_email = $usuario_email;

        return $this;
    }

    /**
     * Method to set the value of field usuario_activo
     *
     * @param integer $usuario_activo
     * @return $this
     */
    public function setUsuarioActivo($usuario_activo)
    {
        $this->usuario_activo = $usuario_activo;

        return $this;
    }

    /**
     * Method to set the value of field usuario_fechaCreacion
     *
     * @param string $usuario_fechaCreacion
     * @return $this
     */
    public function setUsuarioFechacreacion($usuario_fechaCreacion)
    {
        $this->usuario_fechaCreacion = $usuario_fechaCreacion;

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
     * Returns the value of field usuario_nick
     *
     * @return string
     */
    public function getUsuarioNick()
    {
        return $this->usuario_nick;
    }

    /**
     * Returns the value of field usuario_nombreCompleto
     *
     * @return string
     */
    public function getUsuarioNombrecompleto()
    {
        return $this->usuario_nombreCompleto;
    }

    /**
     * Returns the value of field usuario_contrasenia
     *
     * @return string
     */
    public function getUsuarioContrasenia()
    {
        return $this->usuario_contrasenia;
    }

    /**
     * Returns the value of field usuario_sector
     *
     * @return integer
     */
    public function getUsuarioSector()
    {
        return $this->usuario_sector;
    }

    /**
     * Returns the value of field usuario_email
     *
     * @return string
     */
    public function getUsuarioEmail()
    {
        return $this->usuario_email;
    }

    /**
     * Returns the value of field usuario_activo
     *
     * @return integer
     */
    public function getUsuarioActivo()
    {
        return $this->usuario_activo;
    }

    /**
     * Returns the value of field usuario_fechaCreacion
     *
     * @return string
     */
    public function getUsuarioFechacreacion()
    {
        return $this->usuario_fechaCreacion;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setConnectionService('dbUsuarios');
        //Deberia ser de solo lectura
        $this->setReadConnectionService('dbUsuarios');
        $this->belongsTo('usuario_sector', 'Sectores', 'sector_id', array('alias' => 'Sectores'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'usuarios';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Usuarios[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Usuarios
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Devuelve el rol que tiene asignado el usuario asignado
     */
    public function getRolAsignado(){
        $usuarioPorRol = Usuarioporrol::findFirst(array('usuario_id=:usuario_id:','bind'=>array('usuario_id'=>$this->getUsuarioId())));
        if($usuarioPorRol)
        {
            $rol= Rol::findFirst(array('rol_id=:rol_id:','bind'=>array('rol_id'=>$usuarioPorRol->getRolId())));
            if($rol)
                return '<div  class="btn btn-info btn-block">' .$rol->getRolNombre().'</div>';
        }
        return '<div  class="btn btn-danger btn-block">SIN ASIGNAR</div>';
    }
}
