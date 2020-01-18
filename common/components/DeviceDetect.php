<?php

namespace common\components;

use Detection\MobileDetect;

use Yii;
use yii\base\BaseObject;

/**
 * 移动设备检测功能
 * @link http://mobiledetect.net/
 * @link https://www.360us.net/
 *
 * @example
 *
 * //注册一个检测移动设备组件
 * Yii::$app->set('deviceDetect', [
 *     'class' => 'common\service\DeviceDetect',
 * ]);
 *
 * //使用
 * Yii::$app->deviceDetect->isMobile();
 *
 * Class Mobile
 * @package common\service
 */
class DeviceDetect extends BaseObject
{
	//MobileDetect对象
	protected $detector;

	//初始化
	public function init()
	{
		parent::init();

		$this->detector = new MobileDetect();
	}

	public function __call($name, $params)
	{
		return call_user_func_array(
			array($this->detector, $name),
			$params
		);
	}
}