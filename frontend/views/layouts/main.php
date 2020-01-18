<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="webkit" name="renderer">

	<?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>

    <script src="https://cdn.bootcss.com/jquery/1.11.1/jquery.js"></script>
	<?php if ($this->params['isMobile']): ?>
      <meta name="viewport" content="width=640,maximum-scale=4,user-scalable=no">

      <link rel="stylesheet" rev="stylesheet" href="./css/mobile/reset.css" type="text/css"/>
      <link rel="stylesheet" rev="stylesheet" href="./css/mobile/global.css" type="text/css"/>
      <link rel="stylesheet" rev="stylesheet" href="./css/mobile/index.css" type="text/css"/>
	<?php else: ?>
      <!--meta name="viewport" content="width=device-width,user-scalable=no"-->
      <meta name="viewport" content="width=640,maximum-scale=4,user-scalable=no">

      <link rel="stylesheet" rev="stylesheet" href="./css/pc/reset.css" type="text/css"/>
      <link rel="stylesheet" rev="stylesheet" href="./css/pc/global.css" type="text/css"/>
      <link rel="stylesheet" rev="stylesheet" href="./css/pc/index.css" type="text/css"/>
	<?php endif; ?>
</head>

<body>
<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>
</body>

<script type="text/javascript">
	var url_checkuser = '/user/exist';
	var url_lottery = '/lottery/schedule';
	var url_getPacket = '/lottery/open';
	var url_query = '/lottery/query';
	var url_announce = '/lottery/announce';

	function close_hongbao(a) {
		$(a).parents('.flip').hide();
		$("#hongbao_back").hide();
	}

	var NowTimeOld = null;
	var startDateTime = null;
	var endDateTime = null;
	var one, two, NowTime, waveTime;

	function getRTimeOne() {
		var t_s = NowTimeOld.getTime();
		var NowTime = NowTimeOld.setTime(t_s + 1000);
		var t = startDateTime - NowTime;
		if (t < 0) {
			clearInterval(one);
			ajaxLottery();
			return;
		}

		var d = Math.floor(t / 1000 / 60 / 60 / 24);
		var h = Math.floor(t / 1000 / 60 / 60 % 24);
		var m = Math.floor(t / 1000 / 60 % 60);
		var s = Math.floor(t / 1000 % 60);
		//var h = d * 24 + h;
		$("#hb-message").html("距离红包雨开始");
		$('#hb-clock-d').html(d);
		$('#hb-clock-h').html(h);
		$('#hb-clock-m').html(m);
		$('#hb-clock-s').html(s);
	}

	function getRTimeTwo() {
		//$('#ipt_div').show();
		var t_s = NowTimeOld.getTime();
		var NowTime = NowTimeOld.setTime(t_s + 1000);
		var t = waveTime - NowTime;
		if (t <= 0) {
			clearInterval(two);
			ajaxLottery();
			return;
		}
		var d = Math.floor(t / 1000 / 60 / 60 / 24);
		var h = Math.floor(t / 1000 / 60 / 60 % 24);
		var m = Math.floor(t / 1000 / 60 % 60);
		var s = Math.floor(t / 1000 % 60);
		//var h = d * 24 + h;
		$("#hb-message").html("本期抽奖中...");
		$('#hb-clock-d').html(d);
		$('#hb-clock-h').html(h);
		$('#hb-clock-m').html(m);
		$('#hb-clock-s').html(s);
		//	html = '';
		//	html += '<span class="sjaimmt">'+h+'</span> 时'+'<span class="sjaimmt">'+m+'</span> 分'+'<span class="sjaimmt">'+s+"</span> 秒";
		//	$("#hb-clock").html(html);
	}

	function setEnd() {
		$("#hb-message").html("活动已结束");
		$("#hb-clock").html('');
	}

	ajaxLottery();

	loadAnnounce(function () {
		lunTopFn('.luntop2', 50);
	});
</script>

</html>
<?php $this->endPage() ?>
