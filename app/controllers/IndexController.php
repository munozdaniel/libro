<?php

class IndexController extends ControllerBase
{
    public function initialize()
    {

        parent::initialize();

    }

    public function indexAction()
    {
        $this->tag->setTitle('Inicio');

    }

}

