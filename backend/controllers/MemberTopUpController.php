<?php

namespace backend\controllers;

use common\models\AuditLog;
use common\models\DataProvider;
use common\models\MemberTopUp;

/**
 * 会员充值记录。
 *
 * Class MemberTopUpController
 * @package backend\controllers
 */
class MemberTopUpController extends BaseController
{
	public $modelClass = 'common\models\MemberTopUp';

	/**
	 * 导入会员数据。
	 */
	public function actionImport()
	{
		try {
			$yesterday = time() - 24 * 60 * 60;
			$startTime = date('Y-m-d 00:00:00', $yesterday);
			$endTime = date('Y-m-d 23:59:59', $yesterday);

			// 先清旧数据
			MemberTopUp::deleteAll(['BETWEEN', 'topUpAt', $startTime, $endTime]);

			// 导入
			DataProvider::importMemberTopUpData($startTime, $endTime);
		} catch (\Exception $e) {
			if ($this->auditLogId) {
				AuditLog::updateAll([
					'response' => $e->getMessage()
				], [
					'id' => $this->auditLogId
				]);
			}

			throw $e;
		}
	}
}