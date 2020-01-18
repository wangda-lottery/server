<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';

	public $css = [
		// 'css/global.css',
		// 'css/index.css',
		// 'css/pc/reset.css',
	];

	public $js = [
		'js/demo.js',
		'js/index.js',
		'js/lottery.js',
		'js/snowfall.jquery.js',
	];

	public $depends = [
		'yii\web\YiiAsset',
		// 'yii\bootstrap\BootstrapAsset',
	];
}
