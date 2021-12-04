<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'name' => 'Turkmenteatrlary.gov.tm',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'backend\controllers',

    'modules' => [
        'user' => [
            'as backend' => 'dektrium\user\filters\BackendFilter',
            'controllerMap' => [
                'security' => 'backend\controllers\user\SecurityController',
//                'recovery' => 'backend\controllers\user\RecoveryController',
                'admin' => 'backend\controllers\user\AdminController',
//                'admin' => 'backend\controllers\user\SecurityController'
            ],
        ],
//        'db-manager' => [
//            'class' => 'bs\dbManager\Module',
//            // path to directory for the dumps
//            'path' => '@app/backups',
//            // list of registerd db-components
//            'dbList' => ['db'],
////            'as access' => [
////                'class' => 'yii\filters\AccessControl',
////                'rules' => [
////                    [
////                        'allow' => true,
////                        'roles' => ['admin'],
////                    ],
////                ],
////            ],
//        ],

        'gridview' => ['class' => 'kartik\grid\Module'],
        'backuprestore' => [
            'class' => '\oe\modules\backuprestore\Module',
            'as access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            //'layout' => '@admin-views/layouts/main', or what ever layout you use
        ],
    ],

    'components' => [
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views/layouts' => '@backend/views/layouts',
                    '@dektrium/user/views/security' => '@backend/views/user/security',
                    '@dektrium/user/views/admin' => '@backend/views/user/admin',
                    '@oe/modules/backuprestore/views' => '@app/views/backuprestore'
                ],
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null, // do not publish the bundle
//                    'js' => ['//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js',]
                    'js' => [ '/backend/js/jquery.min.js' ]
                ],
            ],
        ],
        'request' => [
            'class' => 'common\components\Request',
            'web' => '/backend/web',
            'adminUrl' => '/backend',
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'urlManager' => [
            'enableDefaultLanguageUrlCode' => false,
            'languages' => ['tk', 'ru', 'en'],
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ],


        'user' => [
            'identityClass' => 'common\models\security\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
//            'name' => 'advanced-backend',
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
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
