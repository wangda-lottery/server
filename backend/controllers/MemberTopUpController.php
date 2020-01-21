<?php

namespace backend\controllers;

use common\models\AuditLog;
use common\models\DataProvider;
use common\models\MemberTopUp;
use yii\data\ActiveDataProvider;

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
	 * 覆盖.
	 *
	 * @return array
	 */
	public function actions()
	{
		$actions = parent::actions();

		unset($actions['index']);

		return $actions;
	}

	/**
	 * 数据查询。
	 */
	public function actionIndex() {
		$request = \Yii::$app->request;
		$accountName = $request->getQueryParam('accountName');
		$page = $request->getQueryParam('page');
		$perPage = $request->getQueryParam('per-page');
		$queryTimeStart = $request->getQueryParam('queryTimeStart');
		$queryTimeEnd = $request->getQueryParam('queryTimeEnd');

		$query = MemberTopUp::find();
		if ($accountName) {
			$query = $query->where(['accountName' => $accountName]);
		}

		if ($queryTimeStart && $queryTimeEnd) {
			$query = $query->andWhere([
				'between', 'topUpAt', $queryTimeStart, $queryTimeEnd
			]);
		}

		return new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'page' => $page - 1,
				'pageSize' => $perPage,
			],
			'sort' => [
				'defaultOrder' => [
					'id' => SORT_DESC
				],
			]
		]);
	}

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