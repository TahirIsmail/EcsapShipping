<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\DockReceipt */

$this->title = $model->export_id;
$this->params['breadcrumbs'][] = ['label' => 'Dock Receipts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dock-receipt-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->export_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->export_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'export_id',
            'awb_number',
            'export_reference',
            'forwarding_agent:ntext',
            'domestic_routing_insctructions:ntext',
            'pre_carriage_by',
            'place_of_receipt_by_pre_carrier',
            'exporting_carrier',
            'final_destination',
            'loading_terminal',
            'container_type',
            'number_of_packages',
            'by',
            'date',
            'auto_recieving_date',
            'auto_cut_off',
            'vessel_cut_off',
            'sale_date',
        ],
    ]) ?>

</div>
