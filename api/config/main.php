<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'online-malls',
    'name'=>'Malls Online',
  // 'language'=>'ar',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [
      'i18n' => [
        'translations' => [
            'app*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@common/messages',
                'sourceLanguage' => 'en-US',
                'fileMap' => [
                    'app' => 'app.php',
                    'app/error' => 'error.php',
                ],
            ],
        ],
    ], 
     
      
   'response' => [
            'class' => 'yii\web\Response',
         
        ],
        
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession'=>false,
        ],
            'request' => [
        'enableCookieValidation' => true,
        'enableCsrfValidation' => true,
        'cookieValidationKey' => '12345',
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
        'urlManager' => [
           
     'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => ['v1/vehicle','v1/user','v1/image','v1/export','v1/export-images','v1/condition','v1/features'],
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ]
                    
                ],
             
                    [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/user'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST login' => 'login',
                        'POST request-password-reset'=>'request-password-reset',
                        'OPTIONS request-password-reset'=>'options',
                        'POST reset-password'=>'reset-password',
                        'OPTIONS reset-password'=>'options',
                         'OPTIONS login' => 'options' ,
                        'POST signup' => 'signup', 
                        'OPTIONS signup' => 'options',
                  
                    ],
                ],
               
                       [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/vehicle'],
                    'pluralize' => false,
                    'extraPatterns' => [
                      'POST image-delete' => 'image-delete', 
                    'OPTIONS image-delete' => 'options'

                      // 'xxxxx' refers to 'actionXxxxx'
                    ],
                ],

                          [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/vehicle'],
                    'pluralize' => false,
                    'extraPatterns' => [
                      'GET get-customer' => 'get-customer', 
                    'OPTIONS get-customer' => 'options',
                    'GET locations' => 'locations', 
                    'OPTIONS locations' => 'options'
                      // 'xxxxx' refers to 'actionXxxxx'
                    ],
                ],
  
             

                    [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/encode'],
                    'pluralize' => false,
                    'extraPatterns' => [
                      'POST upload' => 'upload', 
                    'OPTIONS upload' => 'options'

                      // 'xxxxx' refers to 'actionXxxxx'
                    ],
                ],
             
                    [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/image'],
                    'pluralize' => false,
                    'extraPatterns' => [
                      'POST update-uploaded-images/{id}' => 'update-uploaded-images', 
                    'OPTIONS update-uploaded-images/{id}' => 'options'

                      // 'xxxxx' refers to 'actionXxxxx'
                    ],
                ],
                    [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/vehicle'],
                    'pluralize' => false,
                    'extraPatterns' => [
                      'POST update-vehicle/{id}' => 'update-vehicle', 
                    'OPTIONS update-vehicle/{id}' => 'options'

                      // 'xxxxx' refers to 'actionXxxxx'
                    ],
                ],
             
              
             
                    [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/upload'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST upload' => 'upload',
                          'OPTIONS upload' => 'options' // 'xxxxx' refers to 'actionXxxxx'
                    ],
                ],
         
                    
                    [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/upload'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST aws' => 'aws',
                          'OPTIONS aws' => 'aws' // 'xxxxx' refers to 'actionXxxxx'
                    ],
                ],
                    [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/user'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET activate-account' => 'activate-account',
                          'OPTIONS activate-account' => 'options' // 'xxxxx' refers to 'actionXxxxx'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/export-images'],
                    'pluralize' => false,
                    'extraPatterns' => [
                      'POST add-images' => 'add-images', 
                    'OPTIONS add-images' => 'options',
                      // 'xxxxx' refers to 'actionXxxxx'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/export-images'],
                    'pluralize' => false,
                    'extraPatterns' => [
                    'GET delete-images' => 'delete-images', 
                    'OPTIONS delete-images' => 'options'
                      // 'xxxxx' refers to 'actionXxxxx'
                    ],
                ],
            
                
            ],        
        ]
    ],
    'params' => $params,
];



