<?php
/**
 * Created by PhpStorm.
 * User: bigdrop
 * Date: 4/4/18
 * Time: 5:11 PM
 */

namespace backend\controllers;


use backend\models\CreateNewSphereForm;
use yii\filters\AccessControl;
use yii\web\Controller;

class SphereController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['create-new-sphere'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
        ];
    }

    public function actionCreateNewSphere()
    {
        $model = new CreateNewSphereForm();
        if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->createSphere()) {
            return $this->redirect(['/']);
        }
        return $this->render('createNewSphere', [
            'model' => $model,
        ]);
    }

}
