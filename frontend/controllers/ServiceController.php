<?php


namespace frontend\controllers;


use frontend\models\Service;
use frontend\models\CreateNewServiceForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class ServiceController extends Controller
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

    public function actionMyServices()
    {
        return $this->render('services', [
            'services' => new ActiveDataProvider([
                'query' => Service::find()->where(['vendor_id' => \Yii::$app->user->getId()])
                    ->orderBy('title')
            ]),
        ]);
    }

    public function actionExistServices()
    {
        return $this->render('services', [
            'services' => new ActiveDataProvider([
                'query' => Service::find()->where(['status' => 10])
                    ->orderBy('title')
            ]),
        ]);
    }

    public function actionCreateNewService()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new CreateNewServiceForm();
        if ($model->load(Yii::$app->request->post()) && $model->createNewService()) {
            return $this->redirect(['/service/my-services']);
        } else {
            $model->description = '';
            $model->price = '';
            $model->title = '';

            return $this->render('createNewService', [
                'model' => $model,
            ]);
        }
    }

}
