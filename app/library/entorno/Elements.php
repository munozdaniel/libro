<?php
namespace Entorno;

use Phalcon\Mvc\User\Component;

/**
 * Elements
 *Sin usar
 * Helps to build UI elements for the application
 */
class Elements extends Component
{
    public function __construct()
    {
        $this->_user =  $this->session->get('auth');
    }
    private $_user ="";
    public function getUsuario(){
        return $this->_user['usuario_nick'];
    }
    public function getSector()
    {
        return $this->_user['usuario_nick'];
    }
    public function getNombreUsuario()
    {
        return $this->_user['usuario_nick'];
    }
    public function getRol()
    {
        return $this->_user['usuario_nick'];
    }


}
