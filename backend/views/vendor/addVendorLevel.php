<?php

/** @var $model \backend\models\ConfirmVendorForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

<?= $form->field($model, 'level')->textInput() ?>

<?= Html::submitButton('Add Level', ['class' => 'btn btn-primary', 'name' => 'add-vendor-level-button']) ?>

<?php ActiveForm::end(); ?>
