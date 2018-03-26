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
