<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\HoustanCustomCoverLetterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="houstan-custom-cover-letter-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'export_id') ?>

    <?= $form->field($model, 'vehicle_location') ?>

    <?= $form->field($model, 'exporter_id') ?>

    <?= $form->field($model, 'exporter_type_issuer') ?>

    <?= $form->field($model, 'transportation_value') ?>

    <?php // echo $form->field($model, 'exporter_dob') ?>

    <?php // echo $form->field($model, 'ultimate_consignee_dob') ?>

    <?php // echo $form->field($model, 'consignee') ?>

    <?php // echo $form->field($model, 'notify_party') ?>

    <?php // echo $form->field($model, 'menifest_consignee') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
