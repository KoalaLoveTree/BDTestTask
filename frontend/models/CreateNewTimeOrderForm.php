<?php


namespace frontend\models;

use yii\base\Model;

class CreateNewTimeOrderForm extends Model
{
    /** @var string */
    public $startTime;
    /** @var string */
    public $endTime;
    /** @var int */
    public $vendorId;

    /** @var string */
    private $fullTime;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['startTime', 'endTime', 'vendorId'], 'required'],
//            [['startTime', 'endTime', 'vendorId'], 'datetime','format'=> 'd-M-Y g:i'],
            [['startTime', 'endTime'], 'checkTime'],
            [['startTime', 'endTime'], 'notInPast'],
            ['vendorId', 'number'],
            ['vendorId', 'isVendorExist'],
        ];
    }

    public function checkTime()
    {
        if ($this->hasErrors()){
            return;
        }
        if (strtotime($this->endTime) < strtotime($this->startTime)) {

            $this->addError('startTime', 'Wrong time');
        }
        $this->fullTime = strtotime($this->endTime) - strtotime($this->startTime);
    }


    public function notInPast()
    {
        if ($this->hasErrors()){
            return;
        }
        if (strtotime($this->endTime) < microtime() || strtotime($this->startTime) < microtime()) {
            $this->addError('startTime', 'Time cannot be in past');
        }
    }

    public function isVendorExist()
    {
        if ($this->hasErrors()){
            return;
        }
        $vendor = Vendor::findById($this->vendorId);
        if ($vendor === null) {
            $this->addError('vendorId', 'Vendor does not exist');
        }
    }

    /**
     * @return bool
     */
    public function createTimeOrder(): bool
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
        return $order->save();

    }

    /**
     * @param Vendor $vendor
     * @return int
     */
    protected function computationPrice(Vendor $vendor): int
    {
        return $vendor->level * Vendor::MINIMUM_VENDOR_PRICE * 100 / 60 * ($this->fullTime / 60000);
    }
}
