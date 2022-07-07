<?php
use yii\helpers\Html;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-form">

   <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],
    'id' => 'invoice-form',
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
    ]); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6" style="margin-bottom:10px; ">
                      <label>Container AR Number</label>
                      <?php
                        echo Select2::widget([
                                'model' => $model,
                                'attribute' => 'export_id',
                                // 'id' => 'consignee-customer_user_id',
                                'value' => $model->export_id,
                                'initValueText' => isset($model->export->ar_number) ? $model->export->ar_number : $model->export_id,
                                'options' => ['placeholder' => 'Select Ar Number ...'],
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    //'autocomplete' => true,
                                    'ajax' => [
                                        'url' => '../export/allexport',
                                        'dataType' => 'json',
                                        'data' => new \yii\web\JsExpression('function(params) { return {q:params.term}; }'),
                                    ],
                                ],
                            ]);
                        ?>           
            </div>
            <div class="col-md-6">
                <label>Customer</label>
         
                <?php
                echo Select2::widget([
                    'model' => $model,
                    'attribute' => 'customer_user_id',
                    'data' => common\models\Consignee::getCustomer($model->customer_user_id),
                    'id' => 'account-type',
                    'options' => ['placeholder' => 'Select CUSTOMER NAME ...'],
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]);
                ?>
            </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <?= $form->field($model, 'total_amount')->textInput(); ?>
                    
                </div>
                <div class="col-md-6">
                <input id="guide_input" style="position: absolute; right: 0; z-index: 99; margin: 4px; margin-right: 20px; width: 15%;border:none;color:#ccc;text-align:right;" readonly="readonly" value="<?= $model->total_amount - $model->adjustment_damaged - $model->adjustment_storage - $model->adjustment_discount - $model->adjustment_other - $model->paid_amount; ?>" type="text">
                    <?= $form->field($model, 'paid_amount')->textInput(); ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <?= $form->field($model, 'adjustment_damaged')->textInput(); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'adjustment_storage')->textInput(); ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <?= $form->field($model, 'adjustment_discount')->textInput(); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'adjustment_other')->textInput(); ?>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-6">
                <?=
                    $form->field($model, 'upload_invoice')->widget(FileInput::classname(), [
                    'pluginOptions' => [
                        'allowedFileExtensions' => ['jpg', 'gif', 'png', 'bmp', 'pdf', 'jpeg'],
                        'showUpload' => true,
                        'initialPreview' => [
                            $model->upload_invoice ? Html::img(Yii::$app->request->baseUrl.'/uploads/'.$model->upload_invoice) : null, // checks the models to display the preview
                        ],
                        'overwriteInitial' => false,
                    ],
                ]);
                ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'note')->textarea(); ?>
                </div>
            </div>
     

            <div class="help-block help-block-error vehcle_not_found" style="color: #a94442;"></div>



<hr>
   <div class="col-md-offset-2 col-md-8">
                       <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary invoice-button']); ?>
    </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<script>
    $('input[type="text"]').keyup(function(){
        var inv_value = $('#invoice-total_amount').val();
        var storage_val= $('#invoice-adjustment_storage').val();
        var damaged_val = $('#invoice-adjustment_damaged').val();
        var discount_val= $('#invoice-adjustment_discount').val();
        var other_val= $('#invoice-adjustment_other').val();
        var paid_val= $('#invoice-paid_amount').val();
        $('#guide_input').val(inv_value - damaged_val - storage_val - discount_val - other_val - paid_val);
    })
</script>