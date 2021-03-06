<?php
/**
 * Services are globally registered in this file
 *
 * @var \Phalcon\Config $config
 */

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
}, true);

/**
 * Setting up the view component
 */
$di->setShared('view', function () use ($config) {

    $view = new View();

    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines(array(
        '.volt' => function ($view, $di) use ($config) {

            $volt = new VoltEngine($view, $di);

            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ));
            $volt->getCompiler()->addFunction('is_a', 'is_a');
            $volt->getCompiler()->addFunction('base64', 'base64_encode');
            $volt->getCompiler()->addFilter('strtotime', 'strtotime');

            return $volt;
        },
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    ));

    return $view;
});
/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
    return new DbAdapter($config->database->toArray());
});
//GESTIONUSUARIOS
$di->set('dbUsuarios', function () use ($config) {
    return new DbAdapter($config->gestionusuarios->toArray());

});
/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () {
    return new MetaDataAdapter();
});
/**
 * Register the flash service with custom CSS classes
 */
$di->set('flash', function()
{
    return new Phalcon\Flash\Direct(array(
        'error'     => 'alert alert-danger',
        'success'   => 'alert alert-success',
        'notice'    => 'alert alert-info ',
        'warning'   => 'alert alert-warning ',
    ));
});
/**
 * Register the flash service with custom CSS classes
 */
$di->set('flashSession', function()
{
    return new Phalcon\Flash\Session(array(
        'error'     => 'alert alert-danger',
        'success'   => 'alert alert-success',
        'notice'    => 'alert alert-info ',
        'warning'   => 'alert alert-warning ',
    ));
});
/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter(
        [
            "uniqueId" => "libro",
        ]
    );
    $session->setOptions(array('max_execution_time'=>300));
    $session->start();

    return $session;
});
/**
 * Register a user component
 Sin usar
$di->set('elemento', function(){
    return new Entorno\Elements();
});
 */

/**
 * Registramos el gestor de eventos (Utilizado en plugins/Seguridad.php)
 */
$di->set('dispatcher', function() use ($di)
{
    $eventsManager = $di->getShared('eventsManager');

    $roles = new Seguridad($di);

    /**
     * Escuchamos eventos en el componente dispatcher usando el plugin Roles
     */
    $eventsManager->attach('dispatch', $roles);

    $dispatcher = new Phalcon\Mvc\Dispatcher();
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
});