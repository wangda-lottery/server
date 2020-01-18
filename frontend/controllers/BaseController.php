<?php

namespace frontend\controllers;

use common\models\AuditLog;
use yii\rest\ActiveController;

/**
 * REST 控制器基类。
 *
 * Class BaseController
 * @package frontend\controllers
 */
class BaseController extends ActiveController
{
	public function behaviors()
	{
		return [
			[
				'class' => \yii\filters\ContentNegotiator::className(),
				'formats' => [
					'application/json' => \yii\web\Response::FORMAT_JSON,
				],
			],
		];
	}

	/**
	 * 保存审计日志。
	 *
	 * @param \yii\base\Action $action
	 *
	 * @return bool
	 *
	 * @throws \yii\web\BadRequestHttpException
	 */
	public function beforeAction($action)
	{
		$res = parent::beforeAction($action);

		AuditLog::saveAuditLog();

		return $res;
	}
}