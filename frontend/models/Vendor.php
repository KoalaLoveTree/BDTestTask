<?php


namespace frontend\models;


class Vendor extends \common\models\Vendor
{


    public function getServices()
    {
        return $this->hasMany(Service::className(), ['vendor_id' => 'id']);
    }
}
