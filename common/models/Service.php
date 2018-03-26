<?php

namespace common\models;


use frontend\models\Order;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;


/**
 * Service model
 *
 * @property integer $id
 * @property integer $vendor_id
 * @property string $title
 * @property string $description
 * @property string $price
 * @property integer $status
 *
 */
class Service extends ActiveRecord
{

    const STATUS_DELETED = 0;
    const STATUS_MODERATION = 5;
    const STATUS_APPROVE = 10;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'required'],
        ];
    }

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'service';
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price / 100;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder(): ActiveQuery
    {
        return $this->hasMany(Order::className(), ['service_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVendor(): ActiveQuery
    {
        return $this->hasOne(Vendor::className(), ['id' => 'vendor_id']);
    }
}
