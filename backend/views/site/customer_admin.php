<?php

use kartik\select2\Select2;
use scotthuangzl\googlechart\GoogleChart;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */


$searchModel = new \common\models\VehicleSearch();
        $searchModel->id = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $user_id = Yii::$app->user->getId();
        $Role = Yii::$app->authManager->getRolesByUser($user_id);
        $all_vehicle = '';
        $vehicle_location_LA = '';
        $vehicle_location_GA = '';
        $vehicle_location_NY = '';
        $vehicle_location_TX = '';
        $vehicle_location_TX2 = '';
        $vehicle_location_NJ2 = '';
        $vehicle_location_CA = '';
        $all_export = '';
        $location = '';
        if (isset($Role['customer'])) {
            $all_vehicle = \common\models\Vehicle::all_vehicle_report_customer($user_id);
            $vehicle_location_LA = \common\models\Vehicle::all_vehicle_location_report_customer($location = '1', $user_id);
            $vehicle_location_GA = \common\models\Vehicle::all_vehicle_location_report_customer($location = '2', $user_id);
            $vehicle_location_NY = \common\models\Vehicle::all_vehicle_location_report_customer($location = '3', $user_id);
            $vehicle_location_TX = \common\models\Vehicle::all_vehicle_location_report_customer($location = '4', $user_id);
            $vehicle_location_TX2 = \common\models\Vehicle::all_vehicle_location_report_customer($location = '5', $user_id);
            $vehicle_location_NJ2 = \common\models\Vehicle::all_vehicle_location_report_customer($location = '6', $user_id);
            $vehicle_location_CA = \common\models\Vehicle::all_vehicle_location_report_customer($location = '7', $user_id);
            $all_export = \common\models\VehicleExport::all_export($user_id);
            $view = 'customer_index';
        } elseif (isset($Role['admin_LA'])) {
            $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '1');
            $view = 'customer_admin';
        } elseif (isset($Role['admin_GA'])) {
            $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '2');
            $view = 'customer_admin';
        } elseif (isset($Role['admin_NY'])) {
            $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '3');
            $view = 'customer_admin';
        } elseif (isset($Role['admin_TX'])) {
            $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '4');
            $view = 'customer_admin';
        } elseif (isset($Role['admin_TX2'])) {
            $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '5');
            $view = 'customer_admin';
        } elseif (isset($Role['admin_NJ2'])) {
            $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '6');
            $view = 'customer_admin';
        } elseif (isset($Role['admin_CA'])) {
            $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '7');
            $view = 'customer_admin';
        }
        elseif (isset($Role['sub_admin'])) {
            $all_vehicle_array = [];
            $all_vehicle_array[] = $vehicle_location_LA = \common\models\Vehicle::all_vehicle_location_report($location = '1');
            $all_vehicle_array[] = $vehicle_location_GA = \common\models\Vehicle::all_vehicle_location_report($location = '2');
            $all_vehicle_array[] = $vehicle_location_NY = \common\models\Vehicle::all_vehicle_location_report($location = '3');
            $all_vehicle_array[] = $vehicle_location_TX = \common\models\Vehicle::all_vehicle_location_report($location = '4');
            $all_vehicle = array();
            
            foreach ($all_vehicle_array as $vehicle_array) {
                foreach ($vehicle_array as $v_key => $v_count) {
                    if(isset($all_vehicle[$v_key])){
                        $all_vehicle[$v_key] += $v_count;
                    }else{
                        $all_vehicle[$v_key] = $v_count;
                    }
                }
            }

            $view = 'index_sub_admin';
        } 
        else {
            $all_vehicle = \common\models\Vehicle::all_vehicle_report();
            $vehicle_location_LA = \common\models\Vehicle::all_vehicle_location_report($location = '1');
            $vehicle_location_GA = \common\models\Vehicle::all_vehicle_location_report($location = '2');
            $vehicle_location_NY = \common\models\Vehicle::all_vehicle_location_report($location = '3');
            $vehicle_location_TX = \common\models\Vehicle::all_vehicle_location_report($location = '4');
            $vehicle_location_TX2 = \common\models\Vehicle::all_vehicle_location_report($location = '5');
            $vehicle_location_NJ2 = \common\models\Vehicle::all_vehicle_location_report($location = '6');
            $vehicle_location_CA = \common\models\Vehicle::all_vehicle_location_report($location = '7');
            $view = 'index';
        }
        if (Yii::$app->user->can('super_admin')) {
            $view = 'index';
        }

