<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\VehicleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehicle-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
<div class="row">
        <div class="col-md-6">
        <?= $form->field($model, 'vehicle_global_search',[
            ])->textInput()->input('vehicle_global_search', ['placeholder' => "CUSTOMER NAME,VIN,LOT NO,MODEL,MAKE,COLOR"]); ?> 
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'notes_status')->widget(Select2::classname(), [
    'data' => common\models\Lookup::$notes_status,
    'theme' => Select2::THEME_BOOTSTRAP,
    'options' => ['placeholder' => 'Select a status ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>
        </div>
        <div class="col-md-3">
            <label class="control-label" style="display:block;">&nbsp;</label>
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::button('Export Excel', ['class' => 'btn btn-success', 'id' => 'exportExcel']) ?>
        </div>
</div>

    <?php // echo $form->field($model, 'make') ?>

    <?php // echo $form->field($model, 'vin') ?>

    <?php // echo $form->field($model, 'weight') ?>

    <?php // echo $form->field($model, 'value') ?>

    <?php // echo $form->field($model, 'license_number') ?>

    <?php // echo $form->field($model, 'towed_from') ?>

    <?php // echo $form->field($model, 'lot_number') ?>

    <?php // echo $form->field($model, 'towed_amount') ?>

    <?php // echo $form->field($model, 'storage_amount') ?>

    <?php // echo $form->field($model, 'check_number') ?>

    <?php // echo $form->field($model, 'additional_charges') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'customer_user_id') ?>

    <?php // echo $form->field($model, 'towing_request_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'is_deleted')->checkbox() ?>

    <?php ActiveForm::end(); ?>

</div>