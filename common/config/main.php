<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        // redis缓存
        'cache' => [
              'class' => 'yii\redis\Cache',
              'redis' => [
                  'hostname' => '127.0.0.1',
                  'port' => 6379,
                  'database' => 0,
              ]
         ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '127.0.0.1',
            'port' => 6379,
            'database' => 0,
        ],
        // 多语言
        'i18n' => [
            'translations' => [
                'restful*' => [
                    'class' => 'yii\i18n\DbMessageSource',                    // table cache
                    'sourceLanguage' => 'en-US',
                    'sourceMessageTable' => '{{%message_source}}',
                    'messageTable' => '{{%message_target}}',
                    // 开启缓存
                    'enableCaching' => true,
                    'cachingDuration' => 120,
                    'on missingTranslation' => ['restful\components\TranslationEventHandler', 'handleMissingTranslation'],
                ],
            ],
        ],
        //
    ],
];
