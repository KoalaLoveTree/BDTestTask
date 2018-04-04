<?php
/**
 * Created by PhpStorm.
 * User: bigdrop
 * Date: 4/4/18
 * Time: 4:02 PM
 */

namespace console\controllers;

use backend\models\Admin;
use common\models\Sphere;
use common\models\User;
use yii\console\Controller;

class DefaultDataController extends Controller
{

    public function actionInit()
    {
        $this->createAdmin();
        $this->createSphere();
    }

    protected function createAdmin(){
        if (Admin::find()->exists()){
            return false;
        }
        $admin = new Admin();
        $admin->email = 'admin@test.lo';
        $admin->first_name = 'Koala';
        $admin->last_name = 'Angry';
        $admin->status = User::STATUS_APPROVE;
        return $admin->save();
    }

    protected function createSphere(){
        if (Sphere::find()->exists()){
            return false;
        }
        $sphere = new Sphere();
        $sphere->title = 'Nature';
        return $sphere->save();
    }

}
