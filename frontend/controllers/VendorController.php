<?php


namespace frontend\controllers;


use common\models\User;
use frontend\models\Vendor;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class VendorController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['vendor-page'],
                'rules' => [
                    [
                        'actions' => ['vendor-page'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return User::isClient();
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'vendor-page' => ['get'],
                ],
            ],
        ];
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
            'vendor' => Vendor::findById(\Yii::$app->request->get('id'))
        ]);
    }

}
