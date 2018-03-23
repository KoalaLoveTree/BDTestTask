<?php
/** @var ActiveDataProvider $vendors */

use common\models\User;
use common\models\Vendor;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

?>

<div>

    <?= \yii\widgets\ListView::widget([
        'id' => 'services',
        'dataProvider' => $vendors,
        'itemView' => 'vendor_list'
    ]) ?>

</div>
