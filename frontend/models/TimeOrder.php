<?php


namespace frontend\models;


/**
 * Class TimeOrder
 *
 * @property string $time_start
 * @property string $time_end
 */

class TimeOrder extends Order
{

    const TYPE = 'time';

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
