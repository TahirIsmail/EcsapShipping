<?php 
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

    <div class="search-form">
 
<?php yii\widgets\Pjax::begin(['id' => 'search-form']) ?>
<?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>
 
  <?= $form->field( $this->params['searchModel'] , 'search_query') ?>
 
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>
 
<?php ActiveForm::end(); ?>
<?php yii\widgets\Pjax::end() ?>
</div>