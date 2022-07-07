<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ExportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Exports';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="export-index">
    <div class="white-box">
 <?php 
$customerName = '';
if (!isset($Role['customer'])  && isset($_GET['ExportSearch']['customer_user_id']) ) {
$customer = \common\models\Customer::findOne(['user_id'=>$_GET['ExportSearch']['customer_user_id']]);
    if($customer){
        echo 'CUSTOMER NAME:'. $customer->company_name;
    }
}
    ?>
    <div class="">
    
            <?php
    Modal::begin([
       
        'id'=>'modal',
        'size'=>'modal-lg',
    ]);
    
    echo '<div id="modalContent"></div>';
    
    Modal::end(); ?>
<div class="col-md-6">
<div class="col-md-6">
        <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button(Yii::t('app', 'Create Export'),  ['value'=>Url::to('@web/export/create'),'class' => 'btn btn-primary click_modal']) ?>
    </p>
    </div>
<div class="col-md-6">
<?php 
$customerName = '';
if (!isset($Role['customer'])  && isset($_GET['ExportSearch']['customer_user_id']) ) {
$customer = \common\models\Customer::findOne(['user_id'=>$_GET['ExportSearch']['customer_user_id']]);
if($customer){
    echo '<h1>Customer:</h1>'. '<b>'. $customer->company_name.'</b>';
}

}
    ?>
