<?php


namespace frontend\models;


use common\models\User;
use yii\base\Model;

class ConfigureClientForm extends Model
{
    public $city;
    public $state;

    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city', 'state'], 'required'],
        ];
    }

    public function configureProfileAsClient()
    {
        $this->_user = User::updateUserRoleClient($this->city, $this->state);
    }

}
