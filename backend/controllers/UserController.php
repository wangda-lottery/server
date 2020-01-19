<?php

namespace backend\controllers;

use common\models\User;
use Exception;
use yii\data\ActiveDataProvider;
use yii\web\NotAcceptableHttpException;

/**
 * 用户。
 *
 * Class UserController
 * @package backend\controllers
 */
class UserController extends BaseController
{
	public $modelClass = 'common\models\User';

	/**
	 * 重写。自定义index方法，获取用户列表。
	 *
	 * @return array|void
	 */
	public function actions()
	{
		$actions = parent::actions();

		unset($actions['index']);

		return $actions;
	}

	/**
	 * 重写集合方法。分页设置为 20 条。
	 *
	 * @return ActiveDataProvider
	 */
	public function actionIndex()
	{
		$activeData = new ActiveDataProvider([
			'query' => User::find(),
			'pagination' => [
				'pageSize' => 20
			]
		]);

		return $activeData;
	}

	/**
	 * 登录。
	 *
	 * @return false|string
	 *
	 * @throws Exception
	 */
	public function actionLogin()
	{
		$params = \Yii::$app->request->getBodyParams();
		$userName = $params['username'];
		$pwd = $params['password'];

		$user = User::findIdentity($userName);
		if (!$user) {
			throw new NotAcceptableHttpException("用户名或错误密码");
		}

		if (!$user->validatePassword($pwd)) {
			throw new NotAcceptableHttpException("用户名或错误密码");
		}

		// 生成新的访问凭据
		$user->generateAuthKey();

		return $user;
	}

	/**
	 * 退出。
	 */
	public function actionLogout()
	{
	}
}