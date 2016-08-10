<?php

$loader = new \Phalcon\Loader();
// Register some namespaces
$loader->registerNamespaces(
    array(
        "Entorno"    => "../app/library/entorno/"
    )
);
/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    array(
        $config->application->controllersDir,
        $config->application->formsDir,
        $config->application->modelsDir
    )
)->register();
