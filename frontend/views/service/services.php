<?php
/** @var ActiveDataProvider $services*/

use common\models\User;
use frontend\models\Vendor;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

?>

<div>

    <?= \yii\widgets\ListView::widget([
        'id' => 'services',
        'dataProvider' => $services,
        'itemView' => 'vendor_service_list'
    ]) ?>

    <?php if (User::userRole() === Vendor::ROLE):?>
    <div class="container-fluid">
        <?= Html::a('Create New Service', ['/service/create-new-service'], ['class' => 'btn btn-block btn-success']) ?>
    </div>
    <?php endif;?>


</div>
