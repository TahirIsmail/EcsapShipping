<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
return [
    'id' => 'webapi-service',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'app\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-webapi',
//             'parsers' => [
//                 'application/json' => 'yii\web\JsonParser',
//             ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => FALSE,
            'identityCookie' => ['name' => '_identity-webapi', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the webapi
//             'enableSession ' => FALSE,
            'name' => 'webapi-service',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'search/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
//                 '/' => 'webapi/login',
            ],
        ],
        
    ],
    'defaultRoute' => 'webapi/login',
    'params' => $params,
];
