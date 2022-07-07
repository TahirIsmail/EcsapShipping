<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii2assets\printthis\PrintThis;
use yii\bootstrap\Modal;
use lavrentiev\widgets\toastr\Notification;

/* @var $this yii\web\View */
/* @var $model common\models\Vehicle */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="vehicle-view">
<div class="white-box">
    <h1><?php //Html::encode($this->title) ?></h1>
    <?php 

  
  if(Yii::$app->request->get('mailed')){
    if(Yii::$app->request->get('mailed') == true){
       Notification::widget([
    'type' => 'success',
    'title' => 'Thank you ',
    'message' => 'Your mail has been successfully sent'
]);

     }else{ 
Notification::widget([
    'type' => 'Sorry',
    'message' => 'There is some error while sending your mail'
]);
   }
   }
   
   ?>
    <p>
    <?php
                $user_id = Yii::$app->user->getId();
                $Role = Yii::$app->authManager->getRolesByUser($user_id);
                
                if (isset($Role['customer'])) {
                    
                } else {
                    ?>
                    <?= Html::button(Yii::t('app', 'Vehicle Condition Report'), ['value'=>Yii::$app->urlManager->createUrl('vehicle/conditionreport?id='.$model->id),'class' => 'btn btn-primary click_modal_report']) ?>
    <?= Html::button(Yii::t('app', 'Update'), ['value'=>Yii::$app->urlManager->createUrl('vehicle/update?id='.$model->id),'class' => 'btn btn-primary click_modal']) ?>
    <?= Html::button(Yii::t('app', 'Add New'), ['value'=>Yii::$app->urlManager->createUrl('vehicle/create'),'class' => 'btn btn-primary click_modal']) ?>
    
    
    
    <?php }
        if(isset($Role['super_admin'])){
            echo Html::a("Conversations",[''],[
                'value'=>Yii::$app->urlManager->createUrl('vehicle/notesmodal?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                'class'=>'click_modal_report grid-action btn btn-primary click_modal_report',
                'data-toggle'=>'tooltip',
                'data-placement'=>'bottom',
                'title'=>'Update'
            ]);
        }
        ?>
    
     <?php //added on 22122020 | email button ?>
     
     <?= Html::button(Yii::t('app', '<i class="fa fa-envelope"></i> Mail'), ['value'=>Yii::$app->urlManager->createUrl('vehicle/emailtocustomer?id='.$model->id),'class' => 'btn btn-primary email_to_user']) ?>
    
    </p>
    
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
    <h3>Vehicle Informtion</h3>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          //  'id',
            [
                'attribute'=>'customerUser.company_name',
                // 'format'=>'html',
                // 'value'=>function($model){
                //     return "<a href='/customer/view?id=".$model->customer_user_id."'>".$model->customerUser->company_name."</a>";
                // }
            ],
            'hat_number',
            'year',
            'make',
            'model',
            'vin',
            'color',
            [
              'label' => 'KEYS',
              'format' => 'raw',
              'value' => function($model) {
                  if($model->keys == 1){
                      return 'Yes';
                  }else{
                      return 'No';
                      
              }
              },
          ],
            'weight',
            'value',
            'license_number',
            [
                'attribute'=>'lot_number',
                'label'=>'<span style="color:#0000ff;">LOT NUMBER</span>',
                'format'=>'html',
                'value'=>function($model){
                    return "<span style='color:#0000ff'>".$model->lot_number."</span>";
                }
            ],
            //'lot_number',
            'storage_amount',
            'check_number',
            'additional_charges',
       
            //'location',
            [
                'attribute'=>'location',
                'label' => 'LOCATION',
                'value'=>function($model){
                    return isset(\common\models\Lookup::$location[$model->location])?\common\models\Lookup::$location[$model->location]:$model->location;
                }
            ],
        
        ],
    ]) ?>
    <h3>Short Export  Informtion</h3>
    <?php
    if($model->is_export){
      $export_id = \common\models\VehicleExport::find()->where(['vehicle_id' => $model->id])->one();
      if($export_id){
      $export_detail = \common\models\Export::find()->where(['id' => $export_id->export_id])->one();
      ?>
    <table id="w3" class="table table-striped table-bordered detail-view"><tbody>
    <tr><th>Status</th><td>
        <?php
            $status = isset(\common\models\Lookup::$status[$model->status]) ? \common\models\Lookup::$status[$model->status] : $model->status;
            $vex = \common\models\VehicleExport::find()->where(['vehicle_id' => $model->id])->andWhere('vehicle_export_is_deleted != 1')->one();
            $med = \common\models\Export::find()->where(['id' => $vex->export_id])->one();

            if (!empty($med['eta']) && $med['eta'] <= date("Y-m-d") && $med['eta'] > $med['export_date']) {
                $status = 'ARRIVED';
            } else {
                if (!empty($med['export_date']) && $med['export_date'] < date("Y-m-d")) {
                    $status = 'SHIPPED';
                }
            }
            echo $status;
        ?>
        </td></tr>
    <tr><th>Export Date:</th><td><?= $export_detail->export_date?></td></tr>
    <tr><th>ETA:</th><td><?= $export_detail->eta?></td></tr>
    <tr><th>Booking Number:</th><td><?= $export_detail->booking_number?></td></tr>
    <tr><th>Seal Number:</th><td><?= $export_detail->seal_number?></td></tr>
    <tr><th>Container Number:</th><td><?= $export_detail->container_number?></td></tr>
    <tr><th>Destination:</th><td><?= $export_detail->destination?></td></tr>
    <tr><th>AR Number:</th><td><?= $export_detail->ar_number?></td></tr>
    
    </tbody>
    </table>
    <?php } }else{?>
Not Exported;
    <?php }?>
    </div>
     <div class="col-md-6">
     <h3>Towing Request Informtion</h3>
     <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          //  'id',
          [
            'label' => 'CONDITION',
            'attribute' => 'condition',
            'value' => function($model) {
                if(isset(\common\models\Lookup::$condition[$model->towingRequest->condition]))
                return  \common\models\Lookup::$condition[$model->towingRequest->condition];
            },
        ],
        [
          'label' => 'DAMAGED',
                      'attribute' => 'damaged',
          'value' => function($model) {
              if(isset(\common\models\Lookup::$normal_condition[$model->towingRequest->damaged]))
              return  \common\models\Lookup::$normal_condition[$model->towingRequest->damaged];
          },
      ],
      [
        'label' => 'PICTURES',
                    'attribute' => 'pictures',
        'value' => function($model) {
          if($model->towingRequest->pictures){
            return  'YES';
          }else{
            return 'NO';
          }
        },
    ],
    [
      'label' => 'TOWED',
                  'attribute' => 'towed',
      'value' => function($model) {
        if($model->towingRequest->towed){
          return  'YES';
        }else{
          return 'NO';
        }
      },
  ],
  'towed_from',
  'towed_amount',
  
  
           
            'towingRequest.towing_request_date',
            'towingRequest.pickup_date',
            'towingRequest.deliver_date',
            'towingRequest.note:ntext',
         
        
        ],
    ]) ?>
    
     <h3>Title Informtion</h3>
     <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          [
          
            'attribute' => 'towingRequest.title_type',
            'value' => function($model) {
                if(isset(\common\models\Lookup::$title_type[$model->towingRequest->title_type]))
                return  \common\models\Lookup::$title_type[$model->towingRequest->title_type];
            },
        ],
        [
            'attribute' => 'towingRequest.title_recieved',
            'value' => function($model) {
                 if($model->towingRequest->title_recieved){
                   return  'YES';
                 }else{
                   return 'NO';
                 }
            },
        ],
        'title_amount',
          'towingRequest.title_recieved_date',
          'towingRequest.title_number',
          'towingRequest.title_state',
        ],
    ]);
     ?><?php if (isset($Role['customer'])) { //commented to show export option to all users | qazi | 22122020
                //if(!true){
                    
                } elseif($model->is_export){?>

     <div class="col-md-6">

                                        <div class="price">
                                                                          <p>Current Export</p>
                                                                          <p><a class="btn btn-default" target="_" href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/export/view?id=<?php echo isset($export_detail->id)?$export_detail->id:''; ?>">View</a></p>
                                                                    </div>
                                        </div>
                                        <?php }
                                          else{
                                           
                                          }

                                        ?>
     
    </div>
    <div class="row">

    <div class="col-md-12" style="text-align: center;">
    <?php
        echo Html::a('<i class="fa fa-download"></i> Download Vehicle Images', ['/vehicle/download-images', 'id' => $model->id], [
            'class' => 'btn btn-primary',
            'target' => '_blank',
            'data-toggle' => 'tooltip',
            'title' => 'Will send the download the images'
        ]);
        ?>
    <h4>Vehicle Images Gallery</h4>
  
    <?php

   
     $items = array();
     $saj =array();
    foreach($model->images as $gallery){
      ?>
    <a data-fancybox="images" href="<?=\yii\helpers\Url::to('@web/../uploads/'.$gallery->name, true)?>">
        <img style="width:120px;height:120px;" class="img-fluid" src="<?= \yii\helpers\Url::to('@web/../uploads/'.$gallery->thumbnail, true) ?>">
    </a>
       <?php
      $saj[] = [
        'url' => \yii\helpers\Url::to('@web/../uploads/'.$gallery->name, true),
        'src' => \yii\helpers\Url::to('@web/../uploads/'.$gallery->thumbnail, true),
        'options' => array('title' => '')
      ];
 
  } 
  // var_dump($saj);  
  $items = $saj; 
    

