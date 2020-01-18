<?php

namespace backend\controllers;

use common\models\AuditLog;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

/**
 * REST 控制器基类。
 *
 * Class BaseController
 * @package backend\controllers
 */
class BaseController extends ActiveController
{
	protected $auditLogId;

	// 免验证路径白名单
	protected $pathWhitelist = [
		'users/login',
		'users/logout',
	];

	/**
	 * 序列化器。框架默认是将数据的分页信息保存在响应头中。修改后，将在响应体中包含这些分页数据。
	 *
	 * 参见：https://www.yiichina.com/doc/guide/2.0/rest-response-formatting 一节的“数据序列化”。
	 *
	 * @var array
	 */
	public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'items',
	];

	/**
	 * 修改默认行为。参见：https://www.yiichina.com/doc/guide/2.0/rest-controllers
	 *
	 * @return array
	 */
	public function behaviors()
	{
		$request = \Yii::$app->request;
		$pathInfo = $request->pathInfo;

		$behaviors = parent::behaviors();

		// 仅以 JSON 输出结果(默认包含XML格式)
		$behaviors['contentNegotiator']['formats'] = [
			'application/json' => \yii\web\Response::FORMAT_JSON,
		];

		// 移除过滤器，重新编排
		unset($behaviors['authenticator']);
		unset($behaviors['rateLimiter']);

		// 先添加 CORS 过滤器
		$behaviors['corsFilter'] = [
			'class' => \yii\filters\Cors::class,
			'cors' => [
				'Origin' => static::allowedDomains(),
				'Access-Control-Max-Age' => 86400,
				'Access-Control-Request-Headers' => ['*'],
				'Access-Control-Allow-Credentials' => true,
				'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
			],
		];

		// 对白名单的 URL，不需要使用认证/授权
		if (!in_array($pathInfo, $this->pathWhitelist)) {
			// 同时支持三种授权模式认证，参见：https://www.yiichina.com/doc/guide/2.0/rest-authentication
			$behaviors['authenticator'] = [
				'class' => CompositeAuth::class,
				'except' => ['options'],
				'authMethods' => [
					HttpBasicAuth::class,
					HttpBearerAuth::class,
					QueryParamAuth::class,
				],
			];

			// 限流设置(注意限流要放在过滤器的最后端执行)
			$behaviors['rateLimiter'] = [
				'class' => \yii\filters\RateLimiter::class,
				'enableRateLimitHeaders' => true,
			];
		}

		return $behaviors;
	}

	public static function allowedDomains()
	{
		return [
			// '*',
			'http://localhost:8666',
		];
	}

	/**
	 * @param \yii\base\Action $action
	 * @return bool
	 * @throws \yii\web\BadRequestHttpException
	 */
	public function beforeAction($action)
	{
		$res = parent::beforeAction($action);

		$this->auditLogId = AuditLog::saveAuditLog();

		return $res;
	}
}