</div>
    
    </div>
          <?php Pjax::begin(); ?>
    <div class="col-md-6">
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
       'tableOptions'=>['class'=>'table table-striped table-bordered table-condensed'],
        'columns' => [
            ['class' => 'yii\grid\ActionColumn',
                    'options'=>['class'=>'action-column'],
                    'template'=>'{manifest}',
                    'header'=>'IMG',
                    'buttons'=>[
                        'manifest'=>function($url,$model,$key){
                            $icon="/uploads/images/no-image.png";
                            $imageObj = \common\models\ExportImages::find()->where(['=', 'export_id', $key])->one();
                            if($imageObj){
                                $icon = \yii\helpers\Url::to('@web/uploads/'.$imageObj->thumbnail, true);
                            }
                            $btn = Html::a("<img style='max-width:50px;' src='".$icon."' />",[''],[
                                'value'=>Yii::$app->urlManager->createUrl('/export/images?id='.$key), //<---- here is where you define the action that handles the ajax request
                                'class'=> 'click_modal grid-action',
                                'data-toggle'=>'tooltip',
                                'data-placement'=>'bottom',
                                'title'=>'Update'
                            ]);
                            return $btn;
                        }
                    ]
                ],



      ['label'  => 'Total Photos',
    'attribute' => 'title_type',
    'headerOptions' => array('style' => 'width:80px;'),
    'value' => function($model) {
      return count(\common\models\ExportImages::find()->where(['=', 'export_id', $model->id])->all());
    },
    'filter'        => common\models\Lookup::$title_type_front

     ],


           //'id',
            [
                'attribute'=>'loading_date',
                //'headerOptions'=>['style'=>'width:80px;'],
            ],
            [
                'attribute'=>'export_date',
              //  'headerOptions'=>['style'=>'width:80px;'],
            ],
            [
                'attribute'=>'eta',
              //  'headerOptions'=>['style'=>'width:80px;'],
            ],
            [
                'header'=>'Status',
                'format'=>'raw',
                'attribute' => 'status',
                'value'=>function($model){
                    $vx = \common\models\VehicleExport::find()->joinWith(['vehicle'])->where(['export_id' => $model->id])->andWhere('vehicle_export_is_deleted != 1')->one();
                    if(!empty($vx['vehicle']['status']) && ($vx['vehicle']['status'] == 2 || $vx['vehicle']['status'] == 4)) {
                        return \common\models\Lookup::$status[$vx['vehicle']['status']];
                    }

                    return '';
                },
                'filter' => [2 => 'MANIFEST', 4 => 'SHIPPED', 6 => 'ARRIVED'],
            ],
            'booking_number',
           
            [
                'attribute'=>'container_number',
                'format'=>'html',
                'value'=>function($model){
                    return Html::a($model->container_number, Yii::$app->urlManager->createUrl('/export/view?id='.$model->id."'>".$model->container_number));

                }
            ],


            [
                'attribute'=>'ar_number',
                'format'=>'html',
                'value'=>function($model){
                    return "<a href='/export/view?id=".$model->id."'>".$model->ar_number."</a>";
                }
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Manifest Date',
               // 'headerOptions'=>['style'=>'width:80px;'],
                'value' => function ($model) {
                    return date('Y-m-d', strtotime($model->created_at));
                },
            ],
            [
                'attribute'=>'port_of_loading',
            ],
            [
                'attribute'=>'port_of_discharge',
            ],
            [
                'attribute'=>'customer_name',
                'value'=>function($model){
                    $c =  \common\models\Customer::findOne(['user_id'=>$model->customer_user_id]);
                    if($c){
                        return $c->company_name;
                    }
                }
            ],
            [
                'attribute'=>'legacy_customer_id',
                'header'=>'CUST ID',
                'value'=>function($model){
                    $c =  \common\models\Customer::findOne(['user_id'=>$model->customer_user_id]);
                    if($c){
                        return $c->legacy_customer_id;
                    }
                }
            ],
            'terminal',
            'vessel',
            [
                'attribute' => 'container_type',
                'value' => function($model) {
                    $ct = common\models\Lookup::$container_type;
                    if($ct) {
                        return $ct[$model->container_type];
                    }
                }
            ],
            ['class' => 'yii\grid\ActionColumn',
            'options'=>['class'=>'action-column'],
            'template'=>'{manifest}',
            'header'=>'MANIFEST',
            'buttons'=>[
                'manifest'=>function($url,$model,$key){
                    $btn = Html::a("<span style='font-size: 1.3em; margin: auto; display: block; width: 15px;' class='glyphicon glyphicon-eye-open'></span>",[''],[
                        'value'=>Yii::$app->urlManager->createUrl('/export/manifestmodal?id='.$key), //<---- here is where you define the action that handles the ajax request
                        'class'=>'click_modal grid-action',
                        'data-toggle'=>'tooltip',
                        'data-placement'=>'bottom',
                        'title'=>'Update'
                    ]);
                    return $btn;
                }
            ]
            ],
            ['class' => 'yii\grid\ActionColumn',
            'options'=>['class'=>'action-column'],
            'template'=>'{update} {view} {delete}',
            'header'=>'EDIT',
            'buttons'=>[
                'update' => function($url,$model,$key){
                    $btn = Html::a("<span class='glyphicon glyphicon-pencil'></span>",[''],[
                        'value'=>Yii::$app->urlManager->createUrl('/export/update?id='.$key), //<---- here is where you define the action that handles the ajax request
                        'class'=>'click_modal grid-action',
                        'data-toggle'=>'tooltip',
                        'data-placement'=>'bottom',
                        'title'=>'Update'
                    ]);
                    return $btn;
                }
            ],
            'visibleButtons' => [
                'delete' => (Yii::$app->user->can('super_admin')||Yii::$app->user->can('sub_admin')),
                'update' => !Yii::$app->user->can('admin_view_only'),
             ]
        ],
        ],
        
    ]); ?>
    <?php Pjax::end(); ?>
</div>
</div>
    <div class="row" style="display: none">
        <form action="<?php echo Yii::$app->getUrlManager()->createUrl('export/export-excel'); ?>" id="exportExcelForm" method="get" target="_blank">

        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        // export report in excel
        $('#exportExcel').on('click', function (e) {
            e.preventDefault();
            ($('tr.filters').find(':input')).clone().appendTo($('#exportExcelForm'));
            $('#exportExcelForm').submit();
            $("#exportExcelForm").empty();
        });
    });
</script>