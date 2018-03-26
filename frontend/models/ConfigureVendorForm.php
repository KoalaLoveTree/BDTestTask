<?php


namespace frontend\models;


use common\models\Sphere;
use common\models\User;
use Yii;
use yii\base\Model;

class ConfigureVendorForm extends Model
{

    /** @var int */
    public $sphere;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['sphere', 'required'],
            ['sphere', 'number'],
            ['sphere', 'isSphereExist']
        ];
    }

    public function isSphereExist()
    {
        if (Sphere::findOne(['id' => $this->sphere]) === null) {
            $this->addError('sphere', 'This sphere does not exist');
        }
    }

    /**
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function configureProfileAsVendor(): bool
    {
        $user = User::findOne(['id' => Yii::$app->user->getId()]);
        $user->role = Vendor::ROLE;
        if ($user->update()) {
            $newVendor = Vendor::findOne(['id' => Yii::$app->user->getId()]);
            $newVendor->status = User::STATUS_MODERATED;
            $newVendor->sphere_id = $this->sphere;
            if ($newVendor->update() !== false) {
                return true;
            }
        }
        $this->addError('sphere', 'Something wrong, please try again later');
        return false;
    }

}
