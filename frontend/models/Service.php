<?php


namespace frontend\models;


use frontend\models\Order;

class Service extends \common\models\Service
{

    public static function createNewService(int $vendorId, string $title, string $description, string $price)
    {
        $service = new Service();
        $service->vendor_id = $vendorId;
        $service->title = $title;
        $service->description = $description;
        $service->price = $price;
        $service->status = self::STATUS_MODERATION;
        if ($service->save() !== false) {
            return true;
        }
        return false;
    }

    public function getOrder()
    {
        return $this->hasMany(Order::className(), ['service_id' => 'id']);
    }

    public function getVendor()
    {
        return $this->hasOne(Vendor::className(), ['id' => 'vendor_id']);
    }

}
