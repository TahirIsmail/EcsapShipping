<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ConsigneeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Consignees');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consignee-index">
 <div class="white-box">
    <div class="">
          <?php
    Modal::begin([
       
        'id'=>'modal',
        'size'=>'modal-lg',
       
    ]);
    
    echo '<div id="modalContent"></div>';
    
    Modal::end(); ?>
<div class="col-md-6">
        <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button(Yii::t('app', 'Create Consignee'),  ['value'=>Url::to('@web/consignee/create'),'class' => 'btn btn-primary click_modal']) ?>
    </p>
    </div>
            <?php Pjax::begin(); ?>
    <div class="col-md-6">
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
  

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
       'tableOptions'=>['class'=>'table table-striped table-bordered table-condensed'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'customerUser.customer_name',
            [
                'header'=>'CUSTOMER NAME',
                'format'=>'html',
                'value'=>function($model){
                    if(isset($model->customerUser->customer_name)){
                        return $model->customerUser->customer_name;
                        //return "<a href='".Yii::$app->urlManager->createUrl('/customer/view?id=' . $model->customer_user_id)."'>".$model->customerUser->customer_name."<a>";
                    }else{
                        return "-";
                    }
                    
                }
            ],
            'consignee_name',
            'consignee_address_1',
            'phone',
            ['class' => 'yii\grid\ActionColumn',
            'options'=>['class'=>'action-column'],
            'template'=>'{update}{view}{delete}',
            'buttons'=>[
                'update' => function($url,$model,$key){
                    $btn = Html::a("<span class='glyphicon glyphicon-pencil'></span>",[''],[
                        'value'=>Yii::$app->urlManager->createUrl('consignee/update?id='.$key), //<---- here is where you define the action that handles the ajax request
                        'class'=>'click_modal grid-action',
                        'data-toggle'=>'tooltip',
                        'data-placement'=>'bottom',
                        'title'=>'Update'
                    ]);
                    return $btn;
                }
            ],
            'visibleButtons' => [
                'delete' => Yii::$app->user->can('super_admin'),
                'update' => !Yii::$app->user->can('admin_view_only'),
             ]
        ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
        </div>

