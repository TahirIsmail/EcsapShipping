<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DockReceipt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dock-receipt-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'export_id')->textInput() ?>

    <?= $form->field($model, 'awb_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'export_reference')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'forwarding_agent')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'domestic_routing_insctructions')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pre_carriage_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'place_of_receipt_by_pre_carrier')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'exporting_carrier')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'final_destination')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'loading_terminal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'container_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'number_of_packages')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'auto_recieving_date')->textInput() ?>

    <?= $form->field($model, 'auto_cut_off')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vessel_cut_off')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sale_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
