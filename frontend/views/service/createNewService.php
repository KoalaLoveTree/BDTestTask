<?php

/* @var $model common\models\Service */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="row">
    <div class="container-fluid">
        <?php $form = ActiveForm::begin(['id' => 'create-new-service-form']); ?>

        <?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'description')->textInput() ?>
        <?= $form->field($model, 'price')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Create New Service', ['class' => 'btn btn-block btn-success', 'name' => 'configure-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
