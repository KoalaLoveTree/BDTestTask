<?php


namespace frontend\controllers;


use frontend\models\Order;
use common\models\User;
use frontend\models\CreateNewServiceOrderForm;
use frontend\models\CreateNewTimeOrderForm;
use frontend\models\Service;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class OrderController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['my-orders', 'ban-order', 'confirm-order', 'orders-for-confirm'],
                'rules' => [
                    [
                        'actions' => ['my-orders'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return User::isClient() || User::isVendor();
                        }
                    ],
                    [
                        'actions' => ['ban-order', 'confirm-order', 'orders-for-confirm'],
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
                    'my-orders' => ['get'],
                    'ban-order' => ['put'],
                    'confirm-order' => ['put'],
                    'orders-for-confirm' => ['get'],
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

    public function actionMyOrders()
    {
        if (User::isVendor()) {
            return $this->render('orders', [
                'orders' => new ActiveDataProvider([
                    'query' => Order::find()->where(['vendor_id' => \Yii::$app->user->getId(), 'status' => Order::STATUS_ACTIVE])->with('service'),
                ]),
            ]);
        } elseif (User::isClient()) {
            return $this->render('orders', [
                'orders' => new ActiveDataProvider([
                    'query' => Order::find()->where(['client_id' => \Yii::$app->user->getId(), 'status' => Order::STATUS_ACTIVE])->with('service'),
                ]),
            ]);
        }
        return $this->goHome();
    }

    public function actionOrdersForConfirm()
    {
        if (User::isVendor()) {
            return $this->render('orders', [
                'orders' => new ActiveDataProvider([
                    'query' => Order::find()->where(['vendor_id' => Yii::$app->user->getId(), 'status' => Order::STATUS_MODERATED])->with('service'),
                ]),
            ]);
        } elseif (User::isClient()) {
            return $this->goHome();
        }
        return $this->goHome();
    }

    public function actionMakeNewServiceOrder()
    {
        $model = new CreateNewServiceOrderForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->createNewOrder()) {
            return $this->redirect(['/service/exist-services']);
        }
        return $this->render('createNewServiceOrder', [
            'model' => $model,
            'service' => Service::find()->where(['id' => Yii::$app->request->get('serviceId_')])->one(),
        ]);
    }

    public function actionMakeNewTimeOrder()
    {
        $model = new CreateNewTimeOrderForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->createTimeOrder()) {
            return $this->redirect(['/service/exist-services']);
        }
        return $this->render('createNewTimeOrder', [
            'model' => $model,
            'vendorId' => Yii::$app->request->get('vendorId_'),
        ]);
    }

    public function actionConfirmOrder()
    {
        if (Order::confirmOrder(Yii::$app->request->get('id_'))) {
            $this->redirect(['/order/orders-for-confirm']);
        }
        return $this->redirect(['/order/orders-for-confirm']);
    }

    public function actionBanOrder()
    {
        if (Order::banOrder(Yii::$app->request->get('id_'))) {
            $this->redirect(['/order/orders-for-confirm']);
        }
        return $this->redirect(['/order/orders-for-confirm']);
    }
}
