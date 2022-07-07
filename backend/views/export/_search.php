<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ExportSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    #submitBtn{
        float: left !important;
        margin-right: 10px !important;
        margin-top: 0 !important;
    }
</style>
<div class="export-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>


   <?= $form->field($model, 'export_global_search',[
     ])->textInput()->input('export_global_search', ['placeholder' => "Broker Name,Booking Number,Xtn Number,Seal Number,Container Number,Voyage"]); ?> 
   

    <?php // echo $form->field($model, 'eta') ?>

    <?php // echo $form->field($model, 'ar_number') ?>

    <?php // echo $form->field($model, 'xtn_number') ?>

    <?php // echo $form->field($model, 'seal_number') ?>

    <?php // echo $form->field($model, 'container_number') ?>

    <?php // echo $form->field($model, 'cutt_off') ?>

    <?php // echo $form->field($model, 'vessel') ?>

    <?php // echo $form->field($model, 'voyage') ?>

    <?php // echo $form->field($model, 'terminal') ?>

    <?php // echo $form->field($model, 'streamship_line') ?>

    <?php // echo $form->field($model, 'destination') ?>

    <?php // echo $form->field($model, 'itn') ?>

    <?php // echo $form->field($model, 'contact_details') ?>

    <?php // echo $form->field($model, 'special_instruction') ?>

    <?php // echo $form->field($model, 'container_type') ?>

    <?php // echo $form->field($model, 'port_of_loading') ?>

    <?php // echo $form->field($model, 'port_of_discharge') ?>

    <?php // echo $form->field($model, 'bol_note') ?>

    <?php // echo $form->field($model, 'is_deleted')->checkbox() ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary pull-left', 'id' => 'submitBtn']) ?>
        <?= Html::button('Export Excel', ['class' => 'btn btn-success', 'id' => 'exportExcel']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