$this->title = 'AFG Global World Wide';
?>
<style>.empty{display:none;}</style>
<div class="site-index">
    <div class="body-content">

<div class="row">
   <div class="col-lg-2 col-sm-4 col-xs-12">
      <div class="card">
         <div class="card-body">
            <h5 class="card-title text-uppercase">DISPATCHED</h5>
            <div class="d-flex align-items-center no-block m-t-20 m-b-10">
               <h1><i class="ti-home text-info"></i>
                  <img class="car-img" src="<?=Yii::$app->homeUrl?>uploads/usa-important-images/trailer.png" alt="car image">
               </h1>
               <div class="ml-auto">
                  <h1 class="text-muted"> <?=$all_vehicle['car_on_way']?></h1>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-2 col-sm-4 col-xs-12">
      <div class="card">
         <div class="card-body">
            <h5 class="card-title text-uppercase">ON HAND</h5>
            <div class="d-flex align-items-center no-block m-t-20 m-b-10">
               <h1><i class="icon-tag text-purple"></i>
                  <img class="car-img" src="<?=Yii::$app->homeUrl?>uploads/usa-important-images/car-repair.png" alt="car image">
               </h1>
               <div class="ml-auto">
                  <h1 class="text-muted"> <?=$all_vehicle['on_hand']?></h1>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-2 col-sm-4 col-xs-12">
      <div class="card">
         <div class="card-body">
            <h5 class="card-title text-uppercase">Manifest</h5>
            <div class="d-flex align-items-center no-block m-t-20 m-b-10">
               <h1><i class="icon-basket text-danger"></i>
                  <img class="car-img" src="<?=Yii::$app->homeUrl?>uploads/usa-important-images/notebook.png" alt="car image">
               </h1>
               <div class="ml-auto">
                  <h1 class="text-muted"><?=$all_vehicle['manifest']?></h1>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-2 col-sm-4 col-xs-12">
      <div class="card">
         <div class="card-body">
            <h5 class="card-title text-uppercase">SHIPPED</h5>
            <div class="d-flex align-items-center no-block m-t-20 m-b-10">
               <h1><i class="ti-wallet text-success"></i>
                  <img class="car-img" src="<?=Yii::$app->homeUrl?>uploads/usa-important-images/cruise.png" alt="car image">
               </h1>
               <div class="ml-auto">
                  <h1 class="text-muted"><?=$all_vehicle['shipped']?></h1>
               </div>
            </div>
         </div>
      </div>
   </div>
      <div class="col-lg-2 col-sm-4 col-xs-12">
      <div class="card">
         <div class="card-body">
            <h5 class="card-title text-uppercase">Arrived</h5>
            <div class="d-flex align-items-center no-block m-t-20 m-b-10">
               <h1><i class="ti-wallet text-success"></i>
                  <img class="car-img" src="<?=Yii::$app->homeUrl?>uploads/usa-important-images/cruise.png" alt="car image">
               </h1>
               <div class="ml-auto">
                  <h1 class="text-muted"><?=$all_vehicle['arrived']?></h1>
               </div>
            </div>
         </div>

      </div>
   </div>
         <div class="col-lg-2 col-sm-4 col-xs-12">
      <div class="card">
         <div class="card-body">
            <h5 class="card-title text-uppercase">All</h5>
            <div class="d-flex align-items-center no-block m-t-20 m-b-10">
               <h1><i class="ti-wallet text-success"></i>
                  <img class="car-img" src="<?=Yii::$app->homeUrl; ?>uploads/usa-important-images/cruise.png" alt="car image">
               </h1>
               <div class="ml-auto">
                  <h1 class="text-muted"><?=$all_vehicle['arrived']+$all_vehicle['shipped']+$all_vehicle['manifest']+$all_vehicle['on_hand']+$all_vehicle['car_on_way']; ?></h1>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="white-box  no-padding-margin">
                    <div class="col-md-2">
                    </div>
                    <?php
                        Modal::begin([
                        
                            'id'=>'modal',
                            'size'=>'modal-lg',
                        ]);
                        
                        echo '<div id="modalContent"></div>';
                        
                        Modal::end();
                    ?>
                     <?php Pjax::begin();?>
                    <div class="col-md-8">
