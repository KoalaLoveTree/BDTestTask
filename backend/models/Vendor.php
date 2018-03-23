<?php


namespace backend\models;


class Vendor extends \common\models\Vendor
{

    public static function getVendorsForModeration()
    {
        return static::find()->where(['status' => self::STATUS_MODERATED]);
    }

    public static function confirmVendor(int $id, int $level)
    {
        $vendor = static::findOne(['id' => $id]);
        $vendor->level = $level;
        $vendor->status = self::STATUS_ACTIVE;
        if ($vendor->update() !== false) {
            return true;
        }

        return false;
    }

    public static function banVendor(int $id)
    {
        $vendor = static::findOne(['id' => $id]);
        $vendor->status = self::STATUS_DELETED;
        if ($vendor->update() !== false) {
            return true;
        }

        return false;
    }

}
