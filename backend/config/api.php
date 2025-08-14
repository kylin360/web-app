<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'cross-border-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'v1/site/index',
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'enableCsrfValidation' => false,
            'enableCookieValidation' => false,
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
        ],
        'errorHandler' => [
            'class' => 'app\components\ErrorHandler',
            'errorAction' => null,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => array_merge(
                require __DIR__ . '/router.php',
                [
                    '' => 'v1/site/index',
                    'v1' => 'v1/site/index',
                ]
            ),
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@runtime/logs/app_' . date('Ymd') . '.log',
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'exportInterval' => 1,
                    'levels' => ['info'],
                    'logFile' => '@runtime/logs/info_' . date('Ymd') . '.log',
                ],
            ],
        ],
        'db' => $db,
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'redis',
            'port' => 6379,
            'database' => 0,
        ],
    ],

    'params' => $params,
];

// 添加 CORS 支持
$config['components']['corsFilter'] = [
    'class' => \yii\filters\Cors::class,
    'cors' => [
        'Origin' => ['*'],
        'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
        'Access-Control-Request-Headers' => ['*'],
        'Access-Control-Allow-Credentials' => true,
    ],
];

return $config;
