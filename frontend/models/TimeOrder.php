<?php


namespace frontend\models;


/**
 * Class TimeOrder
 *
 * @property string $time_start
 * @property string $time_end
 * @property int $price
 */

class TimeOrder extends Order
{

    const TYPE = 'time';

    public function init()
    {
        $this->type = self::TYPE;
        parent::init();
    }

    /**
     * @return OrderQuery
     */
    public static function find(): OrderQuery
    {
        return new OrderQuery(get_called_class(), ['type' => self::TYPE, 'tableName' => self::tableName()]);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        $this->type = self::TYPE;
        return parent::beforeSave($insert);
    }

}
