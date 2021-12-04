<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'tk',
    'timeZone' => 'Asia/Ashgabat',
    'name' => 'Gypjakdaky Saparmyrat Nyýazow adyndaky dokma toplumy',
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableRegistration' => false,
            'enableConfirmation' => false,
            'enableUnconfirmedLogin' => true,
            'modelMap' => [
                'Profile' => 'common\models\security\Profile',
                'LoginForm' => 'common\models\security\LoginForm',
                'User' => 'common\models\security\User',
            ],
            'adminPermission' => 'admin',
        ],

        'rbac' => [
            'class' => 'dektrium\rbac\RbacWebModule',
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => '6LfSKZ0UAAAAAHDE7aU5BLotXx6fKeBzhJZZI2Ks',
            'secret' => '6LfSKZ0UAAAAAMMjk39GjiH6BXgvdA5e3gIOnAsI',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null, // do not publish the bundle
//                    'js' => ['//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js',]
                    'js' => [ '/source/js/jquery.min.js', ]
                ],
            ],
        ],
        'mobileDetect' => [
            'class' => '\skeeks\yii2\mobiledetect\MobileDetect'
        ],

        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
                'backend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'app' => 'backend.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],


        'image' => array(
            'class' => 'yii\image\ImageDriver',
            'driver' => 'GD',  //GD or Imagick
        ),


        /*      'mail' => [
                  'class'            => 'zyx\phpmailer\Mailer',
                  'viewPath'         => '@common/mail',
                  'useFileTransport' => false,
                  'config'           => [
                      'mailer'     => 'smtp',
                      'host'       => 'mail.conqueramazon.com',
                      'port'       => '465',
                      'smtpsecure' => 'ssl',
                      'smtpauth'   => true,
                      'username'   => 'root@mail.conqueramazon.com',
                      'password'   => 's8K#.mVh5bT3',
                      'ishtml'=>true,
                      'charset'=>'UTF-8'
                  ],
              ],
          */
        'common' => [
            'class' => 'common\components\Common'
        ],

        'setting' => [
            'class' => 'common\components\SettingService'
        ],


        'mailer' => [
            // 'class' => 'yii\swiftmailer\Mailer',
            // 'viewPath' => '@common/mail',
            // 'useFileTransport' => false,//set this property to false to send mails to real email addresses
            // 'transport' => [
            //     'class' => 'Swift_SmtpTransport',
            //     'host' => 'smtp.yandex.com',
            //     'username' => 'info@turkmenteatrlary.gov.tm',
            //     'password' => '@hmetGulluk2019',
            //     'port' => '587',
            //     'encryption' => 'tls',
            //     'streamOptions' => [
            //         'ssl' => [
            //             'verify_peer' => false,
            //             'verify_peer_name' => false,
            //             'allow_self_signed' => false
            //         ],
            //     ],
            // ],
//
//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => 'smtp.yandex.com',
////                'username' => 'hasaphesip@gmail.com',
//                'username' => 'info@turkmenteatrlary.gov.tm',
//                'password' => '@hmetGulluk2019',
////                'port' => '587',
//                'port' => '465',
////                'encryption' => 'tls',
////                'encryption' => 'ssl',
//                'streamOptions' => [
//                    'ssl' => [
//                        'verify_peer' => false,
//                        'verify_peer_name' => false,
//                        'allow_self_signed' => false
//                    ],
//                ],
//            ],

            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
//            'useFileTransport' => true,
        ],

//        'urlManager' => [
//            'class' => 'codemix\localeurls\UrlManager',
//            'languages' => ['en', 'ru', 'tk'],
////            'class' => 'yii\web\UrlManager',
////            'baseUrl' => 'http://conqueramazon.com/frontend/web/',
//            // Disable index.php
//            'showScriptName' => false,
//            // Disable r= routes
//            'enablePrettyUrl' => true,
//            'rules' => array(
//                '<controller:\w+>/<id:\d+>' => '<controller>/view',
//                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
//                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
//            ),
//        ],


        'urlManagerFrontEnd' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => 'https://turkmenteatrlary.gov.tm',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => array(
                'm/<module:\w+>/<controller:\w+>/<id:\d+>' => '<module>/<controller>/view',
                'm/<module:\w+>/<controller:\w+>/<action:[\w\-\/]+>' => '<module>/<controller>/<action>',
                'm/<module:\w+>/<controller:\w+>/<action:[\w\-\/]+>/<id:\d+>' => '<module>/<controller>/<action>',

                '<controller:\w+>/<id:\d+>/<alias:[\w\-]+>' => '<controller>/view',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/a/<action:[\w\-\/]+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/a/<action:[\w\-\/]+>' => '<controller>/<action>',
                '<controller:\w+>/<path:[\w\-\/]+>' => '<controller>/index',
            ),
        ],

        'urlManager' => [
            'class' => 'codemix\localeurls\UrlManager',
//            'class' => 'yii\web\UrlManager',


            // List all supported languages here
            // Make sure, you include your app's default language.
//            'languages' => ['en', 'ru', 'tk'],
//            'ignoreLanguageUrlPatterns' => [
//                // route pattern => url pattern
//                '^mobile/*^' => '^mobile/*^',
////                '#^api/#' => '#^api/#',
//            ],
            'enableLanguageDetection' => false,
            // '_defaultLanguage' => 'tk',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => array(
//                'm/<module:\w+>/<controller:\w+>/<id:\d+>' => '<module>/<controller>/view',
//                'm/<module:\w+>/<controller:\w+>/<action:[\w\-\/]+>' => '<module>/<controller>/<action>',
//                'm/<module:\w+>/<controller:\w+>/<action:[\w\-\/]+>/<id:\d+>' => '<module>/<controller>/<action>',
//
//                '<controller:\w+>/<id:\d+>/<alias:[\w\-]+>' => '<controller>/view',
//                '<controller:\w+>/<id:\d+>' => '<controller>/view',
//                '<controller:\w+>/a/<action:[\w\-\/]+>/<id:\d+>' => '<controller>/<action>',
//                '<controller:\w+>/a/<action:[\w\-\/]+>' => '<controller>/<action>',
//                '<controller:\w+>/<path:[\w\-\/]+>' => '<controller>/index',

//                '<controller:\w+>/<id:\d+>' => '<controller>/view',
//                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
//                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',

            ),
        ],
    ],
];
