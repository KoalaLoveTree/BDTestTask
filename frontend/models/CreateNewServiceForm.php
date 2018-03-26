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

    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'price'], 'required'],
            [['title', 'description'], 'string'],
            ['price', 'number']

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

    /**
     * Finds user by [[email]]
     *
     * @return User
     */
    protected function getUser(): User
    {
        if ($this->_user === null) {
            $this->_user = User::findById(\Yii::$app->user->getId());
        }

        return $this->_user;
    }

}
