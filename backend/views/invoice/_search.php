<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\InvoiceSearch */
/* @var $form yii\widgets\ActiveForm */
$id = Yii::$app->request->get('id');
?>

<div class="invoice-search">

    <?php $form = ActiveForm::begin([
        'action' => ['list?id='.$id],
        'method' => 'get',
    ]); ?>

  <?= $form->field($model, 'invoice_global_search',[
     ])->textInput()->input('invoice_global_search', ['placeholder' => "ID,CONTAINER NO,AR NO,TOTAL AMOUNT,PAID AMOUNT
"]); ?> 
   

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'is_deleted') ?>

    <?php // echo $form->field($model, 'currency') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
