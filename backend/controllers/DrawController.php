<?php

namespace backend\controllers;

use common\models\AuditLog;
use common\models\DataProvider;
use common\models\Draw;
use yii\data\ActiveDataProvider;

/**
 *  抽奖。
 *
 * Class ScheduleController
 * @package backend\controllers
 */
class DrawController extends BaseController
{
	public $modelClass = 'common\models\Draw';

	public function actions()
	{
		$actions = parent::actions();

		unset($actions['index']);

		return $actions;
	}

	/**
	 * 操作。
	 */
	public function actionIndex() {
		$exported = \Yii::$app->request->getQueryParam('exported');
		$pageSize = \Yii::$app->request->getQueryParam('per-page');

		$filter = [];
		if (in_array($exported, ['0', '1'])) {
			$filter['exported'] = $exported;
		}

		$dataProvider = new ActiveDataProvider([
			'query' => Draw::find()->where($filter),
			'pagination' => [
				'pageSize' => $pageSize,
			],
			'sort' => [
				'defaultOrder' => [
					'id' => SORT_DESC,
				]
			],
		]);

		return $dataProvider;
	}

	/**
	 * 派送抽奖结果至会员账户。
	 */
	public function actionExport()
	{
		try {
			DataProvider::exportLottery();
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