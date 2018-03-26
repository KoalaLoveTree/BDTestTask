<?php


namespace backend\models;


use common\models\User;
use common\models\UserQuery;
use yii\db\ActiveQuery;

class Admin extends User
{

    const ROLE = 'admin';

    public function init()
    {
        $this->role = self::ROLE;
        parent::init();
    }

    /**
     * @param string $email
     * @return User|null|array
     */
    public static function findByEmail(string $email):?User
    {
        return static::find()->where(['email' => $email])->one();
    }

    /**
     * @return UserQuery
     */
    public static function find():UserQuery
    {
        return new UserQuery(get_called_class(), ['role' => self::ROLE, 'tableName' => self::tableName()]);
    }

    public function beforeSave($insert)
    {
        $this->role = self::ROLE;
        return parent::beforeSave($insert);
    }

}
