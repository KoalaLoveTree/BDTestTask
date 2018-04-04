<?php


namespace frontend\models;

use common\models\User;
use yii\base\Model;

class CreateNewServiceForm extends Model
{

    /** @var string */
    public $title;
    /** @var string */
    public $description;
    /** @var float */
    public $price;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'price'], 'required'],
            [['title', 'description'], 'string', 'max' => 127],
            ['price', 'number', 'min' => 0.1]

        ];
    }

    public function createNewService()
    {
        $service = new Service();
        $service->vendor_id = \Yii::$app->user->getId();
        $service->title = $this->title;
        $service->description = $this->description;
        $service->price = round($this->price,2)*100;
        $service->status = Service::STATUS_MODERATION;
        return $service->save();
    }

}
