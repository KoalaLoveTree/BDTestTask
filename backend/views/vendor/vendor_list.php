<?php

/** @var \backend\models\Vendor $model */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>
<div class="list-group-item">

    <h2><?= Html::encode($model->email) ?></h2>
    First Name: <?= HtmlPurifier::process($model->first_name) ?><br>
    Last Name: <?= HtmlPurifier::process($model->last_name) ?><br>
    Sphere: <?= HtmlPurifier::process($model->sphere->title) ?><br>
    Status: <?= \common\helpers\StatusHelper::getServiceStatusString($model->status) ?><br>


</div>
<div class="container-fluid">

    <?= Html::a('Confirm', ['/vendor/confirm-vendor?id=' . $model->id], ['class' => 'btn btn-block btn-success']) ?>

    <?= Html::a('Ban', ['/vendor/ban-vendor?id=' . $model->id], ['class' => 'btn btn-block btn-success']) ?>
</div>
