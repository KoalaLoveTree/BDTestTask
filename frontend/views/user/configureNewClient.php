<?php

/** @var $model \frontend\models\ConfigureClientForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="row">
    <div class="container-fluid">
        <?php $form = ActiveForm::begin(['id' => 'configure-client-form','method' => 'put']); ?>

        <?= $form->field($model, 'city')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'state')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Configure', ['class' => 'btn btn-block btn-success', 'name' => 'configure-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
