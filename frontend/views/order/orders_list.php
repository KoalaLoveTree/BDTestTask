<?php

/** @var \frontend\models\Order $model */

/** @var \frontend\controllers\OrderController $this */

use common\models\User;
use frontend\models\Order;

use yii\bootstrap\Html;
use yii\helpers\HtmlPurifier;

?>
<div>

    Type: <?= HtmlPurifier::process($model->type) ?><br>

    <?php if ($model->type === Order::TYPE_SERVICE): ?>
        Title: <?= HtmlPurifier::process($model->service->title) ?><br>
        Description: <?= HtmlPurifier::process($model->service->description) ?><br>
        Date: <?= HtmlPurifier::process($model->date) ?><br>
        Price: <?= HtmlPurifier::process($model->getPrice()) ?>$<br>
    <?php elseif ($model->type === Order::TYPE_TIME): ?>
        Time Start: <?= HtmlPurifier::process($model->time_start) ?><br>
        Time End: <?= HtmlPurifier::process($model->time_end) ?><br>
        Price: <?= HtmlPurifier::process($model->getPrice()) ?>$<br>
    <?php endif; ?>

    Status: <?= \common\helpers\StatusHelper::getServiceStatusString($model->status) ?><br>
    <?php if (User::isVendor() && $model->status === Order::STATUS_MODERATED): ?>
        <div class="container-fluid">
            <?= Html::a('Confirm', ['/order/confirm-order/?id=' . $model->id], ['class' => 'btn btn-block btn-success','data'=>[
                    'method' => 'put'
            ]]) ?>
            <?= Html::a('Ban', ['/order/ban-order/?id=' . $model->id], ['class' => 'btn btn-block btn-success', 'data'=>[
                'method' => 'put'
            ]]) ?>
        </div>
    <?php endif; ?>

</div>
<br>
