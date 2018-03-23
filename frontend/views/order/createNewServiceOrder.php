<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/** @var $model \frontend\models\CreateNewServiceOrderForm */
/** @var $service \frontend\models\Service */

?>

<?php $form = ActiveForm::begin(['id' => 'make-new-order']); ?>
<div class="container-fluid">
    <?= $form->field($model, 'dateOfOrder')->widget(\kartik\date\DatePicker::className(),
        [
            'name' => 'dateOfOrder',
            'value' => date('d-M-Y'),
            'pluginOptions' => [
                'format' => 'dd-M-yyyy',
                'todayHighlight' => true
            ],
        ]) ?>
    <div style="display: none"><?= $form->field($model, 'serviceId')->hiddenInput(['value' => $service->id]) ?></div>
    <div class="form-group">
        <?= Html::submitButton('Make Order', ['class' => 'btn btn-primary', 'name' => 'make-order-button']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
