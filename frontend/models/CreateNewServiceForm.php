<?php


namespace frontend\models;

use common\models\User;
use yii\base\Model;

class CreateNewServiceForm extends Model
{

    public $title;
    public $description;
    public $price;

    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'price'], 'required'],
        ];
    }

    public function createNewService()
    {
        return Service::createNewService(\Yii::$app->user->getId(), $this->title, $this->description, $this->price);
    }

    /**
     * Finds user by [[email]]
     *
     * @return array|User
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findById(\Yii::$app->user->getId());
        }

        return $this->_user;
    }

}
