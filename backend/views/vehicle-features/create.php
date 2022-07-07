<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\VehicleFeatures */

$this->title = 'Create Vehicle Features';
$this->params['breadcrumbs'][] = ['label' => 'Vehicle Features', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicle-features-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
