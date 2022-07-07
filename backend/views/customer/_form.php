<?php

use kartik\file\FileInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],
    'id' => 'customer-form',
    'enableClientValidation' => true,
    'options' => [
        'validateOnSubmit' => true,
        'class' => 'form',
    ],
    'layout' => 'horizontal',
    'fieldConfig' => [
        'horizontalCssClasses' => [
            'label' => 'col-sm-4',
            // 'offset' => 'col-sm-offset-2',
            'wrapper' => 'col-sm-8',
        ],
    ],
]);?>
       <div class="row">
    <div class="col-md-6">
        <?=$form->field($model, 'legacy_customer_id')->textInput(['maxlength' => true,'value'=>$model->customerNextID()])?>
   </div>
   <div class="col-md-6">
        <?=$form->field($model, 'email')->textInput(['maxlength' => true])?>
   </div>
   </div>
  <div class="row">
 <div class="col-md-6">
<?=$form->field($model, 'customer_name')->textInput(['maxlength' => true])?>
   </div>
   <div class="col-md-6">
<?=$form->field($model, 'company_name')->textInput(['maxlength' => true])?>


   </div>
   </div>
   <div class="row">
   <div class="col-md-6">
        <?=$form->field($model, 'phone')->textInput(['maxlength' => true])?>
   </div>
 <div class="col-md-6">
    <?=$form->field($model, 'phone_two')->textInput(['maxlength' => true])?>
   </div>
   </div>
   <div class="row">
 <div class="col-md-6">
 <?=$form->field($model, 'trn')->textInput(['maxlength' => true])?>

   </div>
   <div class="col-md-6">
   <?=$form->field($model, 'tax_id')->textInput(['maxlength' => true])?>
<?php //$form->field($model, 'password')->passwordInput() ?>
   </div>
   </div>
   <div class="row">
 <div class="col-md-6">
 <?php
if ($model->isNewRecord) {
    $model->status = '1';
}
?>
<?=$form->field($model, 'status')->checkbox()?>
   </div>
   <div class="col-md-6">
   <?=$form->field($model, 'fax')->textInput(['maxlength' => true])?>

   </div>
   </div>
   <div class="row">
 <div class="col-md-6">
<?=$form->field($model, 'address_line_1')->textInput(['maxlength' => true])?>
   </div>
   <div class="col-md-6">
<?=$form->field($model, 'address_line_2')->textInput()?>
   <?php //$form->field($model, 'address_line_2')->textInput(['maxlength' => true]) ?>
   </div>
   </div>

   <div class="row">
   <div class="col-md-6">

 <?=$form->field($model, 'country')->textInput(['maxlength' => true])?>
   </div>
   <div class="col-md-6">
 <?=$form->field($model, 'city')->textInput(['maxlength' => true])?>

   </div>
 <div class="col-md-6">
   <?=$form->field($model, 'state')->textInput(['maxlength' => true])?>
   </div>
   <div class="col-md-6">
   <?=$form->field($model, 'zip_code')->textInput(['maxlength' => true])?>
   </div>
    <div class="col-md-6">
        <?=$form->field($model, 'other_emails')->textarea(['rows'=>3,'placeholder'=>'abc@domain.com,xyz@abc.com'])?>
    </div>
    <div class="col-md-6">
        <?=$form->field($model, 'note')->textarea(['rows'=>3])?>
    </div>
<div class="row">
 <div class="col-md-10">
           <?php
if ($model->isNewRecord) {
    $all_images = '';
    $all_images_preview = [];
}

echo $form->field($model, 'uploads[]')->widget(FileInput::classname(), [
    'options' => ['multiple' => true],
    'pluginOptions' => [
        'previewFileType' => 'image',
        'allowedFileExtensions' => ['jpg', 'gif', 'png', 'bmp', 'jpeg', 'pdf'],
        //'allowedFileExtensions' => ['jpg', 'gif', 'png', 'bmp'],
        'showUpload' => true,
        'initialPreview' => $all_images,
        'overwriteInitial' => false,
        'initialPreviewConfig' => $all_images_preview,
        'overwriteInitial' => false,
        'showRemove' => true,
        'showPreview' => true,
        //'uploadUrl' => Url::to(['cases/upload']),
    ],
]);
?>
   </div>
   <div class="col-md-2">
   </div>


   <hr>
   <div class="col-md-offset-2 col-md-8">
        <?=Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary'])?>
    </div>
   </div>


    <?php ActiveForm::end();?>

</div>
