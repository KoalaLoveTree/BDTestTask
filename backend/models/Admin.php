<?php


namespace backend\models;


use common\models\User;
use common\models\UserQuery;

class Admin extends User
{

    const ROLE = 'admin';

    public function init()
    {
        $this->role = self::ROLE;
        parent::init();
    }

    public static function findByEmail(string $email)
    {
        return static::find()->where(['email' => $email])->one();
    }

    public static function find()
    {
        return new UserQuery(get_called_class(), ['role' => self::ROLE, 'tableName' => self::tableName()]);
    }

    public function beforeSave($insert)
    {
        $this->role = self::ROLE;
        return parent::beforeSave($insert);
    }

}
