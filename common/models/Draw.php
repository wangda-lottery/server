<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 抽奖记录 model
 */
class Draw extends ActiveRecord
{
	public function getMemberTopUps()
	{
		return $this->hasMany(MemberTopUp::class, ['accountName' => 'accountName']);
	}
}
