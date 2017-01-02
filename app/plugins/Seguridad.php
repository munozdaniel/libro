<?php
use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Event;
use Phalcon\Acl\Resource;
class Seguridad extends \Phalcon\Mvc\User\Plugin
{
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        $auth = $this->session->get('auth_libro');
        if(!$auth)
            $role = 'INVITADO';
        else
            $role = $auth["rol_nombre"];

        //nombre del controlador al que intentamos acceder
        $controller = $dispatcher->getControllerName();

        //nombre de la acción a la que intentamos acceder
        $action = $dispatcher->getActionName();

        //obtenemos la Lista de Control de Acceso(acl_libro) que hemos creado
        $acl_libro = $this->getAcl();

        //boolean(true | false) si tenemos permisos devuelve true en otro caso false
        $allowed = $acl_libro->isAllowed($role, $controller, $action);

        //si el usuario no tiene acceso a la zona que intenta acceder
        //se lo redirecciona a login. (o habria que enviarlo al index? )
        //con un mensaje flash
        if ($allowed != \Phalcon\Acl::ALLOW)
        {
            $this->flash->message('problema',"<p>ZONA RESTRINGIDA, NO TIENES PERMISO PARA ACCEDER A LA SECCIÓN SOLICITADA</p>");
            $dispatcher->forward(
                array(
                    'controller' => 'index',
                    'action' => 'index'
                )
            );
            return false;
        }
    }

    /**
     * lógica para crear una aplicación con roles de usuarios
     */
    public function getAcl()
    {
        if (!isset($this->persistent->acl_libro))
        {
            //creamos la instancia de acl_libro para crear los roles
            $acl_libro = new Phalcon\Acl\Adapter\Memory();

            //por defecto la acción será denegar el acceso a cualquier zona
            $acl_libro->setDefaultAction(Phalcon\Acl::DENY);
            //----------------------------ROLES-----------------------------------

            //registramos los roles que deseamos tener en nuestra aplicación****
            $listaRoles = Rol::find();
            foreach($listaRoles as $rol)
            {
                $acl_libro->addRole(new \Phalcon\Acl\Role($rol->rol_nombre));

                //Recupero todas las paginas de cada rol
                $query = $this->modelsManager->createQuery("SELECT pagina.* FROM Acceso AS acceso,Pagina AS pagina,Rol AS rol WHERE rol.rol_id=".$rol->rol_id." and rol.rol_id=acceso.rol_id and acceso.pagina_id=pagina.pagina_id");
                $listaPaginasPorRol = $query->execute();

                foreach($listaPaginasPorRol as $pagina)
                {
                    $acl_libro->addResource(new Resource($pagina->pagina_nombreControlador),$pagina->pagina_nombreAccion);
                    $acl_libro->allow($rol->rol_nombre,$pagina->pagina_nombreControlador,$pagina->pagina_nombreAccion);
                }
            }
            //El acl_libro queda almacenado en sesión
            $this->persistent->acl_libro = $acl_libro;

        }

        return $this->persistent->acl_libro;
    }

}