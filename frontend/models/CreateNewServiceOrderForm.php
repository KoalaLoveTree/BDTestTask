<?php


namespace frontend\models;


use yii\base\Model;

class CreateNewServiceOrderForm extends Model
{

    /** @var string */
    public $dateOfOrder;
    /** @var int */
    public $serviceId;

    /** @var Service */
    protected $service;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dateOfOrder','dateOfOrder'],'require'],
            ['dateOfOrder', 'notInPast'],
            ['serviceId', 'isServiceExist'],
        ];
    }

    public function notInPast($attribute, $params)
    {
        if ($this->hasErrors()){
            return;
        }
        if (strtotime($this->dateOfOrder) < strtotime(date('d-M-Y'))) {
            $this->addError($attribute, 'U choose past date.');
        }
    }

    public function isServiceExist()
    {
        if ($this->hasErrors()){
            return;
        }
        $this->service = Service::find()->where(['id' => $this->serviceId])->one();
        if ($this->service === null) {
            $this->addError('serviceId', 'Service does not exist');
        }
    }

    /**
     * @return bool
     */
    public function createNewOrder(): bool
    {
        $order = new ServiceOrder();
        $order->vendor_id = $this->service->vendor_id;
        $order->client_id = \Yii::$app->user->getId();
        $order->service_id = $this->serviceId;
        $order->status = Order::STATUS_MODERATED;
        $order->date = $this->dateOfOrder;

        return $order->save();
    }

}
