<?php

/** @var \common\models\Service $model */

/** @var \frontend\controllers\ServiceController $this */

use common\models\User;
use frontend\models\Client;
use common\models\Vendor;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>
<div>

    <h2><?= Html::encode($model->title) ?></h2>
    Description: <?= HtmlPurifier::process($model->description) ?><br>
    Price: <?= HtmlPurifier::process($model->price) ?>$<br>

</div>
<div class="container-fluid">
    <?= Html::a('Confirm', ['/service/confirm-service/?id = ' . $model->id], ['class' => 'btn btn-block btn-success']) ?>
    <?= Html::a('Ban', ['/service/ban-service/?id = ' . $model->id], ['class' => 'btn btn-block btn-success']) ?>
</div>
<br>
