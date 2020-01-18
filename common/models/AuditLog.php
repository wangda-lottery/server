<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 审计日志 model
 */
class AuditLog extends ActiveRecord
{
	/**
	 * 保存审计日志。
	 */
	public static function saveAuditLog()
	{
		$request = \Yii::$app->request;
		$controller = \Yii::$app->controller;

		if (!$request->isPost) return;

		$log = new AuditLog();
		$log['id'] = ObjectId::make();
		$log['module'] = $controller->module->id;
		$log['controller'] = $controller->id;
		$log['action'] = $controller->action->id;
		$log['ip'] = $request->userIP;
		$log['params'] = json_encode($request->bodyParams, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		$log['ua'] = $request->userAgent;
		$log->save();

		return $log['id'];
	}
}
