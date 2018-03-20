<?php

use common\models\User;
use frontend\models\Client;
use frontend\models\Vendor;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>
<a class="list-group-item" href='/service/show/<?= $model->id ?>'>

    <h2><?= Html::encode($model->title) ?></h2>
    Description: <?= HtmlPurifier::process($model->description) ?><br>
    Price: <?= HtmlPurifier::process($model->price) ?>$<br>
    <?php if (User::userRole() === Vendor::ROLE):?>
        Status: <?php if ($model->status === 5): ?>
        Checking
    <?php elseif ($model->status === 10): ?>
        Approved
    <?php elseif ($model->status === 0): ?>
        Ban
    <?php endif;endif; ?>
</a>
<?php if (User::userRole() === Client::ROLE):?>
    <div class="container-fluid">
        <?= Html::a('Make Order', ['/order/make-new-order'], ['class' => 'btn btn-block btn-success']) ?>
    </div>
<?php endif;?>
