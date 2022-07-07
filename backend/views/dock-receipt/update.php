<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DockReceipt */

$this->title = 'Update Dock Receipt: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Dock Receipts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->export_id, 'url' => ['view', 'id' => $model->export_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dock-receipt-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
