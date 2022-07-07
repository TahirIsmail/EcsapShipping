<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\HoustanCustomCoverLetter */

$this->title = $model->export_id;
$this->params['breadcrumbs'][] = ['label' => 'Houstan Custom Cover Letters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="houstan-custom-cover-letter-view">

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
            'vehicle_location',
            'exporter_id',
            'exporter_type_issuer',
            'transportation_value',
            'exporter_dob',
            'ultimate_consignee_dob',
            'consignee',
            'notify_party',
            'menifest_consignee',
        ],
    ]) ?>

</div>
