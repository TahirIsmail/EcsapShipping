<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\HoustanCustomCoverLetter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="houstan-custom-cover-letter-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'export_id')->textInput() ?>

    <?= $form->field($model, 'vehicle_location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'exporter_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'exporter_type_issuer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'transportation_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'exporter_dob')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ultimate_consignee_dob')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'consignee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'notify_party')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'menifest_consignee')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
