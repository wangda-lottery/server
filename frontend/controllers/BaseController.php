<?php

namespace frontend\controllers;

use yii\web\Controller;

/**
 * REST 控制器基类。
 *
 * Class BaseController
 * @package frontend\controllers
 */
class BaseController extends Controller
{
	public function behaviors()
	{
		return [
			[
				'class' => \yii\filters\ContentNegotiator::className(),
				'formats' => [
					'application/json' => \yii\web\Response::FORMAT_JSON,
				],
			],
		];
	}
}