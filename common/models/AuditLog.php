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
		$url = \Yii::$app->request->url;

		AuditLog::
	}
}