?>
<div id="photo">
<?php // dosamigos\gallery\Gallery::widget(['items' => $items]);?>


<link rel="stylesheet" href="/assets_b/css/jquery.fancybox.css" />
<link rel="stylesheet" href="/assets_b/css/jquery.jqzoom.css" />
<script src="/assets_b/js/jquery.fancybox.js"></script>
<script src="/assets_b/js/jquery.jqzoom-core.js"></script>
<script>
    $('[data-fancybox="images"]').fancybox({
    // Options will go here
    thumbs : {
    autoStart   : true,
    hideOnClose : true
  },
  onComplete: function() {
                        $('.fancybox-image').jqzoom({
                                zoomType: 'innerzoom',
                                title: false,
                                lens: true,
                                showEffect: 'fadein',
                                hideEffect: 'fadeout'
                        })
        }
});
</script>
<script>
        $("body").on("click", ".notes_vehicle", function () {
           
           var formData = new FormData($('form')[0]);
 
           $.ajax({
               type: "POST",
               data:  formData,
              // data: "id="+id+"status+"+status,
               url: "<?php echo Yii::$app->getUrlManager()->createUrl('vehicle/notes'); ?>",
               success: function (test) {
                  // $('.show-notes').html(test);
               //    alert(test);
                   $('.modal-footer ul').prepend(test);
                   $("form").yiiActiveForm('resetForm');
               },
               error: function (exception) {
                   alert(exception);
               },
               cache: false,
       contentType: false,
       processData: false
           });

       });
</script>

<script>
    
    
    $("body").on("click", ".email_to_user", function () {
           
         var url = $(this).val(); 
         $('<a href="'+url+'" target="_blank"></a>')[0].click();

       });
</script>
</div>
</div>
    </div>
        <?php if (\Yii::$app->user->can('super_admin') || \Yii::$app->user->can('customer')) {
    ?>
    <div class="col-md-12">
    <h2>Attachments</h2>
       <?php foreach (\common\models\Documents::findAll(['vehicle_id' => $model->id]) as $key => $at) {
        ?>
    
            <a style="margin-right:30px;" target='_blank' href='/uploads/<?= $at->name; ?>'>Attachment - <?=$key + 1; ?></a>
       <?php
    } ?>
    </div>
    <?php
} ?>
    </div>
  