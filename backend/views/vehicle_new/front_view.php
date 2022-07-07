<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii2assets\printthis\PrintThis;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $model common\models\Vehicle */


?>

<div class="vehicle-view from-frontend">
<div class="white-box">
    <h1><?php //Html::encode($this->title) ?></h1>
    <p>
  
    
    <?php
    Modal::begin([
       
        'id'=>'modal',
        'size'=>'modal-lg',
    ]);
    
    echo '<div id="modalContent"></div>';
    
    Modal::end(); ?>
           <?php
    Modal::begin([

        'id' => 'modal-report',
        'size' => 'modal-lg',
    ]);

    echo '<div id="modalContentreport"></div>';

    Modal::end();
    ?>

    <div class="row">
    <div class="col-md-6">
    <h3>Vehicle Details</h3>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          //  'id',
        [
          'label'=>'Vehicle',
          'value'=>function($model)
          {
            return $model->year.' '.$model->make.' '.$model->model;
          },
          

        ],
       
            'color',
       
          
            'vin',
            [
                'label' => 'keys',
                'format' => 'raw',
                'value' => function($model) {
                    if($model->keys == 1){
                        return 'Yes';
                    }else{
                        return 'No';
                        
                }
                },
            ],
       
            'lot_number',
      
            //'location',
            [
                'attribute'=>'location',
                'value'=>function($model){
                    return isset(\common\models\Lookup::$location[$model->location])?\common\models\Lookup::$location[$model->location]:$model->location;
                }
            ],
        
        ],

    ])

     ?>
     <h3>Towing Informtion</h3>
     <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          //  'id',

  
  
           
            'towingRequest.towing_request_date',
            'towingRequest.pickup_date',
    
       
         
        
        ],
    ]) ?>
    </div>
     <div class="col-md-6">

        <h3>Container  Details</h3>
    <?php
    if($model->is_export){
      $export_id = \common\models\VehicleExport::find()->where(['vehicle_id' => $model->id])->one();
      $export_detail = \common\models\Export::find()->where(['id' => $export_id->export_id])->one();
      ?>
    <table id="w3" class="table table-striped table-bordered detail-view"><tbody>
    <tr><th>Export Date</th><td><?= $export_detail->export_date?></td></tr>
    <tr><th>Booking Number</th><td><?= $export_detail->booking_number?></td></tr>
 
    <tr><th>Container Number</th><td><?= $export_detail->container_number?></td></tr>
    <tr><th>Destination Port</th><td><?= $export_detail->destination?></td></tr>
       <tr><th>ETA</th><td><?= $export_detail->eta?></td></tr>
      <tr><th>Loading Date</th><td><?= $export_detail->loading_date?></td></tr>
    
    </tbody>
    </table>
    <?php }else{?>
Not Exported;
    <?php }?>


     
    </div>
    <div class="col-md-6">
          <?php
                echo Html::a('<i class="fa fa-download"></i> Download Vehicle Images', ['/vehicle/download-images', 'id' => $model->id], [
                    'class' => 'btn btn-primary from-frontend-button',
                    'target' => '_blank',
                    'data-toggle' => 'tooltip',
                    'title' => 'Will send the download the images'
                ]);
                ?>
    </div>
    <div class="row">
    <div class="col-md-12" style="text-align: center;">

    <h4>Vehicle Images Gallery</h4>
    <?php

   
     $items = array();
     $saj =array();
    foreach($model->images as $gallery){
      
       
      $saj[] = [
        'url' => \yii\helpers\Url::to('@web/uploads/'.$gallery->name, true),
        'src' => \yii\helpers\Url::to('@web/uploads/'.$gallery->thumbnail, true),
        'options' => array('title' => 'Camposanto monumentale (inside)')
      ];
 
  } 
  // var_dump($saj);  
  $items = $saj; 
    

?>
<?= dosamigos\gallery\Gallery::widget(['items' => $items]);?>
</div>
    </div>
    </div>