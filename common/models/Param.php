<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 *  参数 model
 */
class Param extends ActiveRecord
{
	/**
	 * 获取第三方cookie.
	 */
	public static function get3rdCookie()
	{
		$cookies = [];

		$cookieStr = static::getParam('3rdCookie');
		$cookieValues = explode(';', $cookieStr);
		foreach ($cookieValues as $item) {
			$tokens = explode("=", $item);
			array_push($cookies, [
				'name' => $tokens[0],
				'value' => $tokens[1]
			]);
		}

		return $cookies;
	}

	/**
	 * 获取参数。
	 *
	 * @param $name
	 * @return mixed
	 */
	public static function getParam($name)
	{
		$param = Param::find()->where(['name' => $name])->one();
		return $param['value'];
	}
}
