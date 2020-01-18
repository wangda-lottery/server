<?php

namespace backend\controllers;

use common\models\Param;
use Yii;

/**
 * 参数。
 *
 * Class ParamController
 * @package backend\controllers
 */
class ParamController extends BaseController
{
	public $modelClass = 'common\models\Param';

	public function actions()
	{
		$actions = parent::actions();

		unset($actions['update']);

		return $actions;
	}

	public function actionUpdate($id)
	{
		$payload = Yii::$app->request->bodyParams;

		$param = Param::findOne($id);
		if ($param !== null) {
			$param['value'] = $payload['value'];
			$param->save();
		}

		return $param;
	}
}