<?php

namespace frontend\controllers;

use common\models\Draw;
use common\models\MemberTopUp;
use common\models\Param;
use Yii;
use yii\web\Controller;

/**
 * 抽奖控制器。
 *
 * Class LotteryController
 * @package frontend\controllers
 */
class LotteryController extends Controller
{
	/**
	 * 抽奖计划.
	 *
	 * @return mixed
	 */
	public function actionSchedule()
	{
		$payload = [
			'c_time' => date('Y-m-d H:i:s'),
		];

		$hour = date('H');

		$schedule = Param::findOne(['name' => 'schedule']);
		$hours = explode(',', $schedule['value']);
		$start = intval($hours[0]);
		$end = intval($hours[1]);

		if ($start <= $hour && $hour <= $end) {
			$payload['stat'] = '0';
			$payload['end_time'] = date('Y-m-d 23:59:59');
		} else {
			$payload['stat'] = '-1';
			$payload['start_time'] = date("Y-m-d {$start}:00:00");
		}

		return json_encode($payload);
	}

	/**
	 * 拆红包.
	 *
	 * @param $userName
	 *
	 * @return mixed
	 */
	public function actionOpen($userName)
	{
		$payload = [];

		$yesterday = time() - 24 * 3600;
		$start = date('Y-m-d 00:00:00', $yesterday);
		$end = date('Y-m-d 23:59:59', $yesterday);
		$topUpAmount = MemberTopUp::find()
			->where(['accountName' => $userName])
			->andWhere(['between', 'topUpAt', $start, $end])
			->sum('amount');

		$topUpAmount = intval($topUpAmount);
		if ($topUpAmount === null) {
			return json_encode([
				'stat' => 0,
				'msg' => '您当前还未获取到抽奖资格，请继续努力！',
			]);
		}

		$drawTimes = Draw::find()
			->where(['accountName' => $userName])
			->andWhere(['between', 'createdAt', date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
			->count('id');
		$drawTimes = intval($drawTimes);

		$canDraw = false;
		if ($topUpAmount >= 10000000) {
			if ($drawTimes < 5) $canDraw = true;
		} else if ($topUpAmount >= 2000000) {
			if ($drawTimes < 4) $canDraw = true;
		} else if ($topUpAmount >= 500000) {
			if ($drawTimes < 3) $canDraw = true;
		} else if ($topUpAmount >= 50000) {
			if ($drawTimes < 2) $canDraw = true;
		} else if ($topUpAmount >= 10000) {
			if ($drawTimes < 1) $canDraw = true;
		}

		if ($canDraw) {
			$ranges = explode(',', Param::getParam('lotteryRange'));
			$ranges[0] = intval($ranges[0]);
			$ranges[1] = intval($ranges[1]);

			$draw = new Draw();
			$draw['accountName'] = $userName;
			$draw['amount'] = rand($ranges[0], $ranges[1]);
			$draw['exported'] = 0;
			$draw['ip'] = Yii::$app->request->userIP;
			$draw['ua'] = Yii::$app->request->userAgent;
			$draw->save();

			$payload['stat'] = 1;
			$payload['amount'] = $draw['amount'] / 100;
		} else {
			$payload['stat'] = 0;
			$payload['msg'] = '您今日抽奖次数已经用完';
		}

		return json_encode($payload);
	}

	/**
	 * 红包查询.
	 *
	 * @param $userName
	 *
	 * @return mixed
	 */
	public function actionQuery($userName)
	{
		$draws = Draw::find()->where(['accountName' => $userName])
			->orderBy(['id' => SORT_DESC])
			->all();

		$payload = "";
		foreach ($draws as $draw) {
			$amount = $draw['amount'] / 100;
			$drawTime = $draw['createdAt'];
			$exported = $draw['exported'] ? '是' : '否';
			$payload .= "<tr><td>{$amount}</td><td>{$drawTime}</td><td>{$exported}</td></tr>";
		}

		return $payload;
	}

	/**
	 * 中奖列表。
	 */
	public function actionAnnounce() {
		$payload = "
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>74*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">1.57</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>a1*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">5.77</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>fd*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">5.87</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>74*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">7.53</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>97*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">5.68</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>yg*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">7.20</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>49*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">1.17</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>mn*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">13.96</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>yg*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">5.28</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>mn*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">7.08</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>ab*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">1.84</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>wx*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">1.73</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>yg*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">9.70</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>49*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">6.42</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>mn*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">1.39</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>fd*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">5.02</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>76*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">1.17</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>74*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">1.57</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>a1*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">5.77</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>fd*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">5.87</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>74*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">7.53</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>97*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">5.68</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>yg*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">7.20</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>49*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">1.17</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>mn*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">13.96</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>yg*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">5.28</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>mn*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">7.08</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>ab*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">1.84</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>wx*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">1.73</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>yg*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">9.70</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>49*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">6.42</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>mn*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">1.39</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>fd*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">5.02</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>

		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>76*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">1.17</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>74*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">1.57</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>a1*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">5.77</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>fd*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">5.87</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>74*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">7.53</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>97*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">5.68</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>yg*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">7.20</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>49*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">1.17</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>mn*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">13.96</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>yg*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">5.28</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>mn*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">7.08</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>ab*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">1.84</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>wx*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">1.73</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>yg*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">9.70</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>49*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">6.42</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>mn*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">1.39</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>fd*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">5.02</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>
		<li>
				<span class=\"w120 huang pl20\"><em class=\"cw\">恭喜 </em>76*** </span>
				<span class=\"w190 cw\">  获得 <em class=\"huang\">1.17</em> 元红包大奖       </span>
				<span class=\"w120 cw\">DATE_PLACE_HOLDER</span>
		</li>";

		$payload = str_replace("DATE_PLACE_HOLDER", date("Y-m-d", time() - 24 * 3600), $payload);
		return $payload;
	}
}