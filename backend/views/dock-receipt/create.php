<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DockReceipt */

$this->title = 'Create Dock Receipt';
$this->params['breadcrumbs'][] = ['label' => 'Dock Receipts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dock-receipt-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
