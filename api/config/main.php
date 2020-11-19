<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    //require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php'
    //require __DIR__ . '/params-local.php'
);

$config = [
    'id'        => 'api',
    'name'      => 'vi-test',
    'bootstrap' => [
        'log',
        function () {Yii::setAlias('@webroot', realpath(__DIR__ . '/../../web'));}
    ],
    'basePath'  => dirname(__DIR__) . '/..',
    'language'  => 'en',
    'sourceLanguage' => 'en_US',
    'modules'   => [
        'v1' => [
            'class' => 'app\api\versions\v1\Module',
        ],
    ],
    'components' => [
        'security' => [
            'class' => \yii\base\Security::class,
            'passwordHashCost' => 10,
        ],
        'user' => [
            'enableAutoLogin' => true,
            'identityClass'   => '\app\modules\users\models\User',
            'class'           => '\app\components\User',
            'enableSession'   => true,
            'loginUrl'        => null
        ],
        'request' => [
            'enableCookieValidation' => false,
            'enableCsrfValidation'   => false,
//            'parsers' => [
//                'application/json' => 'yii\web\JsonParser',
//            ]
        ],
        'response' => [
            'class'      => 'yii\web\Response',
            'format'     => yii\web\Response::FORMAT_JSON,
            'charset'    => 'UTF-8',
            'formatters' => [
                \yii\web\Response::FORMAT_JSON => [
                    'class'         => 'yii\web\JsonResponseFormatter',
                    'prettyPrint'   => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],


        'urlManager' => [
            'enablePrettyUrl'     => true,
            'enableStrictParsing' => true,
            'showScriptName'      => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', /*'controller' => 'user'*/],

            ]
        ],

    ],
    'params' => $params
];

return \yii\helpers\ArrayHelper::merge(
    $config,
    file_exists(__DIR__ . '/local.main.php') ? require __DIR__ . '/local.main.php' : []
);
