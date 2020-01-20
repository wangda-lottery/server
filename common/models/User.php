<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\filters\RateLimitInterface;
use yii\web\ForbiddenHttpException;
use yii\web\IdentityInterface;
use yii\web\UnauthorizedHttpException;

/**
 * User model
 */
class User extends ActiveRecord implements IdentityInterface, RateLimitInterface
{
	const STATUS_DELETED = -1;
	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE = 1;

	/**
	 * 字段。删除一些包含敏感信息的字段
	 *
	 * @return array|false
	 */
	public function fields()
	{
		$fields = parent::fields();

		unset(
		  $fields['password'],
		  $fields['lastSessionId'],
		  $fields['allowanceUpdatedAt'],
		  $fields['rateLimit'],
		  $fields['allowance']
		);

		return $fields;
	}

	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		return $behaviors;
		/*return [[
			'class' => TimestampBehavior::class,
			'createdAtAttribute' => 'createdAt',
			'updatedAtAttribute' => 'updatedAt',
			'value' => new Expression('NOW()'),
		]];*/
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
		  ['status', 'default', 'value' => self::STATUS_INACTIVE],
		  ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
		];
	}

	/**
	 * 获取允许的请求的最大数目及时间。
	 *
	 * @inheritDoc
	 */
	public function getRateLimit($request, $action)
	{
		return [$this['rateLimit'], 60];
	}

	/**
	 * 返回剩余的允许的请求和最后一次速率限制检查时 相应的 UNIX 时间戳数。
	 *
	 * @inheritDoc
	 */
	public function loadAllowance($request, $action)
	{
		return [$this['allowance'], strtotime($this['allowanceUpdatedAt'])];
	}

	/**
	 * 保存剩余的允许请求数和当前的 UNIX 时间戳。
	 *
	 * @inheritDoc
	 */
	public function saveAllowance($request, $action, $allowance, $timestamp)
	{
		$this['allowance'] = $allowance;
		$this['allowanceUpdatedAt'] = date('Y-m-d H:i:s', $timestamp);
		$this->save();
	}

	/**
	 * {@inheritdoc}
	 */
	public static function findIdentity($id)
	{
		return static::findOne(['username' => $id, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * 重写基于 access token 方法进行用户授权的方法。
	 *
	 * {@inheritdoc}
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		$user = static::findOne(['accessToken' => $token]);
		if (!$user) {
			throw new ForbiddenHttpException('登录已过期，请重新登录');
		}

		return $user;
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 * @return static|null
	 */
	public static function findByUsername($username)
	{
		return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * Finds user by password reset token
	 *
	 * @param string $token password reset token
	 * @return static|null
	 */
	public static function findByPasswordResetToken($token)
	{
		if (!static::isPasswordResetTokenValid($token)) {
			return null;
		}

		return static::findOne([
		  'passwordResetToken' => $token,
		  'status' => self::STATUS_ACTIVE,
		]);
	}

	/**
	 * Finds user by verification email token
	 *
	 * @param string $token verify email token
	 * @return static|null
	 */
	public static function findByVerificationToken($token)
	{
		return static::findOne([
		  'emailVerifyToken' => $token,
		  'status' => self::STATUS_INACTIVE
		]);
	}

	/**
	 * Finds out if password reset token is valid
	 *
	 * @param string $token password reset token
	 * @return bool
	 */
	public static function isPasswordResetTokenValid($token)
	{
		if (empty($token)) {
			return false;
		}

		$timestamp = (int)substr($token, strrpos($token, '_') + 1);
		$expire = Yii::$app->params['user.passwordResetTokenExpire'];
		return $timestamp + $expire >= time();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getId()
	{
		return $this->getPrimaryKey();
	}

	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey()
	{
		$this['accessToken'] = Yii::$app->security->generateRandomString();
		$this->save();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAuthKey()
	{
		return $this['accessToken'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}

	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 * @return bool if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		return Yii::$app->security->validatePassword($password, $this->password);
	}

	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 * @throws \yii\base\Exception
	 */
	public function setPassword($password)
	{
		$this->password = Yii::$app->security->generatePasswordHash($password);
	}

	/**
	 * Generates new password reset token
	 */
	public function generatePasswordResetToken()
	{
		$this->passwordResetToken = Yii::$app->security->generateRandomString() . '_' . time();
	}

	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken()
	{
		$this->passwordResetToken = null;
	}

	/**
	 * Generates new token for email verification
	 */
	public function generateEmailVerificationToken()
	{
		$this->emailVerifyToken = Yii::$app->security->generateRandomString() . '_' . time();
	}
}
