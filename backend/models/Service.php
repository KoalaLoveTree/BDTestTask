<?php


namespace backend\models;


class Service extends \common\models\Service
{
    public static function getServicesForModeration()
    {
        return static::find()->where(['status' => self::STATUS_MODERATION]);
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function confirmService(int $id): bool
    {
        $service = static::findOne(['id' => $id]);
        $service->status = self::STATUS_APPROVE;
        if ($service->update() !== false) {
            return true;
        }

        return false;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function banService(int $id): bool
    {
        $service = static::findOne(['id' => $id]);
        $service->status = self::STATUS_DELETED;
        if ($service->update() !== false) {
            return true;
        }

        return false;
    }

}
