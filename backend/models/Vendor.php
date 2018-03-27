<?php


namespace backend\models;


use common\models\UserQuery;

class Vendor extends \common\models\Vendor
{

    /**
     * @return \common\models\UserQuery
     */
    public static function getVendorsForModeration(): UserQuery
    {
        return static::find()->where(['status' => self::STATUS_MODERATED])->with('sphere');
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function banVendor(int $id): bool
    {
        $vendor = static::findOne(['id' => $id]);
        $vendor->status = self::STATUS_DELETED;
        if ($vendor->update() !== false) {
            return true;
        }

        return false;
    }

}
