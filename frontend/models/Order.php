<?php


namespace frontend\models;


use yii\db\ActiveRecord;


/**
 * Order model
 *
 * @property integer $id
 * @property integer $vendor_id
 * @property integer $client_id
 * @property string $type
 * @property int $status
 * @property int $price
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
    public static function tableName()
    {
        return 'order';
    }

    public function getService()
    {
        if ($this->type === self::TYPE_SERVICE) {
            return $this->hasOne(Service::className(), ['id' => 'service_id']);
        }
        return null;
    }

    public static function confirmOrder(int $id)
    {
        $order = static::findOne(['id' => $id]);
        $order->status = self::STATUS_ACTIVE;
        if ($order->update()!==false){
            return true;
        }

        return false;
    }

    public static function banOrder(int $id)
    {
        $order = static::findOne(['id' => $id]);
        $order->status = self::STATUS_DELETED;
        if ($order->update()!==false){
            return true;
        }

        return false;
    }


    public static function getOrdersForConfirmByVendor(int $vendorId)
    {
        return static::find()->where(['id'=>$vendorId,'status'=>Order::STATUS_MODERATED])->all();
    }

}
