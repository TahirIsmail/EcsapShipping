<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TowingRequestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="towing-request-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'condition')->checkbox() ?>

    <?= $form->field($model, 'damaged')->checkbox() ?>

    <?= $form->field($model, 'pictures')->checkbox() ?>

    <?= $form->field($model, 'towed')->checkbox() ?>

    <?php // echo $form->field($model, 'title_recieved')->checkbox() ?>

    <?php // echo $form->field($model, 'title_recieved_date') ?>

    <?php // echo $form->field($model, 'title_number') ?>

    <?php // echo $form->field($model, 'title_state') ?>

    <?php // echo $form->field($model, 'towing_request_date') ?>

    <?php // echo $form->field($model, 'pickup_date') ?>

    <?php // echo $form->field($model, 'deliver_date') ?>

    <?php // echo $form->field($model, 'note') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
