<?php

/** @var \frontend\models\Service $model */


/** @var \frontend\controllers\ServiceController $this */

use common\models\User;
use frontend\models\Client;
use frontend\models\Vendor;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>
<div>

    <h2><?= Html::encode($model->title) ?></h2>
    Description: <?= HtmlPurifier::process($model->description) ?><br>
    Price: <?= HtmlPurifier::process($model->price) ?>$<br>
    <?php if (User::userRole() === Vendor::ROLE): ?>
        Status: <?php if ($model->status === \common\models\Service::STATUS_MODERATION): ?>
            Checking
        <?php elseif ($model->status === \common\models\Service::STATUS_APPROVE): ?>
            Approved
        <?php elseif ($model->status === \common\models\Service::STATUS_DELETED): ?>
            Ban
        <?php endif;endif; ?>
</div>
<?php if (User::userRole() === Client::ROLE): ?>
    <a href="/vendor/vendor-page?id =<?= $model->vendor_id ?>">Vendor: <?= HtmlPurifier::process($model->vendor->email) ?>
        <br></a>
    <?= Html::a('Make Order', ['/order/make-new-service-order?serviceId = ' . $model->id], ['class' => 'btn btn-block btn-success']) ?>
<?php endif; ?>
<br>
