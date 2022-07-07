<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TowingRequest */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Towing Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="towing-request-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'condition:boolean',
            'damaged:boolean',
            'pictures:boolean',
            'towed:boolean',
            'title_recieved:boolean',
            'title_recieved_date',
            'title_number',
            'title_state',
            'towing_request_date',
            'pickup_date',
            'deliver_date',
            'note:ntext',
        ],
    ]) ?>

</div>
