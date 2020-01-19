<?php

namespace common\models;

use moonland\phpexcel\Excel;
use yii\base\Model;
use yii\httpclient\Client;
use yii\web\ServerErrorHttpException;

/**
 * 数据提供者 model
 */
class DataProvider extends Model
{
	/**
	 * 导入会员历史充值数据。
	 *
	 * @param $startTime
	 * @param $endTime
	 * @param int $page
	 *
	 * @throws ServerErrorHttpException
	 * @throws \yii\base\InvalidConfigException
	 * @throws \yii\db\Exception
	 */
	public static function importMemberTopUpData($startTime, $endTime, $page = 1)
	{
		$queryUrl = Param::getParam('3rdTradeQueryUrl');
		$tradeTypes = Param::getParam('3rdTradeType');
		$cookies = Param::get3rdCookie();

		$options = [
			'timeout' => 10,
			'followLocation' => true,
			'sslVerifyPeer' => false,
			'userAgent' => Param::getParam('3rdUserAgent'),
		];
		$header = [
			'sec-fetch-mode' => 'cors',
			'sec-fetch-site' => 'same-origin',
			'Origin' => 'https://d335rs9dgtfmqrb.abackfirst.com',
			'Referer' => 'https://d335rs9dgtfmqrb.abackfirst.com/transaction/billQuery',
		];
		$payload = [
			'startTime' => $startTime,
			'endTime' => $endTime,
			'tradeTypeList' => $tradeTypes,
			'accountNameSearchType' => 'simple',
			'bettingCode' => null,
			'pageNo' => $page,
			'pageSize' => 500,
			'sortType' => 'desc',
			'accountName' => null,
			'page' => 1
		];

		$httpClient = new Client();
		$response = $httpClient->createRequest()
			->setUrl($queryUrl)
			->setMethod('POST')
			->setFormat(Client::FORMAT_JSON)
			->setCookies($cookies)
			->setHeaders($header)
			->setOptions($options)
			->setData($payload)
			->send();

		if ($response->isOk) {
			$data = $response->getData();
			$code = $data['code'];
			if ("fail" === $code) {
				$errorData = $data['data'];
				throw new ServerErrorHttpException("导入失败。包网平台接口返回：" . $errorData['TCmsg']);
			}

			$rows = [];

			$result = $data['data']['result'];
			$records = $result['records'];
			foreach ($records as $record) {
				$amount = floatval($record['tradeLimit']) * 100;
				if ($amount <= 0) continue;

				array_push($rows, [
					'memId' => $record['accountId'],
					'accountName' => $record['accountName'],
					'accountLevel' => $record['accountLevel'],
					'amount' => $amount,
					'topUpAt' => $record['createDate'],
					'tradeType' => $record['tradeType'],
					'tradeTypeName' => $record['tradeTypeName'],
					'bettingCode' => $record['bettingCode'],
					'remark' => $record['remark'],
				]);
			}

			$columns = [
				'memId',
				'accountName',
				'accountLevel',
				'amount',
				'topUpAt',
				'tradeType',
				'tradeTypeName',
				'bettingCode',
				'remark',
			];
			\Yii::$app->db->createCommand()
				->batchInsert(MemberTopUp::tableName(), $columns, $rows)
				->execute();

			if ($result['nextPageNo'] > $page) {
				$nextPage = $result['nextPageNo'];
				static::importMemberTopUpData($startTime, $endTime, $nextPage);
			}
		} else {
			throw new ServerErrorHttpException("会员充值数据查询失败");
		}
	}

