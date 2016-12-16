<?php

defined('APP_PATH') || define('APP_PATH', realpath('.'));
set_time_limit(300);

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => '172.16.10.34',
        'username'    => 'root',
        'password'    => 'infoimps',
        'dbname'      => 'libro_phalcon',
        'charset'     => 'utf8',
    ),
    'gestionusuarios' => array(
        'adapter'     => 'Mysql',
        'host'        => '172.16.10.34',
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
        'componentesDir'       => APP_PATH . '/app/library/componentes/',
        'cacheDir'       => APP_PATH . '/app/cache/',
        'baseUri'        => '/libro/',
    )
));
