<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\VehicleExportSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehicle-export-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="col-md-8">
   <?= $form->field($model, 'export_vehicle_global_search',[
     ])->textInput()->input('export_vehicle_global_search', ['placeholder' => "EXPORT ID, BROKER NAME, BOOKING NUMBER"]); ?> 
     <input type="hidden" name="sort" value="<?= Yii::$app->request->get('sort')?>" />
   </div>
   <div class="col-md-4">
        <?= $form->field($model, 'notes_status')->widget(Select2::classname(), [
                'data' => common\models\Lookup::$notes_status,
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Select a status ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
        ]);?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
