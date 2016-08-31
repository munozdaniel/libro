<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class RolController extends ControllerBase
{

    public function verTodosLosRolesAction()
    {
        $this->setDatatables();

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Rol", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "rol_id";

        $rol = Rol::find($parameters);
        if (count($rol) == 0) {
            $this->flash->notice("No se encontraron resultados");

            return $this->dispatcher->forward(array(
                "controller" => "rol",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $rol,
            "limit"=> 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }


    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for rol
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Rol", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "rol_id";

        $rol = Rol::find($parameters);
        if (count($rol) == 0) {
            $this->flash->notice("The search did not find any rol");

            return $this->dispatcher->forward(array(
                "controller" => "rol",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $rol,
            "limit"=> 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a rol
     *
     * @param string $rol_id
     */
    public function editAction($rol_id)
    {

        if (!$this->request->isPost()) {

            $rol = Rol::findFirstByrol_id($rol_id);
            if (!$rol) {
                $this->flash->error("rol was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "rol",
                    "action" => "index"
                ));
            }

            $this->view->rol_id = $rol->rol_id;

            $this->tag->setDefault("rol_id", $rol->getRolId());
            $this->tag->setDefault("rol_nombre", $rol->getRolNombre());
            $this->tag->setDefault("rol_descripcion", $rol->getRolDescripcion());
            
        }
    }

    /**
     * Creates a new rol
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "rol",
                "action" => "index"
            ));
        }

        $rol = new Rol();

        $rol->setRolNombre($this->request->getPost("rol_nombre"));
        $rol->setRolDescripcion($this->request->getPost("rol_descripcion"));
        

        if (!$rol->save()) {
            foreach ($rol->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "rol",
                "action" => "new"
            ));
        }

        $this->flash->success("rol was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "rol",
            "action" => "index"
        ));

    }

    /**
     * Saves a rol edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "rol",
                "action" => "index"
            ));
        }

        $rol_id = $this->request->getPost("rol_id");

        $rol = Rol::findFirstByrol_id($rol_id);
        if (!$rol) {
            $this->flash->error("rol does not exist " . $rol_id);

            return $this->dispatcher->forward(array(
                "controller" => "rol",
                "action" => "index"
            ));
        }

        $rol->setRolNombre($this->request->getPost("rol_nombre"));
        $rol->setRolDescripcion($this->request->getPost("rol_descripcion"));
        

        if (!$rol->save()) {

            foreach ($rol->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "rol",
                "action" => "edit",
                "params" => array($rol->rol_id)
            ));
        }

        $this->flash->success("rol was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "rol",
            "action" => "index"
        ));

    }

    /**
     * Deletes a rol
     *
     * @param string $rol_id
     */
    public function deleteAction($rol_id)
    {

        $rol = Rol::findFirstByrol_id($rol_id);
        if (!$rol) {
            $this->flash->error("rol was not found");

            return $this->dispatcher->forward(array(
                "controller" => "rol",
                "action" => "index"
            ));
        }

        if (!$rol->delete()) {

            foreach ($rol->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "rol",
                "action" => "search"
            ));
        }

        $this->flash->success("rol was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "rol",
            "action" => "index"
        ));
    }

}