<?php echo $this->render('_search', ['model' => $searchModel]); ?>
                    </div>
                    <div class="col-md-2">
                    </div>
                    <hr>
                     <?=GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions'=>['class'=>'table table-striped table-bordered'],
    // 'filterModel' => $searchModel,
    'columns' => [
        [
            'headerOptions'=>['style'=>'width:200px;'],
            'attribute' => 'customer_user_id',
            'label' => 'CUSTOMER NAME',
            'value' => function ($model, $key, $index, $widget) {
                return $model->customerUser->company_name;
            },
            'filter' => Select2::widget([
                'model' => $searchModel,
                'attribute' => 'customer_user_id',
                'options' => ['placeholder' => 'Select Custoner Name ...'],
                'data' => common\models\Consignee::getCustomer(),
                // ... other params
            ]),
        ],
        //'hat_number',
        'container_number',
        // 'year',
        // 'make',
        // 'model',
        'vin',
        [
            'label' => 'STATUS',
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function ($model) {
                return \common\models\Lookup::$status_picked[$model->status];
            },
            'filter' => [1 => "ON HAND", 2 => "MANIFEST", 3 => "ON THE WAY", 4 => "SHIPPED", '' => "No Status"],
        ],

        'lot_number',
        [
            'header' => 'ALL VEHICLE',
            'format' => 'raw',
            'value' => function ($model) {
                return "<div class='payment_button_lease_close' ><a target='_blank' href='../vehicle/index?VehicleSearch[customer_user_id]=" . $model->customer_user_id . "'  >View</a></div>";
            },
        ],
        [
            'header' => 'ALL EXPORT',
            'format' => 'html',
            'value' => function ($model) {
                return Html::a('View', ['/export/index', 'ExportSearch' . '[customer_user_id]' => $model->customer_user_id], ['target' => '_blank']);
            },
        ],
        [
            'header' => 'CURRENT EXPORT',
            'format' => 'html',
            'value' => function ($model) {
                if ($model->container_number) {
                    $export_id = \common\models\Export::find()->where(['=', 'container_number', $model->container_number])->one();
                    if($export_id){
                        return Html::a('View', ['/export/view', 'id' => $export_id->id], ['target' => '_blank']);
                    }else{
                        return '-';
                    }
                    
                }
                return 'not exported';
            },
        ],
        [
            'header' => 'CURRENT VEHICLE',
            'format' => 'html',
            'value' => function ($model) {

                return Html::a('View', ['/vehicle/view', 'id' => $model->id], ['target' => '_blank']);
            },

        ],
        [
            'header' => 'CURRENT CUSTOMER',
            'format' => 'html',
            'value' => function ($model) {

                return Html::a('View', ['/customer/view', 'id' => $model->customer_user_id], ['target' => '_blank']);
            },

        ],
        ['class' => 'yii\grid\ActionColumn',
            'options'=>['class'=>'action-column'],
            'template'=>'{manifest}',
            'header'=>'DETAILS',
            'buttons'=>[
                'manifest'=>function($url,$model,$key){
                    $vehicle_export_id = \common\models\VehicleExport::find()->where(['=', 'vehicle_id', $key])->one();
                    if($vehicle_export_id){
                        $export_id = \common\models\Export::find()->where(['=', 'id', $vehicle_export_id->export_id])->one();
                        if($export_id){
                            $btn = Html::a("<button class='btn btn-primary'>MANIFEST</button>",[''],[
                                'value'=>Yii::$app->urlManager->createUrl('/export/manifestmodal?id='.$vehicle_export_id->export_id), //<---- here is where you define the action that handles the ajax request
                                'class'=>'click_modal grid-action',
                                'data-toggle'=>'tooltip',
                                'data-placement'=>'bottom',
                                'title'=>'Update'
                            ]);
                            $btn2 = Html::a("<button class='btn btn-primary'>BL</button>",[''],[
                                'value'=>Yii::$app->urlManager->createUrl('/export/ladingmodal?id='.$vehicle_export_id->export_id), //<---- here is where you define the action that handles the ajax request
                                'class'=>'click_modal grid-action',
                                'data-toggle'=>'tooltip',
                                'data-placement'=>'bottom',
                                'title'=>'Update'
                            ]);
                            return $btn.$btn2;
                        }else{
                            return '-';
                        }
                    }
                    
                }
            ]
        ],

    ],
]);

