<?php


namespace backend\controllers;


use backend\models\Service;
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
        ];
    }

    public function actionForConfirm()
    {
        return $this->render('services', [
            'services' => new ActiveDataProvider([
                'query' => Service::getServicesForModeration()
            ]),
        ]);
    }

    public function actionConfirmService()
    {
        if (Service::confirmService(Yii::$app->request->get('id_'))) {
            $this->redirect(['/service/for-confirm']);
        }
        return $this->redirect(['/service/for-confirm']);
    }

    public function actionBanService()
    {
        if (Service::banService(Yii::$app->request->get('id_'))) {
            $this->redirect(['/service/for-confirm']);
        }
        return $this->redirect(['/service/for-confirm']);
    }
}
