<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DockReceiptSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dock-receipt-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'export_id') ?>

    <?= $form->field($model, 'awb_number') ?>

    <?= $form->field($model, 'export_reference') ?>

    <?= $form->field($model, 'forwarding_agent') ?>

    <?= $form->field($model, 'domestic_routing_insctructions') ?>

    <?php // echo $form->field($model, 'pre_carriage_by') ?>

    <?php // echo $form->field($model, 'place_of_receipt_by_pre_carrier') ?>

    <?php // echo $form->field($model, 'exporting_carrier') ?>

    <?php // echo $form->field($model, 'final_destination') ?>

    <?php // echo $form->field($model, 'loading_terminal') ?>

    <?php // echo $form->field($model, 'container_type') ?>

    <?php // echo $form->field($model, 'number_of_packages') ?>

    <?php // echo $form->field($model, 'by') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'auto_recieving_date') ?>

    <?php // echo $form->field($model, 'auto_cut_off') ?>

    <?php // echo $form->field($model, 'vessel_cut_off') ?>

    <?php // echo $form->field($model, 'sale_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
