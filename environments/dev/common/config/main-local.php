<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=beiwo_sofa',
            'username' => 'beiwo_sofa',
            'password' => 'BriwSr6ZYAyAx5r6',
            'tablePrefix' => 'sf_',
            'charset' => 'utf8mb4',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '127.0.0.1',
            'port' => 6381,
            'password' => 'guazity1987',
            'database' => 8
        ]
    ],
];
