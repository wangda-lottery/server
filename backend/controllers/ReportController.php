<?php

namespace backend\controllers;

use common\models\Draw;
use common\models\MemberTopUp;

/**
 * 报表。
 *
 * Class ReportController
 * @package backend\controllers
 */
class ReportController extends BaseController
{
	public $modelClass = 'common\models\Report';

	/**
	 * 重写，仅保留 index 方法。
	 * @return array
	 */
	public function actions()
	{
		$actions = parent::actions();

		unset($actions['index']);

		return $actions;
	}

	/**
	 * 报表首页。
	 *
	 * @return array
	 */
	public function actionIndex() {
		$yesterday = time() -  24 * 60 * 60;

		// 昨日充值
		$totalTopUpCountYesterday = MemberTopUp::find()
			->where(['between', 'topUpAt', date('Y-m-d 00:00:00', $yesterday), date('Y-m-d 23:59:59', $yesterday)])
			->count();

		// 今日抽奖人次数
		$drawCountToday = Draw::find()
			->where(['between', 'createdAt', date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
			->count();

		// 今日发放红包
		$drawExportedAmountToday = Draw::find()
			->where(['between', 'createdAt', date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
			->andWhere(['exported' => 1])
			->sum('amount');

		// 累计发放红包
		$drawExportedAmountTotal = Draw::find()
			->where(['exported' => 1])
			->sum('amount');

		return [
			'totalTopUpCountYesterday' => intval($totalTopUpCountYesterday),
			'drawCountToday' => intval($drawCountToday),
			'drawExportedAmountToday' => intval($drawExportedAmountToday),
			'drawExportedAmountTotal' => intval($drawExportedAmountTotal),
		];
	}
}