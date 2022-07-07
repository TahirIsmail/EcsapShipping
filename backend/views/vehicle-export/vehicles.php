<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel common\models\VehicleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
          <?= GridView::widget([
        'dataProvider' => $dataProviders,
      //  'filterModel' => $searchModel,
        'columns' => [
          // 'id',  
            'year',
            'make',
            'model',
            'color',
            'vin',
            'lot_number',
            [
              'attribute'=>'company_name',
              'format'=>'html',
              'value'=>function($model){
                if(isset($model['customer_user_id'])){
                  $company = \common\models\Customer::findOne(['user_id'=>$model['customer_user_id']]);
                  if($company){
                    return $company->company_name;
                    //return "<a href='/customer/view?id=".$model['customer_user_id']."'>".$company->company_name."</a>";
                  }
                }
                
              }
            ],
           // 'model',
           // 'make',
  
         [
                                'header' => 'View Vehicle',
                                'format' => 'html',
                                'value' => function($model) {
                                    return "<div class='payment_button_lease_close' target='_blank'><a href='../vehicle/view?id=" . $model['id'] . "'  >Vehicle</a></div>";
                                }
                            ],

        ],
        
    ]);

    ?>
