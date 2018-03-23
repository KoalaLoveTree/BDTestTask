<?php


namespace common\models;


use common\models\User;
use common\models\UserQuery;

/**
 * Class Vendor
 *
 * @property integer $sphere_id
 * @property integer $level
 */

class Vendor extends User
{

    const ROLE = 'vendor';

    const MINIMUM_VENDOR_PRICE = 15;

    public function getSphere()
    {
        return $this->hasOne(Sphere::className(),['id' => 'sphere_id']);
    }

    public function init()
    {
        $this->role = self::ROLE;
        parent::init();
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
