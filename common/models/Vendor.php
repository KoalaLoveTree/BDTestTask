<?php


namespace common\models;


use common\models\User;
use common\models\UserQuery;
use yii\db\ActiveQuery;

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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSphere():ActiveQuery
    {
        return $this->hasOne(Sphere::className(),['id' => 'sphere_id']);
    }

    public function init()
    {
        $this->role = self::ROLE;
        parent::init();
    }

    /**
     * @return \common\models\UserQuery|ActiveQuery
     */
    public static function find():ActiveQuery
    {
        return new UserQuery(get_called_class(), ['role' => self::ROLE, 'tableName' => self::tableName()]);
    }

    public function beforeSave($insert)
    {
        $this->role = self::ROLE;
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices(): ActiveQuery
    {
        return $this->hasMany(Service::className(), ['vendor_id' => 'id']);
    }

}
