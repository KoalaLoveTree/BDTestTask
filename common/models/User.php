<?php

namespace common\models;

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
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_MODERATED = 5;
    const STATUS_ACTIVE = 10;


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
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_MODERATED]],
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
     * @return array|null|ActiveRecord
     */
    public static function findByEmail(string $email)
    {
        return static::find()->andWhere(['email' => $email])->andWhere(['<>', 'status', self::STATUS_DELETED])->one();
    }

    /**
     * Finds user by email
     *
     * @param int $id
     * @return array|null|Vendor
     */
    public static function findById(int $id)
    {
        return static::find()->andWhere(['id' => $id])->andWhere(['<>', 'status', self::STATUS_DELETED])->one();
    }

    public static function isClient()
    {
        $client = new Client();
        if ($client->find()->where(['id' => Yii::$app->user->getId()])->one() !== null) {
//        if ($client->role === Client::ROLE){
            return true;
        }
        return false;
    }

    public static function isDefaultUser()
    {
        $user = new DefaultUser();
        if ($user->find()->where(['id' => Yii::$app->user->getId()])->one() !== null) {
//        if ($user->role === DefaultUser::ROLE){
            return true;
        }
        return false;
    }

    public static function isVendor()
    {
        $vendor = new Vendor();
        if ($vendor->find()->where(['id' => Yii::$app->user->getId()])->one() !== null) {
//        if ($vendor->role === Vendor::ROLE){
            return true;
        }
        return false;
    }

    /**
     * @param int $id
     * @return string
     */
    protected static function findCurrentUserRole(int $id)
    {
        return static::findOne(['id' => $id])->role;
    }

    protected static function findCurrentUserStatus(int $id)
    {
        return static::findOne(['id' => $id])->status;
    }

    public static function updateUserRoleClient(string $city, string $state): bool
    {
        $user = static::findOne(['id' => Yii::$app->user->getId()]);
        $user->role = Client::ROLE;
        if ($user->update() !== false) {
            $client = Client::findOne(['id' => Yii::$app->user->getId()]);
            $client->city = $city;
            $client->state = $state;
            if ($client->update() !== false) {
                return true;
            }
        }
        return false;

    }


    public static function updateUserRoleVendor(int $sphereId): bool
    {
        $user = static::findOne(['id' => Yii::$app->user->getId()]);
        $user->status = self::STATUS_MODERATED;
        $user->role = Vendor::ROLE;
        if ($user->update() !== false) {
            $vendor = Vendor::findOne(['id' => Yii::$app->user->getId()]);
            $vendor->sphere_id = $sphereId;
            if ($vendor->update() !== false) {
                return true;
            }
        }
        return false;

    }

    /**
     * @return string
     */
    public static function userRole()
    {
        if (Yii::$app->user->isGuest) {
            return 'guest';
        } else {
            return self::findCurrentUserRole(Yii::$app->user->getId());
        }
    }

    public static function userStatus()
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
            'status' => self::STATUS_ACTIVE,
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
    public function validatePassword($password)
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
