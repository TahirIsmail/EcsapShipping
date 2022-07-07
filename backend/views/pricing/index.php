<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PricingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Pricings';
$this->title = 'Ocean Freight and Towing Fee'; //22122020 changed from pricing to rates
$this->params['breadcrumbs'][] = $this->title;
if (!Yii::$app->user->can('restrict-pricing')){
?>
<style>
    /* 22122020 */
.prices-table th, .prices-table td, .prices-table a{
    font-size:14px !important;
}
/* 22122020 */
.prices-table th{
    padding:10px !important;
}
</style>
<div class="pricing-index">
<div class="white-box">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php 
   $user_id = Yii::$app->user->getId();
   $Role = Yii::$app->authManager->getRolesByUser($user_id);
   if (!isset($Role['customer'])) { ?>
    <p>
        <?= Html::a('Create Pricing', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
   <?php }?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions'=>['class'=>'table table-striped table-bordered table-condensed prices-table'], //22122020
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

       
            [
                'header' => 'Download Price Detail',
              'format' => 'Html',
               'value' => function ($model) {
                    
                  
                    if ($model->upload_file) {
                        // return "<a href='".\yii\helpers\Url::to("@web/uploads/".$model->upload_file, true) ."'><img class='images_export' src='". \yii\helpers\Url::to("@web/uploads/invoice.png", true)."'></a>";
                        
                        return '<a href="'.\yii\helpers\Url::to('@web/pricing/view?id='.$model->id, true) .'"><img style="width:150px;" class="images_pricing" src="'. \yii\helpers\Url::to('@web/uploads/images/pdf-download-icon.gif', true).'"></a>';;
                   }
                },
            ],
            'month',
        //     [
        //     'attribute' => 'month',
        //     'value'=> function($model){
        //     return  date('M-Y', $model->month);


        //     }
        // ],
            [
    
                'attribute' => 'pricing_type',
                'value' => function($model) {
                    return isset(\common\models\Lookup::$pricing_type[$model->pricing_type])?\common\models\Lookup::$pricing_type[$model->pricing_type]:$model->pricing_type;
                },
            ],
            [
    
                'attribute' => 'status',
                'visible' => !isset($Role['customer']),
                'value' => function($model) {
                    return isset(\common\models\Lookup::$pricing_status_type[$model->status])?\common\models\Lookup::$pricing_status_type[$model->status]:$model->status;
                },
            ],
            //'created_by',
            //'updated_by',
            //'created_at',
            //'updated_at',

                     ['class' => 'yii\grid\ActionColumn',
                     'header'=>'Edit',
                        'options' => ['class' => 'action-column'],
                        'template' => '{update}  {view} {delete}',
                      
                                
                                'visibleButtons' => [
                                    'update' => Yii::$app->user->can('super_admin'),
                                    'delete' => Yii::$app->user->can('super_admin'),
                                 ]
                            
                        ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
</div>
<?php } ?>