<?php

defined('APP_PATH') || define('APP_PATH', realpath('.'));

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => '192.168.42.14',
        'username'    => 'root',
        'password'    => 'infoimps',
        'dbname'      => 'libro',
        'charset'     => 'utf8',
    ),
    'gestionusuarios' => array(
        'adapter'     => 'Mysql',
        'host'        => '201.251.125.209:4880',
        'username'    => 'root',
        'password'    => 'infoimps',
        'dbname'      => 'gestionusuarios',
        'charset'     => 'utf8',
    ),
    'application' => array(
        'controllersDir' => APP_PATH . '/app/controllers/',
        'modelsDir'      => APP_PATH . '/app/models/',
        'migrationsDir'  => APP_PATH . '/app/migrations/',
        'viewsDir'       => APP_PATH . '/app/views/',
        'pluginsDir'     => APP_PATH . '/app/plugins/',
        'libraryDir'     => APP_PATH . '/app/library/',
        'mpdfDir'        => APP_PATH . '/app/library/mpdf/',
        'formsDir'       => APP_PATH . '/app/forms/',
        'cacheDir'       => APP_PATH . '/app/cache/',
        'baseUri'        => '/libro/',
    )
));
