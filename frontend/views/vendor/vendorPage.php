<?php
/** @var \frontend\models\Vendor $vendor */

use common\models\User;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>

<div>
    <div class="container-fluid">
        E-Mail: <?= HtmlPurifier::process($vendor->email) ?><br>
        First Name: <?= HtmlPurifier::process($vendor->first_name) ?><br>
        Last Name: <?= HtmlPurifier::process($vendor->last_name) ?><br>
        Sphere: <?= HtmlPurifier::process($vendor->sphere->title) ?><br>
        Level: <?= HtmlPurifier::process($vendor->level) ?><br>
    </div>

    <?php if (User::isClient()): ?>
        <div class="container-fluid">
            <?= Html::a('Make Order Of Time', ['/order/make-new-time-order?vendorId = ' . $vendor->id], ['class' => 'btn btn-block btn-success']) ?>
        </div>
    <?php endif; ?>
</div>
