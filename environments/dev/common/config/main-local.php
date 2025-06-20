<?php

return [
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'pgsql:host=postgres;port=5432;dbname=review_system',
            'username' => 'admin',
            'password' => 'admin',
            'charset' => 'utf8',
        ],
    ],
];
