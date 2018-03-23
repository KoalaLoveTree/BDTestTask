<?php


namespace frontend\controllers;


use frontend\models\Vendor;
use yii\web\Controller;

class VendorController extends Controller
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

    public function actionVendorPage()
    {
        return $this->render('vendorPage', [
            'vendor' => Vendor::findById(\Yii::$app->request->get('id_'))
        ]);
    }

}
