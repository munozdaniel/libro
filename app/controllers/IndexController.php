<?php

class IndexController extends ControllerBase
{
    public function initialize()
    {

        parent::initialize();

    }

    /**
     * Solicita el inicio de sesión.
     */
    public function indexAction()
    {
        $this->tag->setTitle('Inicio');
        $this->view->cleanTemplateAfter();
    }

}

