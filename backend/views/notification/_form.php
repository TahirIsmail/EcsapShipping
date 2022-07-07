<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use dosamigos\ckeditor\CKEditor;
/* @var $this yii\web\View */
/* @var $model common\models\Notification */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notification-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
<div class="col-md-8 col-md-offset-2">
<?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>
<?php // $form->field($model, 'message')->textarea(['maxlength' => true]) ?>
<?= $form->field($model, 'message')->widget(CKEditor::className(), [
            'options' => ['rows' => 6],
            'preset' => 'basic'
        ]) ?>
<?=
    $form->field($model, 'expire_date')->widget(DatePicker::className(),[
                        'options' => ['placeholder' => 'Select Loading date ...'],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                             'todayHighlight' => true,                             'autoclose'=>true,
                            'autoclose'=>true
                        ]
                       
                ])
       
?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>
</div>

</div>


   



    <?php ActiveForm::end(); ?>

</div>
