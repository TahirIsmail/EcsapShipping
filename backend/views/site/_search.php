<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CustomerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-search">
<div class="row">
<div class="col-md-10">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); 
    $user_id = Yii::$app->user->getId();
    $Role =   Yii::$app->authManager->getRolesByUser($user_id);
    if(isset($Role['customer'])){
    ?>
 <?= $form->field($model, 'vehicle_global_search',[
     ])->textInput()->input('vehicle_global_search', ['placeholder' => "CUSTOMER NAME,VIN,LOT NUMBER,MODEL,MAKE,COLOR"])->label(false); 
   }else{
     ?> 
     <?= $form->field($model, 'vehicle_global_search',[
     ])->textInput()->input('global_search', ['placeholder' =>"CUSTOMER NAME,CONTAINER NO,VIN,LOT NO,MODEL,MAKE,COLOR"])->label(false);
   
      } ?>
</div>
<div class="col-md-2">
<?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn search-btn1','style'=>'margin-top:0px;']) ?>
</div>

</div>
    <?php // $form->field($model, 'company_name') ?>

    <?php // $form->field($model, 'address_line_1') ?>

    <?php // $form->field($model, 'address_line_2') ?>

    <?php // $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'zip_code') ?>

    <?php // echo $form->field($model, 'tax_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'is_deleted')->checkbox() ?>

    <div class="form-group">
     </div>

    <?php //ActiveForm::end(); ?>

</div>
