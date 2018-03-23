<?php


namespace backend\models;


class Service extends \common\models\Service
{
    public static function getServicesForModeration()
    {
        return static::find()->where(['status' => self::STATUS_MODERATION]);
    }

    public static function confirmService(int $id)
    {
        $service = static::findOne(['id' => $id]);
        $service->status = self::STATUS_APPROVE;
        if ($service->update() !== false) {
            return true;
        }

        return false;
    }

    public static function banService(int $id)
    {
        $service = static::findOne(['id' => $id]);
        $service->status = self::STATUS_DELETED;
        if ($service->update() !== false) {
            return true;
        }

        return false;
    }

}
