<?php


namespace frontend\models;


use common\models\User;
use common\models\UserQuery;
use yii\db\ActiveQuery;

class DefaultUser extends User
{

    const ROLE = 'default user';

    public function init()
    {
        $this->role = self::ROLE;
        parent::init();
    }

    /**
     * @return UserQuery|\yii\db\ActiveQuery
     */
    public static function find(): ActiveQuery
    {
        return new UserQuery(get_called_class(), ['role' => self::ROLE, 'tableName' => self::tableName()]);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        $this->role = self::ROLE;
        return parent::beforeSave($insert);
    }

}
