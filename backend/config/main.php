<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
  
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
      'container' => [
        'definitions' => [
            yii\grid\GridView::class => [
                'tableOptions' => [
                    'class' => 'table table-condensed',
                ],
            ],
        ],
    ],
    'modules' => ['admin' => [
           'layout' => '//left-menu',
            'class' => 'mdm\admin\Module',
            'controllerMap' => [
            'assignment' => [
                'class' => 'mdm\admin\controllers\AssignmentController',
                'userClassName' => 'common\models\User',
                'idField' => 'user_id'
            ],
            'other' => [
                'class' => 'path\to\OtherController', // add another controller
            ],
        ],
    ],
    'gridview' =>  [
        'class' => '\kartik\grid\Module'
        // enter optional module parameters below - only if you need to  
        // use your own export download action or custom translation 
        // message source
        // 'downloadAction' => 'gridview/export/download',
        // 'i18n' => []
    ]
        ],
    'components' => [
    'formatter' => [
        'class' => 'yii\i18n\Formatter',
        'thousandSeparator' => ',',
        'decimalSeparator' => '.',
        'currencyCode' => 'USD',
        'nullDisplay' => '',
    ],
      
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
         'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'autodetectCluster' => true,
            'nodes' => [
              [ 'http_address' => '127.0.0.1:9200'],
                // configure more hosts if you have a cluster
            ],
        ],
    
    'view' => [
        'theme' => [
            'pathMap' => [
                '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/phundament/app'
            ],
        ],
    ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'practical-a-backend',
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
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'authManager' => [
              'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ],
    ],
    'as access' => [
       'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'import/*',
            'site/delete-image',
            'vehicle/frontsearch',
            'vehicle/download-images',
            'some-controller/some-action',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
       ]
    ],
    'params' => $params,
];
