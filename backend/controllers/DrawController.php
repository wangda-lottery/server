<?php

namespace backend\controllers;

use common\models\AuditLog;
use common\models\DataProvider;
use common\models\Draw;
use common\models\MemberTopUp;
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

		unset($actions['index'], $actions['update']);

		return $actions;
	}

	/**
	 * 操作。
	 */
	public function actionIndex() {
		$request = \Yii::$app->request;
		$accountName = $request->getQueryParam('accountName');
		$exported = $request->getQueryParam('exported');
		$page = $request->getQueryParam('page');
		$perPage = $request->getQueryParam('per-page');
		$queryTimeStart = $request->getQueryParam('queryTimeStart');
		$queryTimeEnd = $request->getQueryParam('queryTimeEnd');

		$query = Draw::find();
		if ($accountName) {
			$query = $query->where(['accountName' => $accountName]);
		}

		if (in_array($exported, ['0', '1'])) {
			$query = $query->andWhere(['exported' => $exported]);
		}

		if ($queryTimeStart && $queryTimeEnd) {
			$query = $query->andWhere([
				'between', 'createdAt', $queryTimeStart, $queryTimeEnd
			]);
		}

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'page' => $page - 1,
				'pageSize' => $perPage,
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
	 * 手动派送抽奖结果。仅标记内部状态。
	 *
	 * @param $id
	 * @throws \Exception
	 */
	public function actionUpdate($id)
	{
		try {
			Draw::updateAll([
				'exported' => 1
			], [
				'id' => $id
			]);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	/**
	 *  自动派送抽奖结果至会员账户。
	 */
	public function actionExport()
	{
		try {
			DataProvider::exportLotteryByApi();
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