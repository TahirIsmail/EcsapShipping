<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\TowingRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Towing Requests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="towing-request-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Towing Request', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'condition:boolean',
            'damaged:boolean',
            'pictures:boolean',
            'towed:boolean',
            //'title_recieved:boolean',
            //'title_recieved_date',
            //'title_number',
            //'title_state',
            //'towing_request_date',
            //'pickup_date',
            //'deliver_date',
            //'note:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
