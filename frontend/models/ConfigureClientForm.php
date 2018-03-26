<?php


namespace frontend\models;


use common\models\User;
use Yii;
use yii\base\Model;

class ConfigureClientForm extends Model
{
    /** @var string */
    public $city;
    /** @var string */
    public $state;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city', 'state'], 'required'],
            [['city', 'state'], 'string'],
        ];
    }

    /**
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function configureProfileAsClient(): bool
    {
        $user = User::findOne(['id' => Yii::$app->user->getId()]);
        $user->role = Client::ROLE;
        if ($user->update()) {
            $newClient = Client::findOne(['id' => Yii::$app->user->getId()]);
            $newClient->city = $this->city;
            $newClient->state = $this->state;
            if($newClient->update()!==false) {
                return true;
            }
        }
        $this->addError('city', 'Some wrong data');
        return false;
    }

}
