<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\HoustanCustomCoverLetter */

$this->title = 'Update Houstan Custom Cover Letter: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Houstan Custom Cover Letters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->export_id, 'url' => ['view', 'id' => $model->export_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="houstan-custom-cover-letter-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