?>
                    <?php ActiveForm::end();?>
                    <?php Pjax::end();?>
                </div>
            </div>
        </div>





        <?php $user_id = Yii::$app->user->getId();?>
<?php // ?>
<span cursor="pointer" include="1" status="On hand" location="" class="labels label-danger all-status pull-right" id="1">Inventory Report</span>
        <div class="row">
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title" style="text-align: center;">Vehicle Status</h3>
                    <div class="vtabs">

                        <div class="tab-content" style="width: 79%;padding:0px;">
                            <div id="all" class="tab-pane active " aria-expanded="false">
                            <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>

                                            <th>SORT TYPE</th>
                                            <th>QUANTITY</th>
                                            <th>INVENTORY</th>
                                            <th>VIEW</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>

                                            <td>ALL VEHICLES</td>
                                            <td><?=$all_vehicle['all'];?></td>
                                            <td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl();?>/vehicle/index?VehicleSearch[location]=<?=$location?>" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                        <td>ON THE WAY</td>
                                            <td><?=$all_vehicle['car_on_way'];?></td>
                                            <td><span cursor="pointer" status="ON THE WAY" location="<?=$location?>" class="labels label-danger all-status" id="3">Report</span></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl();?>/vehicle/index?VehicleSearch[location]=<?=$location?>&VehicleSearch[status]=3" target="_blank">View</a></td>

                                        </tr>
                                        <tr>
                                        <td>ON HAND</td>
                                            <td><?=$all_vehicle['on_hand'];?></td>
                                            <td><span cursor="pointer" status="On Hand" location="<?=$location?>" class="labels label-danger all-status" id="1">Report</span></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl();?>/vehicle/index?VehicleSearch[location]=<?=$location?>&VehicleSearch[status]=1" target="_blank">View</a></td>

                                        </tr>
                                        <tr>
                                        <td>MANIFEST</td>
                                            <td><?=$all_vehicle['manifest'];?></td>
                                            <td><span cursor="pointer" status="Manifest" location="<?=$location?>" class="labels label-danger all-status" id="2">Report</span></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl();?>/vehicle/index?VehicleSearch[location]=<?=$location?>&VehicleSearch[status]=2" target="_blank">View</a></td>
                                        </tr>
                                        
                                        <tr>
                                        <td>SHIPPED </td>
                                            <td><?=$all_vehicle['shipped'];?></td>
                                            <td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl();?>/vehicle/index?VehicleSearch[location]=<?=$location?>&VehicleSearch[status]=4" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>ARRIVED</td>
                                            <td><?=$all_vehicle['arrived'];?></td>
                                            <td><span cursor="pointer" status="arrived" location="<?=$location?>" class="labels label-danger all-status" id="5">Report</span></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl();?>/vehicle/index?VehicleSearch[location]=<?=$location?>&VehicleSearch[status]=6" target="_blank">View</a></td>
                                        </tr>


                                        <td>WITH TITLE</td>
                                            <td><?=$all_vehicle['with_title'];?></td>
                                           <td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl();?>/vehicle/index/?VehicleSearch[location]=<?=$location?>&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>

                                        </tr>
                                        <tr>
                                        <td>W/O TITLE</td>
                                            <td><?=$all_vehicle['with_out_title'];?></td>
                                           <td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl();?>/vehicle/index?VehicleSearch[location]=<?=$location?>&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>

                                        </tr>

                                        <tr>
                                        <td>CAR TOWED</td>
                                            <td><?=$all_vehicle['towed'];?></td>
                                           <td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl();?>/vehicle/index?VehicleSearch[location]=<?=$location?>&VehicleSearch[towed]=1" target="_blank">View</a></td>

                                        </tr>
                                        <tr>
                                            <td>NOT TOWED</td>
                                            <td><?=$all_vehicle['not_towed'];?></td>
                                           <td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl();?>/vehicle/index?VehicleSearch[location]=<?=$location?>&VehicleSearch[towed]=0" target="_blank">View</a></td>


                                        <tr style='display:none;'>
                                        <td>TOWED WITH TITLE </td>
                                            <td><?=$all_vehicle['towed_with_title'];?></td>
                                           <td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl();?>/vehicle/index/?VehicleSearch[location]=<?=$location?>&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>

                                        </tr>
                                        <tr style='display:none;'>
                                        <td>TOWED W/O TITLE </td>
                                            <td><?=$all_vehicle['towed_with_out_title'];?></td>
                                           <td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl();?>/vehicle/index/?VehicleSearch[location]=<?=$location?>&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title">Order Status</h3>
                    <div id="morris-donut-chart" class="ecomm-donute">
                        <?php
                        echo GoogleChart::widget(array('visualization' => 'PieChart',
                            'data' => array(
                                array('Task', 'All Statuses'),
                                array('Manifest', (int) $all_vehicle['manifest']),
                                array('Car on Way', (int) $all_vehicle['car_on_way']),
                                array('Shipped', (int) $all_vehicle['shipped']),
                                array('On Hand', (int) $all_vehicle['on_hand']),
                            ),
                            'options' => array('title' => 'All', 'chartArea' => ['left' => 50, 'top' => 0, 'width' => '100%', 'height' => '100%'], 'width' => 480,
                                'height' => 400, 'pieHole' => 0.4, 'colors' => ['#420e0e', '#b18b1d', '#000'], 'pieSliceText' => 'none', 'legend' => ['position' => 'right'])));
                            ?>

                    </div>


                </div>
            </div>

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <?php 
                    echo Html::a('<i class="status-button inventory-status fa glyphicon glyphicon-hand-up"></i> Open as Pdf', ['/site/inventory-report', 'id' => -1], [
                        'class' => 'btn btn-primary',
                        'target' => '_blank',
                        'data-toggle' => 'tooltip',
                        'title' => 'Will open the generated PDF file in a new window',
                    ]);
                    echo Html::a('<i class="status-exel fa fa-download"></i> Download as Excel', ['/site/statusexel', 'id' => -1], [
                        'class' => 'btn btn-primary',
                        'target' => '_blank',
                        'data-toggle' => 'tooltip',
                        'title' => 'Will open the generated PDF file in a new window',
                    ]);
                ?>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Reports</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <script>

        $("body").delegate(".all-status", "click", function () {
            $("#myModal").modal();

       var id =    $(this).attr('id');
       var include_on_the_way = false;
       if($(this).attr('location')){
       var location =    $(this).attr('location');
       }else{
        var location = '';
       }
       if($(this).attr('include')){
            include_on_the_way =    $(this).attr('include');
        }
       var status = $(this).attr('status');
       var newHref = '';
       if(status=='On hand'){
            newHref="/site/inventory-report?id="+id+"&location="+location+"&status="+status+"&include="+include_on_the_way;
       }else{
            newHref="/site/statuspdf?id="+id+"&location="+location+"&status="+status+"&include="+include_on_the_way;
       }
       $('.modal-content .status-button').parent().attr('href',newHref);
       var newHref=$('.status-exel').parent().attr('href').split('?')[0]+"?id="+id+"&location="+location+"&status="+status+"&include="+include_on_the_way;
       $('.modal-content .status-exel').parent().attr('href',newHref);

            $.ajax({
                type: "POST",
                data:  {id:id, status:status,location: location,include:include_on_the_way },
               // data: "id="+id+"status+"+status,
                url: "<?php echo Yii::$app->getUrlManager()->createUrl('site/ajax'); ?>",
                success: function (test) {
                    $('.modal-body').html(test);
                },
                error: function (exception) {
                    alert(exception);
                }
            });

        });
    </script>