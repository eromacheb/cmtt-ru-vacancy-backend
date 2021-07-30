<?php

$config = require('config.php');

return
    [
        'paths' => [
            'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
            'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
        ],
        'environments' => [
            'default_migration_table' => 'migrations',
            'default_environment' => 'development',
            'development' => [
                'adapter' => 'mysql',
                'host' => $config['DB']['host'],
                'name' => $config['DB']['database'],
                'user' => $config['DB']['login'],
                'pass' => $config['DB']['pass'],
                'port' => $config['DB']['port'],
               'charset' => 'utf8',
            ]
        ],
        'version_order' => 'creation'
    ];
