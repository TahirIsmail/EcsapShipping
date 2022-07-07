<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\VehicleCondition */

$this->title = 'Create Vehicle Condition';
$this->params['breadcrumbs'][] = ['label' => 'Vehicle Conditions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicle-condition-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
