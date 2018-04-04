<?php

/** @var \frontend\controllers\ServiceController $this */
/** @var \frontend\models\Service $model */

use common\models\User;
use frontend\models\Service;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>
<div>

    <h2><?= Html::encode($model->title) ?></h2>
    Description: <?= HtmlPurifier::process($model->description) ?><br>
    Price: <?= HtmlPurifier::process($model->getPrice()) ?>$<br>
    <?php if (User::isVendor()): ?>
        Status: <?= \common\helpers\StatusHelper::getServiceStatusString($model->status) ?><br>
        <?php endif; ?>
</div>
<?php if (User::isClient()): ?>
    <a href="/vendor/vendor-page?id=<?= $model->vendor_id ?>">Vendor: <?= HtmlPurifier::process($model->vendor->email) ?>
        <br></a>
    <?= Html::a('Make Order', ['/order/make-new-service-order?serviceId = ' . $model->id], ['class' => 'btn btn-block btn-success']) ?>
<?php endif; ?>
<br>
