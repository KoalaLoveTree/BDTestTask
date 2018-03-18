<?php


namespace frontend\models;


use common\models\User;
use common\models\UserQuery;

class DefaultUser extends User
{

    const ROLE = 'default user';

    public function init()
    {
        $this->role = self::ROLE;
        parent::init();
    }

    public static function find()
    {
        return new UserQuery(get_called_class(), ['type' => self::ROLE, 'tableName' => self::tableName()]);
    }

    public function beforeSave($insert)
    {
        $this->role = self::ROLE;
        return parent::beforeSave($insert);
    }

}