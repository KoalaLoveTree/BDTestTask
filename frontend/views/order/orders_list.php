<?php

/** @var \common\models\Order $model */

/** @var \frontend\controllers\OrderController $this */

use common\models\User;
use frontend\models\Client;
use frontend\models\Vendor;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>
<div>

    Type: <?= HtmlPurifier::process($model->type) ?><br>

    <?php if ($model->type === \common\models\Order::TYPE_SERVICE): ?>
        Title: <?= HtmlPurifier::process($model->service->title) ?><br>
        Description: <?= HtmlPurifier::process($model->service->description) ?><br>
        Date:
    <?php elseif ($model->type === \common\models\Order::TYPE_TIME): ?>
        Date and Time:
    <?php endif; ?>
    <?= HtmlPurifier::process($model->date) ?><br>

    Price: <?= HtmlPurifier::process($model->price) ?>$<br>
    Status: <?php if ($model->status === \common\models\Order::STATUS_MODERATED): ?>
        Checking
    <?php elseif ($model->status === \common\models\Order::STATUS_ACTIVE): ?>
        Approved
    <?php elseif ($model->status === \common\models\Order::STATUS_DELETED): ?>
        Ban
    <?php endif; ?>
    <br>
    <?php if (User::isVendor() && $model->status === \common\models\Order::STATUS_MODERATED): ?>
        <div class="container-fluid">
            <?= Html::a('Confirm', ['/order/confirm-order/?id = ' . $model->id], ['class' => 'btn btn-block btn-success']) ?>
            <?= Html::a('Ban', ['/order/ban-order/?id = ' . $model->id], ['class' => 'btn btn-block btn-success']) ?>
        </div>
    <?php endif; ?>

</div>
<br>
