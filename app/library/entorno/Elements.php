<?php
namespace Entorno;

use Phalcon\Mvc\User\Component;

/**
 * Elements
 *
 * Helps to build UI elements for the application
 */
class Elements extends Component
{

    private $_headerMenu = array(

            'nota' => array(
                'caption' => 'NOTAS',
                'action' => 'search'
            ),
            'memo' => array(
                'caption' => 'MEMO',
                'action' => 'search'
            ),
            'resoluciones' => array(
                'caption' => 'RESOLUCIONES',
                'action' => 'search'
            ),
            'disposicion' => array(
                'caption' => 'DISPOSICIONES',
                'action' => 'search'
            ),
            'expediente' => array(
                'caption' => 'EXPEDIENTES',
                'action' => 'search'
            ),
            'sesion' => array(
                'caption' => 'INGRESAR',
                'action' => 'index'
            ),
    );

    /**
     * Builds header menu with left and right items
     *
     * @return string
     */
    public function getMenu()
    {

        $auth = $this->session->get('auth');
        if ($auth) {
            $this->_headerMenu['sesion'] = array(
                'caption' => 'SALIR',
                'action' => 'cerrar'
            );
        }

        $controllerName = $this->view->getControllerName();
            echo '<ul  id="menu-top"  class="nav navbar-nav navbar-right">';
            foreach ($this->_headerMenu  as $controller => $option) {
                if ($controllerName == $controller) {
                    echo '<li class="menu-top-active">';
                } else {
                    echo '<li>';
                }
                echo $this->tag->linkTo($controller . '/' . $option['action'], $option['caption']);
                echo '</li>';
            }
            echo '</ul>';
            echo '</div>';

    }

    /**
     * Returns menu tabs
     */
    public function getTabs()
    {
        $controllerName = $this->view->getControllerName();
        $actionName = $this->view->getActionName();
        echo '<ul class="nav nav-tabs">';
        foreach ($this->_tabs as $caption => $option) {
            if ($option['controller'] == $controllerName && ($option['action'] == $actionName || $option['any'])) {
                echo '<li class="active">';
            } else {
                echo '<li>';
            }
            echo $this->tag->linkTo($option['controller'] . '/' . $option['action'], $caption), '</li>';
        }
        echo '</ul>';
    }
}
