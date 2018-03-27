<?php


namespace frontend\controllers;


use common\models\User;
use frontend\models\Service;
use frontend\models\CreateNewServiceForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ServiceController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['exist-services', 'my-services', 'create-new-service'],
                'rules' => [
                    [
                        'actions' => ['exist-services'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return User::isClient();
                        }
                    ],
                    [
                        'actions' => ['my-services', 'create-new-service'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return User::isVendor();
                        }
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'my-services' => ['get'],
                    'create-new-service' => ['post','get'],
                    'exist-services' => ['get'],
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

    public function actionMyServices()
    {
        return $this->render('services', [
            'services' => new ActiveDataProvider([
                'query' => Service::find()->where(['vendor_id' => \Yii::$app->user->getId()])
                    ->orderBy('title')->with('vendor')
            ]),
        ]);
    }

    public function actionExistServices()
    {
        return $this->render('services', [
            'services' => new ActiveDataProvider([
                'query' => Service::find()->where(['status' => 10])
                    ->orderBy('title')->with('vendor')
            ]),
        ]);
    }

    public function actionCreateNewService()
    {
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
