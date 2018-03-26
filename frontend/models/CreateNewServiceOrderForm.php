<?php


namespace frontend\models;


use yii\base\Model;

class CreateNewServiceOrderForm extends Model
{

    /** @var string */
    public $dateOfOrder;
    /** @var int */
    public $serviceId;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['dateOfOrder', 'notInPast'],
            ['serviceId', 'isServiceExist'],
        ];
    }

    public function notInPast($attribute, $params)
    {
        if (strtotime($this->dateOfOrder) < strtotime(date('d-M-Y'))) {
            $this->addError($attribute, 'U choose past date.');
        }
    }

    public function isServiceExist()
    {
        if (Service::find()->where(['id' => $this->serviceId])->one() === null) {
            $this->addError('serviceId', 'Service does not exist');
        }
    }

    /**
     * @return bool
     */
    public function createNewOrder(): bool
    {
        $order = new ServiceOrder();
        /** @var Service $service */
        $service = Service::find()->where(['id' => $this->serviceId])->one();
        $order->vendor_id = $service->vendor_id;
        $order->client_id = \Yii::$app->user->getId();
        $order->service_id = $this->serviceId;
        $order->status = Order::STATUS_MODERATED;
        $order->date = $this->dateOfOrder;

        return $order->save();
    }

}
