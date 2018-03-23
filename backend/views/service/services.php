<?php
/** @var ActiveDataProvider $services */

use common\models\User;
use common\models\Vendor;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

?>

<div>

    <?= \yii\widgets\ListView::widget([
        'id' => 'services',
        'dataProvider' => $services,
        'itemView' => 'service_list'
    ]) ?>

</div>
