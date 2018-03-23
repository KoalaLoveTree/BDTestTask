<?php

/** @var $model \frontend\models\CreateNewTimeOrderForm */

/** @var $vendorId int */


use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin(['id' => 'make-new-order']); ?>
<div class="container-fluid">
    <?= $form->field($model, 'startTime')->widget(\kartik\datetime\DateTimePicker::className(),
        [
            'name' => 'startTime',
            'pluginOptions' => [
                'format' => 'dd-M-yyyy hh:ii',
                'startDate' => date('d-M-Y g:i'),
            ]
        ]) ?>
    <?= $form->field($model, 'endTime')->widget(\kartik\datetime\DateTimePicker::className(),
        [
            'name' => 'endTime',
            'pluginOptions' => [
                'format' => 'dd-M-yyyy hh:ii',
                'startDate' => date('d-M-Y g:i'),
            ]
        ]) ?>
    <div style="display: none"><?= $form->field($model, 'vendorId')->hiddenInput(['value' => $vendorId]) ?></div>
    <?= Html::submitButton('Make Order', ['class' => 'btn btn-primary', 'name' => 'make-order-button']) ?>
</div>
<?php ActiveForm::end(); ?>
