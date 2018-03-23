<?php
/** @var \frontend\models\Vendor $vendor */

use common\models\User;
use frontend\models\Client;
use yii\helpers\Html;

?>

<div>
    <div class="container-fluid">
        E-Mail: <?= $vendor->email ?><br>
        First Name: <?= $vendor->first_name ?><br>
        Last Name: <?= $vendor->last_name ?><br>
        Sphere: <?= $vendor->sphere->title ?><br>
        Level: <?= $vendor->level ?><br>
    </div>

    <?php if (User::userRole() === Client::ROLE): ?>
        <div class="container-fluid">
            <?= Html::a('Make Order Of Time', ['/order/make-new-time-order?vendorId = ' . $vendor->id], ['class' => 'btn btn-block btn-success']) ?>
        </div>
    <?php endif; ?>
</div>
