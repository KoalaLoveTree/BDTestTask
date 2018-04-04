<?php

namespace common\models;

use backend\models\Admin;
use common\interfaces\StatusInterface;
use frontend\models\Client;
use frontend\models\DefaultUser;
use Yii;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $role
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends ActiveRecord implements IdentityInterface, StatusInterface
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_APPROVE],
            ['status', 'in', 'range' => [self::STATUS_APPROVE, self::STATUS_DELETED, self::STATUS_MODERATION]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::find()->andWhere(['id' => $id])->andWhere(['<>', 'status', self::STATUS_DELETED])->one();
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return User|array|null
     */
    public static function findByEmail(string $email): ?User
    {
        return static::find()->andWhere(['email' => $email])->andWhere(['<>', 'status', self::STATUS_DELETED])->one();
    }

    /**
     * Finds user by email
     *
     * @param int $id
     * @return array|null|Vendor
     */
    public static function findById(int $id): ?Vendor
    {
        return static::find()->andWhere(['id' => $id])->andWhere(['<>', 'status', self::STATUS_DELETED])->one();
    }

    /**
     * @return bool
     */
    public static function isClient(): bool
    {
        $client = new Client();
        if ($client->find()->where(['id' => Yii::$app->user->getId()])->one() !== null) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public static function isAdmin():bool{
        $admin = new Admin();
        if ($admin->find()->where(['id' => Yii::$app->user->getId()])->one() !== null) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public static function isDefaultUser(): bool
    {
        $user = new DefaultUser();
        if ($user->find()->where(['id' => Yii::$app->user->getId()])->one() !== null) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public static function isVendor(): bool
    {
        $vendor = new Vendor();
        if ($vendor->find()->where(['id' => Yii::$app->user->getId()])->one() !== null) {
            return true;
        }

        return false;
    }

    /**
     * @param int $id
     * @return string
     */
    protected static function findCurrentUserRole(int $id): string
    {
        return static::findOne(['id' => $id])->role;
    }

    /**
     * @param int $id
     * @return int
     */
    protected static function findCurrentUserStatus(int $id): int
    {
        return static::findOne(['id' => $id])->status;
    }

    /**
     * @return int
     */
    public static function userStatus(): int
    {
        if (Yii::$app->user->isGuest) {
            return 'guest';
        } else {

            return self::findCurrentUserStatus(Yii::$app->user->getId());
        }
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
            'password_reset_token' => $token,
            'status' => self::STATUS_APPROVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token): bool
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
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
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
    public function validatePassword($password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * @throws Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     * @throws Exception
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
