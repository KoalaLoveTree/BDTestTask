<?php

namespace common\models;


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
    public static function tableName()
    {
        return 'service';
    }

}
