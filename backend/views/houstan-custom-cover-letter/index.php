<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\HoustanCustomCoverLetterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Houstan Custom Cover Letters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="houstan-custom-cover-letter-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Houstan Custom Cover Letter', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'export_id',
            'vehicle_location',
            'exporter_id',
            'exporter_type_issuer',
            'transportation_value',
            //'exporter_dob',
            //'ultimate_consignee_dob',
            //'consignee',
            //'notify_party',
            //'menifest_consignee',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
