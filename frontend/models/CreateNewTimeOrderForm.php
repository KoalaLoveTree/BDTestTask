<?php


namespace frontend\models;


use frontend\models\Order;
use frontend\models\TimeOrder;
use yii\base\Model;

class CreateNewTimeOrderForm extends Model
{
    public $startTime;
    public $endTime;
    public $vendorId;

    private $fullTime;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['startTime', 'endTime', 'vendorId'], 'required'],
            [['startTime', 'endTime'], 'checkTime'],
        ];
    }

    public function checkTime()
    {
        if (strtotime($this->endTime) < strtotime($this->startTime) || strtotime($this->endTime) < microtime() || strtotime($this->startTime) < microtime()) {

            return false;
        }
        $this->fullTime = strtotime($this->endTime) - strtotime($this->startTime);

        return true;
    }

    public function createTimeOrder()
    {
        /** @var Vendor $vendor */
        $vendor = Vendor::findById($this->vendorId);
        $order = new TimeOrder();
        $order->vendor_id = $this->vendorId;
        $order->client_id = \Yii::$app->user->getId();
        $order->status = Order::STATUS_MODERATED;
        $order->price = $this->computationPrice($vendor);
        $order->time_start = $this->startTime;
        $order->time_end = $this->endTime;
        if ($order->save() !== false) {

            return true;
        }

        return false;

    }

    protected function computationPrice(Vendor $vendor)
    {
        return $vendor->level * Vendor::MINIMUM_VENDOR_PRICE * 100 / 60 * ($this->fullTime / 60000) / 100;
    }
}
