<?php
   /* @var $this yii\web\View */
   /* @var $form yii\bootstrap\ActiveForm */
   /* @var $model \common\models\LoginForm */
   
   use yii\helpers\Html;
   use yii\bootstrap\ActiveForm;
   
   $this->title = 'Login';
   //$this->params['breadcrumbs'][] = $this->title;
   ?>
<div class="site-login">
   <div class="col-md-4 col-md-offset-4">
      <div class="panel panel-default">
         <div class="panel-heading">
            <h3 class="panel-title">Please sign in</h3>
         </div>
         <div class="panel-bodies">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <div class="row">
               <div class="col-md-12 " style="padding-bottom: 10px;">
                  <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12" style="padding-bottom: 10px;">
                  <?= $form->field($model, 'password')->passwordInput() ?>
               </div>
            </div>
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
            <div class="form-group">
               <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
            <div class="logo-login">
                    <img class="logo-img-login" src="../uploads/images/afglogonew.jpg" alt="logo image">
                  </div>
         </div>
      </div>
    
   </div>
</div>