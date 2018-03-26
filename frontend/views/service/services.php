<?php
/** @var ActiveDataProvider $services */

use common\models\User;
use frontend\models\Vendor;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

?>

<div>

    <?= \yii\widgets\ListView::widget([
        'id' => 'services',
        'dataProvider' => $services,
        'itemView' => 'service_list'
    ]) ?>

    <?php if (User::isVendor() && User::userStatus() === User::STATUS_ACTIVE): ?>
        <div class="container-fluid">
            <?= Html::a('Create New Service', ['/service/create-new-service'], ['class' => 'btn btn-block btn-success']) ?>
        </div>
    <?php endif; ?>


</div>
