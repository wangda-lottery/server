<?php

$params = array_merge(
	require __DIR__ . '/../../common/config/params.php',
	require __DIR__ . '/../../common/config/params-local.php',
	require __DIR__ . '/params.php',
	require __DIR__ . '/params-local.php'
);

return [
	'id' => 'app-backend',
	'basePath' => dirname(__DIR__),
	'controllerNamespace' => 'backend\controllers',
	'bootstrap' => [
		'log',
	],
	'modules' => [],
	'components' => [
		'request' => [
			'parsers' => [
				'application/json' => 'yii\web\JsonParser',
			]
		],
		'response' => [
			'class' => 'yii\web\Response',
			'format' => yii\web\Response::FORMAT_JSON,
			'charset' => 'UTF-8',
		],
		'session' => [
			// this is the name of the session cookie used for login on the backend
			'name' => 'backend',
			'loginUrl' => 'http://www.baidu.com'
		],
		'user' => [
			'enableSession' => false,
			'identityClass' => 'common\models\User'
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					// 'levels' => ['error', 'warning'],
					'logFile' => '@runtime/logs/http-request.log',
					'categories' => ['yii\httpclient\*'],
				],
			],
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'urlManager' => [
			'enablePrettyUrl' => true,
			'enableStrictParsing' => true,
			'showScriptName' => false,
			'rules' => [
				['class' => 'yii\rest\UrlRule', 'controller' => 'param'],
				['class' => 'yii\rest\UrlRule', 'controller' => 'report'],
				[
					'class' => 'yii\rest\UrlRule',
					'controller' => 'schedule',
					'extraPatterns' => [
						'GET keep_alive' => 'keep',
					]
				],
				[
					'class' => 'yii\rest\UrlRule',
					'controller' => 'draw',
					'extraPatterns' => [
						'POST export' => 'export',
						'OPTIONS export' => 'export',
					]
				],
				[
					'class' => 'yii\rest\UrlRule',
					'controller' => 'member-top-up',
					'extraPatterns' => [
						'POST import' => 'import',
						'OPTIONS import' => 'import',
					]
				],
				[
					'class' => 'yii\rest\UrlRule',
					'controller' => 'user',
					'except' => ['delete'],
					'extraPatterns' => [
						'POST login' => 'login',
						'POST logout' => 'logout'
					]
				],
			],
		],
	],
	'params' => $params,
];
