<?php

return array(

    'default' => 'pgsql',

    'connections' => array(
        'pgsql' => array(
            'driver' => 'pgsql',
            'host' => 'localhost',
            'database' => 'patchnotes-test',
            'username' => 'patchnotes',
            'password' => '',
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
        ),
    ),

);
