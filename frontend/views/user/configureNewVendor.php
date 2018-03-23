<?php

/** @var \common\models\Sphere[] $spheres */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="row">
    <div class="container-fluid">
        <?php $form = ActiveForm::begin(['id' => 'configure-vendor-form']); ?>

        <?= $form->field($model, 'sphere')->dropDownList($spheres) ?>

        <div class="form-group">
            <?= Html::submitButton('Configure', ['class' => 'btn btn-block btn-success', 'name' => 'configure-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
