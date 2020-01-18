<?php

namespace backend\controllers;

use common\models\DataProvider;

/**
 *  抽奖。
 *
 * Class ScheduleController
 * @package backend\controllers
 */
class DrawController extends BaseController
{
	public $modelClass = 'common\models\Draw';

	/**
	 * 派送抽奖结果至会员账户。
	 */
	public function actionExport()
	{
		DataProvider::exportLottery();
	}
}