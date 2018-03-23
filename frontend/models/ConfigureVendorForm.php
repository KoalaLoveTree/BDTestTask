<?php


namespace frontend\models;


use common\models\Sphere;
use common\models\User;
use yii\base\Model;

class ConfigureVendorForm extends Model
{

    /** @var int */
    public $sphere;

    /** @var array */
    private $_spheres;
    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['sphere', 'required'],
//            ['sphere', 'isSphereExist']
        ];
    }

    public function isSphereExist()
    {
        /** @var Sphere[] $spheres */
        $spheres = $this->getAllSpheresId();
        foreach ($spheres as $sphere) {
            if ($sphere->id == $this->sphere) {
                return true;
            }
        }
//        if (in_array(($this->sphere+1),$this->getAllSpheresId())){
//            return true;
//        }
        return false;
    }

    protected function getAllSpheresId()
    {
        if ($this->_spheres === null) {
            $this->_spheres = Sphere::findAllSpheresId();
        }

        return $this->_spheres;
    }

    public function configureProfileAsVendor()
    {
        $this->_user = User::updateUserRoleVendor($this->sphere);
    }

}
