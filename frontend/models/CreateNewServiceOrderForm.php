<?php


namespace frontend\models;


use yii\base\Model;

class CreateNewServiceOrderForm extends Model
{

    public $dateOfOrder;
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
            return false;
        }

        return true;
    }

    public function isServiceExist()
    {
        if (Service::find()->where(['id' => $this->serviceId]) !== null) {
            return true;
        }
        return false;
    }

    public function createNewOrder()
    {
        $order = new ServiceOrder();
        /** @var Service $service */
        $service = Service::find()->where(['id' => $this->serviceId])->one();
        $order->vendor_id = $service->vendor_id;
        $order->client_id = \Yii::$app->user->getId();
        $order->service_id = $this->serviceId;
        $order->status = Order::STATUS_MODERATED;
        $order->date = $this->dateOfOrder;
        $order->price = $service->price;

        return $order->save() ? true : false;
    }

}
