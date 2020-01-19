<?php

namespace backend\controllers;

use common\models\AuditLog;
use common\models\DataProvider;
use common\models\MemberTopUp;

/**
 * 计划任务。
 *
 * Class ScheduleController
 * @package backend\controllers
 */
class ScheduleController extends BaseController
{
	public $modelClass = 'common\models\Schedule';

	/**
	 * 保持与保网的会话有效。
	 *
	 * @return array
	 */
	public function actionKeep() {
		try {
			$yesterday = time() - 24 * 60 * 60;
			$startTime = date('Y-m-d 00:00:00', $yesterday);
			$endTime = date('Y-m-d 23:59:59', $yesterday);

			DataProvider::keepAlive($startTime, $endTime);

			return [
				'keep_alive'=> 'success'
			];
		} catch (\Exception $e) {
			if ($this->auditLogId) {
				AuditLog::updateAll([
					'response' => $e->getMessage()
				], [
					'id' => $this->auditLogId
				]);
			}

			return [
				'keep_alive'=> 'failed',
				'message' => $e->getMessage()
			];
		}
	}

	/**
	 * 导出数据。
	 *
	 * @return array
	 */
	public function actionExport() {
		try {
			DataProvider::exportLottery();

			return [
				'export_lottery'=> 'success'
			];
		} catch (\Exception $e) {
			if ($this->auditLogId) {
				AuditLog::updateAll([
					'response' => $e->getMessage()
				], [
					'id' => $this->auditLogId
				]);
			}

			return [
				'export_lottery'=> 'failed',
				'message' => $e->getMessage()
			];
		}
	}
}