<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Pricing */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pricing-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
    <div class="col-md-6">
    <?php
 
       
     echo   $form->field($model, 'upload_file')->widget(FileInput::classname(), [
            'options' => [ 'multiple' => false],
            'pluginOptions' => [
                'previewFileType' => 'image',
               'allowedFileExtensions' => ['pdf'],
              //'allowedFileExtensions' => ['jpg', 'gif', 'png', 'bmp'],
              'showUpload' => true,
              'initialPreview' => [
                $model->upload_file ? Html::img(Yii::$app->request->baseUrl . '/uploads/' . $model->upload_file) : null, // checks the models to display the preview
            ],
                'overwriteInitial' => true,
            ],
        ]);
        ?>
   </div>
    <div class="col-md-6">
    <?=
    $form->field($model, 'month')->widget(DatePicker::className(),[
                        'options' => ['placeholder' => 'Select Price Month ...'],
                        'pluginOptions' => [
                            'startView'=>'year',
                        'minViewMode'=>'months',
                        'format' => 'M-yyyy'
                        ]
                       
                ])
       
?>  
        
   </div>
   </div>

    <div class="row">
    <div class="col-md-6">
    <?php
echo $form->field($model, 'pricing_type')->widget(Select2::classname(), [
  'data' => common\models\Lookup::$pricing_type,
  'theme' => Select2::THEME_BOOTSTRAP,
  'options' => ['placeholder' => 'Select a pricing type ...'],
  'pluginOptions' => [
      'allowClear' => false
  ],
]);
         
            ?>
   </div>
    <div class="col-md-6">
    <?php
echo $form->field($model, 'status')->widget(Select2::classname(), [
  'data' => common\models\Lookup::$pricing_status_type,
  'theme' => Select2::THEME_BOOTSTRAP,
  'options' => ['placeholder' => 'Select a status of rates ...'],
  'pluginOptions' => [
      'allowClear' => false
  ],
]);
         
            ?>
   </div>
   </div>
   <div class="row">
    <div class="col-md-10">
    <?= $form->field($model, 'description')->textarea(['rows'=>'6']) ?>
   </div>
    <div class="col-md-2">
   
   </div>
   </div>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
