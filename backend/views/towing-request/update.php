<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TowingRequest */

$this->title = 'Update Towing Request: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Towing Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="towing-request-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
