<?php


namespace frontend\models;


/**
 * Class ServiceOrder
 * @property string $date
 * @property integer $service_id
 */
class ServiceOrder extends Order
{

    const TYPE = 'service';

    public function init()
    {
        $this->type = self::TYPE;
        parent::init();
    }

    public static function find()
    {
        return new OrderQuery(get_called_class(), ['type' => self::TYPE, 'tableName' => self::tableName()]);
    }

    public function beforeSave($insert)
    {
        $this->type = self::TYPE;
        return parent::beforeSave($insert);
    }

}