	/**
	 * 派送抽奖结果至会员账户。
	 */
	public static function exportLottery()
	{
		$draws = Draw::find()
			->where(['exported' => 0])
			->limit(999)
			->all();
		if (count($draws) === 0) throw new ServerErrorHttpException("暂无可导数据");

		// 导出数据至本地
		$savePath = './excel';
		$fileName = 'sample_' . date('Y-m-d_H:i:s');
		$fullName = static::joinPaths($savePath, $fileName . '.xlsx');

		Excel::export([
			'savePath' => $savePath,
			'fileName' => $fileName,
			'format' => 'Xlsx',
			'mode' => 'export', //default value as 'export'

			'models' => $draws,
			'columns' => [
				'accountName',
				[
					'attribute' => 'amount',
					'value' => function ($model) {
						return number_format(($model['amount'] + 1) / 100, 2, '.', '');
					}
				],
				[
					'attribute' => 'f1',
					'value' => function ($model) {
						return number_format(($model['amount'] + 1) / 100, 2, '.', '');
					}
				],
				[
					'attribute' => 'f2',
					'value' => function ($model) {
						return '红包抽奖';
					}
				],
			],
			'headers' => [
				'accountName' => '账号',
				'amount' => '存入金额',
				'f1' => '综合打码量稽核',
				'f2' => '存入金额备注',
			]
		]);

		// 调用上传接口
		$uploadUrl = Param::getParam('3rdDataUploadUrl');
		$cookies = Param::get3rdCookie();

		$options = [
			'timeout' => 10,
			'followLocation' => true,
			'sslVerifyPeer' => false,
			'userAgent' => Param::getParam('3rdUserAgent'),
		];
		$header = [
			'sec-fetch-mode' => 'cors',
			'sec-fetch-site' => 'same-origin',
			'Origin' => 'https://d335rs9dgtfmqrb.abackfirst.com',
			'Referer' => 'https://d335rs9dgtfmqrb.abackfirst.com/transaction/billQuery',
		];
		$payload = [
			'depositType' => 6,
			'accountType' => 1,
		];

		$httpClient = new Client();
		$response = $httpClient->createRequest()
			->setUrl($uploadUrl)
			->setMethod('POST')
			->setFormat(Client::FORMAT_JSON)
			->setCookies($cookies)
			->setHeaders($header)
			->setOptions($options)
			->addFile('files', $fullName)
			->setData($payload)
			->send();

		// 更新导出状态
		if ($response->isOk) {
			$data = $response->getData();
			$code = $data['code'];
			if (in_array($code, ["error", "fail"])) {
				throw new ServerErrorHttpException("红包派送失败。包网平台接口返回：" . $data['msg']);
			} else {
				Draw::updateAll([
					'exported' => 1
				], [
					'exported' => 0
				]);
			}
		} else {
			throw new ServerErrorHttpException("抽奖数据上传失败");
		}
	}

	/**
	 * 保持与包网平台的 cookie 活跃。
	 *
	 * @param $startTime
	 * @param $endTime
	 *
	 * @return
	 *
	 * @throws ServerErrorHttpException
	 * @throws \yii\base\InvalidConfigException
	 * @throws \yii\db\Exception
	 */
	public static function keepAlive($startTime, $endTime)
	{
		$queryUrl = Param::getParam('3rdTradeQueryUrl');
		$tradeTypes = Param::getParam('3rdTradeType');
		$cookies = Param::get3rdCookie();

		$options = [
			'timeout' => 10,
			'followLocation' => true,
			'sslVerifyPeer' => false,
			'userAgent' => Param::getParam('3rdUserAgent'),
		];
		$header = [
			'sec-fetch-mode' => 'cors',
			'sec-fetch-site' => 'same-origin',
			'Origin' => 'https://d335rs9dgtfmqrb.abackfirst.com',
			'Referer' => 'https://d335rs9dgtfmqrb.abackfirst.com/transaction/billQuery',
		];
		$payload = [
			'startTime' => $startTime,
			'endTime' => $endTime,
			'tradeTypeList' => $tradeTypes,
			'accountNameSearchType' => 'simple',
			'bettingCode' => null,
			'pageNo' => 1,
			'pageSize' => 10,
			'sortType' => 'desc',
			'accountName' => null,
			'page' => 1
		];

		$httpClient = new Client();
		$response = $httpClient->createRequest()
			->setUrl($queryUrl)
			->setMethod('POST')
			->setFormat(Client::FORMAT_JSON)
			->setCookies($cookies)
			->setHeaders($header)
			->setOptions($options)
			->setData($payload)
			->send();

		if ($response->isOk) {
			$data = $response->getData();
			$code = $data['code'];
			if (in_array($code, ["error", "fail"])) {
				throw new ServerErrorHttpException("Keep alive 检测失败。包网平台接口返回：" . $data['data']['TCmsg']);
			}

			return true;
		} else {
			throw new ServerErrorHttpException("Keep alive 检测失败");
		}
	}

	private static function joinPaths() {
		$args = func_get_args();
		$paths = array();
		foreach ($args as $arg) {
			$paths = array_merge($paths, (array)$arg);
		}

		$paths = array_map(function($p){
			return trim($p, "/");
		}, $paths);

		$paths = array_filter($paths);
		return join('/', $paths);
	}
}
