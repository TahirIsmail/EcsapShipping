<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model common\models\Consignee */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="consignee-form">

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],
    'layout' => 'horizontal',
     'id' => 'consignee-form',
      'fieldConfig' => [
        'horizontalCssClasses' => [
            'label' => 'col-sm-4',
           // 'offset' => 'col-sm-offset-2',
            'wrapper' => 'col-sm-8',
        ],
    ],
    
    ]); ?>
    
    <div class="row">
<div class="col-md-6">

<?php
                echo $form->field($model, 'customer_user_id')->widget(Select2::classname(), [
                    'attribute' => 'customer_user_id',
                    'id' => 'consignee-customer_user_id',
                    'value' => $model->customer_user_id,
                    'initValueText' => isset($model->customerUser->customer_name) ? $model->customerUser->company_name : "",
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Select current user level ...'],
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
<div class="col-md-6">
    <?php  if($model->isNewRecord){?>
    <label class="control-label col-sm-4" >Search Consignee</label>
<div class="col-sm-8">
<?php
echo Select2::widget([
                       'model' => $model,
                       'attribute' => 'customer_consignee',
                       'id' => 'consignee-customer_consignee',
                      // 'value' => $model->customer_user_id,
                       //'initValueText' => isset($model->customerUser->customer_name) ? $model->customerUser->company_name : "",
                       'options' => ['placeholder' => 'Search Consignee'],
                       'theme' => Select2::THEME_BOOTSTRAP,
                       'pluginOptions' => [
                           'allowClear' => true,
                           //'autocomplete' => true,
                           'ajax' => [
                               'url' => Yii::$app->urlManager->createUrl('consignee/customer-consignee'),
                               'dataType' => 'json',
                               'data' => new \yii\web\JsExpression('function(params) { var type = $("#consignee-customer_user_id").val();return {q:params.term,type:type}; }')
                           ],
                       ],
                   ]);       
            ?>
</div>
    <?php }?>
</div>
</div>
<div class="row">
<div class="col-md-6">
<?= $form->field($model, 'consignee_name')->textInput(['maxlength' => true]) ?>

</div>
<div class="col-md-6">
</div>
</div>
<div class="row">
<div class="col-md-6">
<?= $form->field($model, 'consignee_address_1')->textInput(['maxlength' => true]) ?>
</div>
<div class="col-md-6">
<?= $form->field($model, 'consignee_address_2')->textInput(['maxlength' => true]) ?>
</div>
</div>
<div class="row">
<div class="col-md-6">
<?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

</div>
<div class="col-md-6">
<?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>

</div>
</div>

<div class="row">
<div class="col-md-6">
<?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

</div>
<div class="col-md-6">
<?= $form->field($model, 'zip_code')->textInput(['maxlength' => true]) ?>

</div>
</div>
<div class="row">
<div class="col-md-6">
<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

</div>
<div class="col-md-6">
</div>
<hr>
</div>


<div class="row">
<div class="col-md-offset-2 col-md-8">
<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
</div>
        </div>


    <?php ActiveForm::end(); ?>

</div>
<script>
    $(document).on("change", "#consignee-customer_user_id", function () {
           ajaxcall("/index.php/account/getaccount", "#deposit-account_id", "#title,#deposit-branch-id,#branch-code", true)
       });



function ajaxcall(url, id, change_field, isChangeFieldArray)
   {
       $.ajax({
           type: "POST",
           dataType: "text",
           data: {
               branchId: $(id).find(":selected").val(),
           },
           url: url,
           success: function (result) {
               var resultArr;
               var changeFieldArray;
               if (isChangeFieldArray)
               {
                   resultArr = $.parseJSON(result);
                   changeFieldArray = change_field.split(',');
                   $(changeFieldArray[0]).val(resultArr['account_title']);
                   $(changeFieldArray[1]).val(resultArr['branch_name']);
                   $(changeFieldArray[2]).val(resultArr['branch_code']);

               }
               else
               {
                   $(change_field).val(result);
               }
               var type = resultArr['account_types_ID'];
               if (type == 3) {
                   $('.loan-input').show();
                   $("#amount-id,#interest").prop('readonly', true)
                   callLoanDetails(result);
               } else {
                   $('.loan-input').hide();
                   $('#interest').val(0);
                   $('#other_amount').val(0);
                   $("#amount-id,#interest").prop('readonly', false)
                   $('.loan-information').html('');
               }
           },
           error: function () {
               resultArr = [];
               changeFieldArray = [];

           }
       });
   }
    </script>
