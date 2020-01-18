<?php

namespace frontend\controllers;

use common\models\MemberTopUp;
use yii\web\Controller;

/**
 * 用户控制器。
 *
 * Class UserController
 * @package frontend\controllers
 */
class UserController extends Controller
{
	/**
	 * 用户是否存在.
	 *
	 * @param $userName
	 *
	 * @return mixed
	 */
	public function actionExist($userName)
	{
		$user = MemberTopUp::findOne(['accountName' => $userName]);

		return json_encode([
			'stat' => $user ? true : false,
			'msg' => $user ? '会员存在' : '无效会员名',
		]);
	}
}