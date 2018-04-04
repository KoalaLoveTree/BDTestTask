<?php

namespace common\models;


use common\interfaces\StatusInterface;
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
class Service extends ActiveRecord implements StatusInterface
{

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
