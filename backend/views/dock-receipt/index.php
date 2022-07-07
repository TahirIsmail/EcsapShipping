<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\DockReceiptSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dock Receipts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dock-receipt-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dock Receipt', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'export_id',
            'awb_number',
            'export_reference',
            'forwarding_agent:ntext',
            'domestic_routing_insctructions:ntext',
            //'pre_carriage_by',
            //'place_of_receipt_by_pre_carrier',
            //'exporting_carrier',
            //'final_destination',
            //'loading_terminal',
            //'container_type',
            //'number_of_packages',
            //'by',
            //'date',
            //'auto_recieving_date',
            //'auto_cut_off',
            //'vessel_cut_off',
            //'sale_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
