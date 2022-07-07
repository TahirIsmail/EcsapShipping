<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TowingRequest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="towing-request-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'condition')->checkbox() ?>

    <?= $form->field($model, 'damaged')->checkbox() ?>

    <?= $form->field($model, 'pictures')->checkbox() ?>

    <?= $form->field($model, 'towed')->checkbox() ?>

    <?= $form->field($model, 'title_recieved')->checkbox() ?>

    <?= $form->field($model, 'title_recieved_date')->textInput() ?>

    <?= $form->field($model, 'title_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title_state')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'towing_request_date')->textInput() ?>

    <?= $form->field($model, 'pickup_date')->textInput() ?>

    <?= $form->field($model, 'deliver_date')->textInput() ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
