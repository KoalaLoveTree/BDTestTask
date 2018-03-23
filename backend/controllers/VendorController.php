<?php


namespace backend\controllers;


use backend\models\ConfirmVendorForm;
use backend\models\Vendor;
use Yii;
use yii\data\ActiveDataProvider;
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
        ];
    }

    public function actionForConfirm()
    {
        return $this->render('vendors', [
            'vendors' => new ActiveDataProvider([
                'query' => Vendor::getVendorsForModeration(),
            ])
        ]);
    }

    public function actionConfirmVendor()
    {
        $model = new ConfirmVendorForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->confirmVendorLevel(Yii::$app->request->get('id_'))) {
            return $this->redirect(['/vendor/for-confirm']);
        }
        return $this->render('addVendorLevel', [
            'model' => $model,
        ]);
    }

    public function actionBanVendor()
    {
        if (Vendor::banVendor(Yii::$app->request->get('id_'))) {
            return $this->redirect(['/vendor/for-confirm']);
        }
        return $this->redirect(['/vendor/for-confirm']);
    }
}
