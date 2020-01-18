/**
 * 抽奖相关。
 */
var lotteryTimer;

function isIE() {
	if (!!window.ActiveXObject || "ActiveXObject" in window){
	    return true;
  } else if (/iphone|ipad|ipod|safari/.test(navigator.userAgent.toLowerCase())) {
		return true;
	}

	return false;
}

// 抽奖
function ajaxLottery() {
	$.ajax({
		url: url_lottery,
		dataType: 'json',
		cache: false,
		type: 'GET',
		success: function (obj) {
			switch (obj.stat) {
				case '-404':
					$('.banner').snowfall('clear');
					clearInterval(lotteryTimer);
					setEnd();

					break;

				case '-1':
					// 下一波倒计时
					$('.banner').snowfall('clear');
					clearInterval(lotteryTimer);
					if (isIE()) {
						var c_time = obj.c_time.replace(/-/g, '/');
						var start_time = obj.start_time.replace(/-/g, '/');
					} else {
						var c_time = obj.c_time;
						var start_time = obj.start_time;
					}

					NowTimeOld = new Date(c_time);
					startDateTime = new Date(start_time);
					one = setInterval(getRTimeOne, 1000);

					break;

				case '0':
					// 抽奖动画
					if (isIE()) {
						var c_time = obj.c_time.replace(/-/g, '/');
						var end_time = obj.end_time.replace(/-/g, '/');
					} else {
						var c_time = obj.c_time;
						var end_time = obj.end_time;
					}

					NowTimeOld = new Date(c_time);
					waveTime = new Date(end_time);
					two = setInterval(getRTimeTwo, 1000);

					$('.banner').snowfall('clear');
					$('.banner').snowfall({
						image: "images/hongbao.png",
						flakeCount: 25,
						minSize: 30,
						maxSize: 80
					});

					$('.snowfall-flakes').on('click', function () {
						showGetWin();
					});

					console.log(obj);

					break;

				default:
					break;
			}
		},
		error: function (XMLHttpRequest, textStatus, errorThrown) {
			var x = 1;
		}
	});
}

// 显示查询窗口
function showQueryWin() {
	$('#querywin').fadeIn();
}

// 关闭查询窗口
function closeQueryWin() {
	$('#querywin').fadeOut();
}

// 查询抽奖记录
function query() {
	var username = $.trim($('#username-query').val());
	if (username === '') {
		alert('请输入会员名');
		return false;
	}

	$.ajax({
		url: url_query,
		dataType: 'html',
		data: {userName: username},
		cache: false,
		type: 'GET',
		success: function (html) {
			$('#query-result').html(html);
		},
		error: function (XMLHttpRequest, textStatus, errorThrown) {
			alert('系统忙，请稍后再试！');
		}
	});
}

// 显示领取窗口
function showGetWin() {
	if ($.trim($('#username').val()) !== '') {
		var username = $.trim($('#username').val());
		if (username === '') {
			alert('请输入会员名');
			return;
		}

		$.ajax({
			url: url_checkuser,
			dataType: 'json',
			data: {userName: username},
			cache: false,
			type: 'GET',
			success: function (obj) {
				if (obj.stat === true) {
					$("#hongbao_open").show();
					$("#hongbao_back").show();
				} else {
					alert(obj.msg);
				}
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				alert('系统忙，请稍后再试！');
			}
		});
	} else {
		$('#getWin').fadeIn();
	}
}

// 关闭领取窗口
function closeGetWin() {
	$('#getWin').fadeOut();
	var username = $.trim($('#username').val());
	if (username === '') {
		alert('请输入会员名');
		return false;
	} else {
		showGetWin();
	}
}

// 拆红包
function getPacket() {
	var username = $.trim($('#username').val());
	if (username === '') {
		alert('请输入会员名');
		return false;
	}

	$.ajax({
		url: url_getPacket,
		dataType: 'json',
		data: {userName: username},
		cache: false,
		type: 'GET',
		success: function (obj) {
			if (obj.stat === 1) {
				$("#hongbao_result").show();
				$("#hongbao_open").hide();
				$("#resultamount").html(obj.amount);
			} else if (obj.stat === 0) {
				alert(obj.msg);
			} else {
				alert('系统忙，请稍后再试！');
			}
		},
		error: function (XMLHttpRequest, textStatus, errorThrown) {
			alert('系统忙，请稍后再试！');
		}
	});
}

// 中奖轮播
function loadAnnounce(callback) {
	// callback();
	$('#announce').load(url_announce, '', function () {
			callback();
	});
}