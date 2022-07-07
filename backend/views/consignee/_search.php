<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\ConsigneeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="consignee-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="col-md-6">
    <?= $form->field($model, 'consignee_global_search',[])->textInput()->input('consignee_global_search', ['placeholder' => "CONSIGNEE NAME, CITY, STATE, COUNTRY"]); ?>
     </div>
     <div class="col-md-6">
     <?php
                echo $form->field($model, 'customer_user_id')->widget(Select2::classname(), [
                    'attribute' => 'customer_user_id',
                    'id' => 'consignee-customer_user_id',
                    'value' => $model->customer_user_id,
                    'initValueText' => isset($model->customerUser->customer_name) ? $model->customerUser->company_name : "",
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Select Customer ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    //'autocomplete' => true,
                    'ajax' => [
                        'url' => Yii::$app->urlManager->createUrl('customer/allcustomer'),
                        'dataType' => 'json',
                        'data' => new \yii\web\JsExpression('function(params) { return {q:params.term}; }')
                    ],
                ],
                ]);
            ?>
     </div>
    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'zip_code') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
