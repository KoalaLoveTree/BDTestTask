<?php

/* @var $this yii\web\View */

use common\models\User;
use frontend\models\Client;
use frontend\models\DefaultUser;
use frontend\models\Vendor;
use yii\helpers\Html;

$role = User::userRole();
$this->title = 'Vendors';
?>
<div class="site-index">


    <?php if (Yii::$app->user->isGuest): ?>

        <div class="jumbotron">
            <?= Html::a('Sign Up', ['/site/signup'], ['class' => 'btn btn-lg btn-success']) ?>
            or
            <?= Html::a('Login', ['/site/login'], ['class' => 'btn btn-lg btn-success']) ?>
            for start using our site.
        </div>

    <?php endif; ?>
    <?php if ($role === DefaultUser::ROLE): ?>
        <div class="jumbotron">
            <h1>Congratulations!</h1>

            <p class="lead">You have successfully created your account, now tap the button below to configure u'r
                profile as <a href="/user/configure-new-vendor">vendor</a> or <a href="/user/configure-new-client">client</a>.
            </p>
        </div>
    <?php endif; ?>

    <?php if ($role === Vendor::ROLE): ?>
        <div class="jumbotron">
            <h1>Hello!</h1>

            <p class="lead">Clients all over the world are waiting for you.</p>
            <div>
                <?= Html::a('My Services', ['/service/my-services'], ['class' => 'btn btn-lg btn-success']) ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($role === Client::ROLE): ?>
        <div class="jumbotron">
            <h1>Hello!</h1>

            <p class="lead">Vendors around the world offer you their services.</p>
            <div>
                <?= Html::a('Services', ['/service/exist-services'], ['class' => 'btn btn-lg btn-success']) ?>
            </div>
        </div>
    <?php endif; ?>
</div>
