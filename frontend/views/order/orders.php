<?php
/** @var ActiveDataProvider $orders */

use common\models\User;
use frontend\models\Vendor;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

?>

<div>

    <?= \yii\widgets\ListView::widget([
        'id' => 'services',
        'dataProvider' => $orders,
        'itemView' => 'orders_list'
    ]) ?>

</div>
