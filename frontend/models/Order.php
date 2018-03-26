<?php


namespace frontend\models;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;


/**
 * Order model
 *
 * @property integer $id
 * @property integer $vendor_id
 * @property integer $client_id
 * @property string $type
 * @property int $status
 */
class Order extends ActiveRecord
{

    const TYPE_SERVICE = 'service';
    const TYPE_TIME = 'time';

    const STATUS_DELETED = 0;
    const STATUS_MODERATED = 5;
    const STATUS_ACTIVE = 10;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'order';
    }

    /**
     * @return null|\yii\db\ActiveQuery
     */
    public function getService(): ?ActiveQuery
    {
        if ($this->type === self::TYPE_SERVICE) {
            return $this->hasOne(Service::className(), ['id' => 'service_id']);
        }
        return null;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function confirmOrder(int $id): bool
    {
        $order = static::findOne(['id' => $id]);
        $order->status = self::STATUS_ACTIVE;
        if ($order->update() !== false) {
            return true;
        }

        return false;
    }

    public function getPrice()
    {
        return $this->price/100;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function banOrder(int $id): bool
    {
        $order = static::findOne(['id' => $id]);
        $order->status = self::STATUS_DELETED;
        if ($order->update() !== false) {
            return true;
        }

        return false;
    }


    /**
     * @param int $vendorId
     * @return array|ActiveRecord[]
     */
    public static function getOrdersForConfirmByVendor(int $vendorId): array
    {
        return static::find()->where(['id' => $vendorId, 'status' => Order::STATUS_MODERATED])->all();
    }

}
