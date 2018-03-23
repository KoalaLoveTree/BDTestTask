<?php

namespace frontend\controllers;

use common\models\Sphere;
use common\models\User;
use frontend\models\ConfigureClientForm;
use frontend\models\ConfigureVendorForm;
use Yii;
use yii\web\Controller;

class UserController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionConfigureNewVendor()
    {
        if (Yii::$app->user->isGuest || !User::isDefaultUser()) {
            return $this->goHome();
        }
        $model = new ConfigureVendorForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->configureProfileAsVendor()) {
            return $this->redirect(['/']);
        } else {
            $model->sphere = null;
            foreach (Sphere::findAllSpheres() as $sphere) {
                $spheres[] = $sphere->title;
            }
            array_unshift($spheres, null);
            return $this->render('configureNewVendor', [
                'model' => $model,
                'spheres' => $spheres,
            ]);
        }
    }

    public function actionConfigureNewClient()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new ConfigureClientForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->configureProfileAsClient()) {
            return $this->goHome();
        } else {
            $model->city = null;
            $model->state = null;
        }
        return $this->render('configureNewClient', [
            'model' => $model,
        ]);
    }

}
