<?php
 use yii\grid\GridView;
 use yii\widgets\Pjax;
 use yii\helpers\Url;
 use yii\helpers\Html;
 use yii\widgets\ActiveForm;
 use scotthuangzl\googlechart\GoogleChart;
 use kartik\select2\Select2;


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
   
   /* @var $this yii\web\View */
  $user_id= Yii::$app->user->getId();
   $Role =   Yii::$app->authManager->getRolesByUser($user_id);
   ?>
   <style>td{font-weight:bold;;}.empty{display:none;}.white-box{padding:0px;}</style>
<div class="row">
   <div class="col-lg-2 col-sm-4 col-xs-12">
      <div class="card">
         <div class="card-body">
            <h5 class="card-title text-uppercase">DISPATCHED</h5>
            <div class="d-flex align-items-center no-block m-t-20 m-b-10">
               <h1><i class="ti-home text-info"></i>
                  <img class="car-img" src="<?= Yii::$app->homeUrl?>uploads/usa-important-images/trailer.png" alt="car image">
               </h1>
               <div class="ml-auto">
                  <h1 class="text-muted"> <?= $all_vehicle['car_on_way'] ?></h1>
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
                  <img class="car-img" src="<?= Yii::$app->homeUrl?>uploads/usa-important-images/car-repair.png" alt="car image">
               </h1>
               <div class="ml-auto">
                  <h1 class="text-muted"> <?= $all_vehicle['on_hand'] ?></h1>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-2 col-sm-24col-xs-12">
      <div class="card">
         <div class="card-body">
            <h5 class="card-title text-uppercase">Manifest</h5>
            <div class="d-flex align-items-center no-block m-t-20 m-b-10">
               <h1><i class="icon-basket text-danger"></i>
                  <img class="car-img" src="<?= Yii::$app->homeUrl?>uploads/usa-important-images/notebook.png" alt="car image">
               </h1>
               <div class="ml-auto">
                  <h1 class="text-muted"><?= $all_vehicle['manifest'] ?></h1>
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
                  <img class="car-img" src="<?= Yii::$app->homeUrl?>uploads/usa-important-images/cruise.png" alt="car image">
               </h1>
               <div class="ml-auto">
                  <h1 class="text-muted"><?= $all_vehicle['shipped'] ?></h1>
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
                  <img class="car-img" src="<?= Yii::$app->homeUrl?>uploads/usa-important-images/cruise.png" alt="car image">
               </h1>
               <div class="ml-auto">
                  <h1 class="text-muted"><?= $all_vehicle['arrived'] ?></h1>
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
<div class=""  >
   <div class="container-fluid">
      <div class="col-md-12 col-lg-12 col-sm-12">
         <div class="white-box">
            <div class="col-md-2">
            </div>
            <?php Pjax::begin(); ?>
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            <hr>
          
            <?= GridView::widget([
               'dataProvider' => $dataProvider,
               // 'filterModel' => $searchModel,
               'columns' => [
                      [
                      'attribute' => 'customer_user_id',
                      'label'=>'CUSTOMER NAME',
                      'value'=>function ($model, $key, $index, $widget) { 
                          return $model->customerUser->company_name;
                      },
                      'filter'=>Select2::widget([
                      'model' => $searchModel,
                      'attribute' => 'customer_user_id',
                     'options' => ['placeholder' => 'Select Custoner Name ...'],
                      'data' => common\models\Consignee::getCustomer(),
               // ... other params
               ]),
               ],
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
                  return  \common\models\Lookup::$status_picked[$model->status];
               },
               'filter'=>[1=>"ON HAND",2=>"MANIFEST",3=>"DISPATCHED",4=>"SHIPPED",''=>"No Status"],
               ],
               
               
               
                      'lot_number',
                                 [
                                       'header' => 'ALL VECHICLE',
                                       'format' => 'raw',
                                       'value' => function($model) {
                                           return "<div class='payment_button_lease_close' ><a target='_blank' href='../vehicle/index?VehicleSearch[customer_user_id]=" . $model->customer_user_id . "'  >View</a></div>";
                                       }
                                   ],
                                                                [
                                       'header' => 'ALL EXPORT',
                                       'format' => 'html',
                                       'value' => function($model) {
                                           return Html::a('View', ['/export/index','ExportSearch'.'[customer_user_id]'=> $model->customer_user_id], ['target'=>'_blank']) ;
                                       }
                                   ],
				   /*
                                   [
                                       'header' => 'CURRENT EXPORT',
                                       'format' => 'html',
                                       'value' => function($model) {
                                           if($model->container_number){
                                               $export_id = \common\models\Export::find()->where(['=','container_number',$model->container_number])->one();
                                               
                                               return Html::a('View', ['/export/view','id'=> $export_id->id], ['target'=>'_blank']) ;
                                           }
                                           return 'not exported';
                                       }
                                   ],
				   */
                                   [
                                       'header' => 'CURRENT VEHICLE',
                                       'format' => 'html',
                                       'value' => function($model) {
                                         
                                               return Html::a('View', ['/vehicle/view','id'=> $model->id], ['target'=>'_blank']) ;
                                           }
                                       
                                   ]
               
               ],
               ]);
               
               ?>
            <?php ActiveForm::end(); ?>
            <?php Pjax::end(); ?>
         </div>
      </div>
   </div>
</div>

<div class="container-fluid">
   <div id="custom_carousel" class="carousel slide" data-ride="carousel" data-interval="">
      <div class="controls">
         <ul class="nav">
            <li data-target="#custom_carousel" id='all-loc' class="active" data-slide-to="0">
               <?php $nextTab = 1;?>
               <a href="#">
                  <div class="box-body2">
                     <p class="box-text2">LOCATION: <strong style=''> ALL</strong> <br>
                        DISPATCHED <span class="states">
                        <?= $all_vehicle['car_on_way'] ?>
                        </span><br>
                       ON HAND <span class="states">
                        <?= $all_vehicle['on_hand'] ?>
                        </span><br>
                        SHIPPED<span class="states">
                        <?= $all_vehicle['shipped'] ?>
                        </span>
                     </p>
                  </div>
               </a>
            </li>
            <li data-target="#custom_carousel" id='la-loc'  data-slide-to="<?= $nextTab ?>">
               <?php $nextTab++;?>
               <a href="#">
                  <div class="box-body2">
                     <p class="box-text2">LOCATION: <strong style=''> LA</strong><br>
                        DISPATCHED<span class="states">
                        <?= $vehicle_location_LA['car_on_way'] ?>
                        </span><br>
                        ON HAND <span class="states">
                        <?= $vehicle_location_LA['on_hand'] ?>
                        </span><br>
                        SHIPPED<span class="states">
                        <?= $vehicle_location_LA['shipped'] ?>
                        </span>
                     </p>
                  </div>
               </a>
            </li>
            <li data-target="#custom_carousel" id='ga-loc' data-slide-to="<?= $nextTab ?>">
               <?php $nextTab++;?>
               <a href="#">
                  <div class="box-body2">
                     <p class="box-text2">LOCATION: <strong style=''> GA</strong><br>
                       DISPATCHED<span class="states">
                        <?= $vehicle_location_GA['car_on_way'] ?>
                        </span><br>
                        ON HAND <span class="states">
                        <?= $vehicle_location_GA['on_hand'] ?>
                        </span><br>
                        SHIPPED<span class="states">
                        <?= $vehicle_location_GA['shipped'] ?>
                        </span>
                     </p>
                  </div>
               </a>
            </li>
            <?php if(Yii::$app->user->can('customer_nj')){ ?>
            <li data-target="#custom_carousel" id='nj-loc' data-slide-to="<?= $nextTab ?>">
               <?php $nextTab++;?>
               <a href="#">
                  <div class="box-body2 box-text-right">
                     <p class="box-text2">LOCATION: <strong style=''> NY</strong><br>
                       DISPATCHED <span class="states">
                        <?= $vehicle_location_NY['car_on_way'] ?>
                        </span><br>
                        ON HAND <span class="states">
                        <?= $vehicle_location_NY['on_hand'] ?>
                        </span><br>
                        SHIPPED<span class="states">
                        <?= $vehicle_location_NY['shipped'] ?>
                        </span>
                     </p>
                  </div>
               </a>
            </li>
            <?php } ?>
            <?php if(Yii::$app->user->can('customer_tx')){ ?>
            <li data-target="#custom_carousel" id='tx-loc' data-slide-to="<?= $nextTab ?>">
               <?php $nextTab++;?>
               <a href="#">
                  <div class="box-body2 box-text-right">
                     <p class="box-text2">LOCATION: <strong style=''> TX</strong><br>
                        DISPATCHED<span class="states">
                        <?= $vehicle_location_TX['car_on_way'] ?>
                        </span><br>
                        ON HAND <span class="states">
                        <?= $vehicle_location_TX['on_hand'] ?>
                        </span><br>
                        SHIPPED<span class="states">
                        <?= $vehicle_location_TX['shipped'] ?>
                        </span>
                     </p>
                  </div>
               </a>
            </li>
            <?php } ?>
           
         </ul>
      </div>
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
         <div id='all-loc-result' class="item active">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-6">
                     <h3 class="">   ORDER OVERVIEW     </h3>
                     <?php
                        echo GoogleChart::widget(array('visualization' => 'PieChart',
                            'data' => array(
                                array('Task', 'All Statuses'),
                                array('Car on Way    '.(int) $all_vehicle['car_on_way'].'', (int) $all_vehicle['car_on_way']),
                                array('On Hand    '.(int) $all_vehicle['on_hand'].'', (int) $all_vehicle['on_hand']),
                                array('Shipped   '.(int) $all_vehicle['shipped'].'', (int) $all_vehicle['shipped']),
				array('Manifest   '.(int) $all_vehicle['manifest'].'', (int) $all_vehicle['manifest']),
                            ),
                          
                            'options' => array('title' => 'All','chartArea'=> ['left' => 50,'top' => 0,'width' => '100%','height' => '100%'],'width' => 480,
                        'height' => 400,'pieHole' => 0.4,'colors'=> ['#420e0e','#b18b1d','#000'],'pieSliceText' => 'none','legend'=>['position'=>'right'])));
                        ?>
                  </div>
                  <div class="col-md-6">
                     <h3 class=""> VEHICLE STATUS  </h3>
                     <table class="table table-striped table-bordered"  style="min-height: 447px;">
                        <thead>
                           <tr>
                              <th>SORT TYPE</th>
                              <th>QUANTITY</th>
                              <th>INVENTORY</th><th>PDF</th>
                              <th>VIEW</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td>ALL VEHICLES</td>
                              <td><?= $all_vehicle['all']; ?></td>
                              <td></td>
                              <td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>DISPATCHED</td>
                              <td><?= $all_vehicle['car_on_way']; ?></td>
                              <td><span cursor="pointer" status="DISPATCHED" user=<?=$user_id?> class="labels label-danger all-status" id="3">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=3&user=<?=$user_id?>&location=&status=DISPATCHED" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[status]=3" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>ON HAND</td>
                              <td><?= $all_vehicle['on_hand']; ?></td>
                              <td><span cursor="pointer" status="On Hand" user=<?=$user_id?> class="labels label-danger all-status" id="1">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=1&user=<?=$user_id?>&location=&status=On Hand" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                              
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[status]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>MANIFEST</td>
                              <td><?php echo $all_vehicle['manifest']; ?></td>
                              <td><span cursor="pointer" status="MANIFEST" user=<?=$user_id?> class="labels label-danger all-status" id="2">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=2&user=<?=$user_id?>&location=&status=MANIFEST" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                              <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[status]=2" target="_blank">View</a></td>
                            </tr>
                        
                           <tr>
                              <td>SHIPPED</td>
                              <td><?=$all_vehicle['shipped']; ?></td>
                              <td><span cursor="pointer" status="Shipped" class="labels label-danger all-status" id="4">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=4&location=&status=SHIPPED" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                              <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[status]=4" target="_blank">View</a></td>
                           </tr>

    <tr>
                              <td>ARRIVED</td>
                              <td><?php echo $all_vehicle['arrived']; ?></td>
                              <td><span cursor="pointer" status="arrived" user=<?=$user_id?> class="labels label-danger all-status" id="6">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=6&user=<?=$user_id?>&location=&status=arrived" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                              <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[status]=6" target="_blank">View</a></td>
                            </tr>

                           <tr>
                              <td>WITH TITLE</td>
                              <td><?= $all_vehicle['with_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>W/O TITLE</td>
                              <td><?= $all_vehicle['with_out_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>CAR TOWED</td>
                              <td><?= $all_vehicle['towed']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[towed]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>NOT TOWED</td>
                              <td><?= $all_vehicle['not_towed']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[towed]=0" target="_blank">View</a></td>
                           </tr>
                           <tr style='display:none;'>
                              <td>TOWED WITH TITLE</td>
                              <td><?= $all_vehicle['towed_with_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[towed]=1&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                           </tr>
                           <tr style='display:none;'>
                              <td>TOWED W/O TITLE </td>
                              <td><?= $all_vehicle['towed_with_out_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[towed]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div id='la-loc-result' class="item">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-6">
                     <h3 class="">   ORDER OVERVIEW     </h3>
                     <?php
                        echo GoogleChart::widget(array('visualization' => 'PieChart',
                            'data' => array(
                                array('Task', 'All Statuses'),
                                array('DISPATCHED    '.(int) $vehicle_location_LA['car_on_way'].'', (int) $vehicle_location_LA['car_on_way']),
                               array('ON HAND    '.(int) $vehicle_location_LA['on_hand'].'', (int) $vehicle_location_LA['on_hand']),
                                array('SHIPPED   '.(int) $vehicle_location_LA['shipped'].'', (int) $vehicle_location_LA['shipped']),
				array('Manifest   '.(int) $vehicle_location_LA['manifest'].'', (int) $vehicle_location_LA['manifest']),

                            ),
                            'options' => array('title' => 'LA','chartArea'=> ['left' => 50,'top' => 0,'width' => '100%','height' => '100%'],'width' => 480,
                        'height' => 400,'pieHole' => 0.4,'colors'=> ['#420e0e','#b18b1d','#000'],'pieSliceText' => 'none','legend'=>['legendShape'=>'square'])));
                        ?>
                  </div>
                  <div class="col-md-6">
                     <h3 class=""> VEHICLE STATUS  </h3>
                     <table class="table table-striped table-bordered" style="min-height: 447px;">
                        <thead>
                           <tr>
                              <th>SORT TYPE</th>
                              <th>QUANTITY</th>
                              <th>INVENTORY</th><th>PDF</th>
                              <th>VIEW</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td>ALL VEHICLES</td>
                              <td><?= $vehicle_location_LA['all']; ?></td>
                              <td></td>
                              <td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>CAR ON WAY</td>
                              <td><?= $vehicle_location_LA['car_on_way']; ?></td>
                              <td><span cursor="pointer" location="1" status="DISPATCHED" user=<?=$user_id?> class="labels label-danger all-status" id="3">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=3&user=<?=$user_id?>&location=1&status=DISPATCHED" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                       
                        <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1&VehicleSearch[status]=3" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>ON HAND/td>
                              <td><?= $vehicle_location_LA['on_hand']; ?></td>
                              <td><span cursor="pointer" location="1" status="On hand" user=<?=$user_id?> class="labels label-danger all-status" id="1">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=1&user=<?=$user_id?>&location=1&status=On Hand" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                           
                            <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1&VehicleSearch[status]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>MANIFEST</td>
                              <td><?php echo $vehicle_location_LA['manifest']; ?></td>
                              <td><span cursor="pointer" status="MANIFEST" user=<?=$user_id?> class="labels label-danger all-status" id="2">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=2&user=<?=$user_id?>&location=1&status=MANIFEST" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                              <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1&VehicleSearch[status]=2" target="_blank">View</a></td>
                            </tr>
                            <tr>
                              <td>PICKED UP</td>
                              <td><?php echo $all_vehicle['picked_up']; ?></td>
                              <td><span cursor="pointer" status="Picked Up" user=<?=$user_id?> class="labels label-danger all-status" id="5">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=5&user=<?=$user_id?>&location=1&status=Picked Up" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                              <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1&VehicleSearch[status]=5" target="_blank">View</a></td>
                            </tr>
                           <tr>
                              <td>On HAND </td>
                              <td><?= $vehicle_location_LA['shipped']; ?></td>
                              <td></td>
                              <td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1&VehicleSearch[status]=4" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>WITH TITLE</td>
                              <td><?= $vehicle_location_LA['with_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>W/O TITLE</td>
                              <td><?= $vehicle_location_LA['with_out_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>CAR TOWED</td>
                              <td><?= $vehicle_location_LA['towed']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1&?VehicleSearch[towed]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>NOT TOWED</td>
                              <td><?= $vehicle_location_LA['not_towed']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1" target="_blank">View</a></td>
                           </tr>
                           <tr style='display:none;'>
                              <td>Towed with title </td>
                              <td><?= $vehicle_location_LA['towed_with_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1" target="_blank">View</a></td>
                           </tr>
                           <tr style='display:none;'>
                              <td>TOWED W/O TITLE </td>
                              <td><?= $vehicle_location_LA['towed_with_out_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1" target="_blank">View</a></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div id='ga-loc-result' class="item">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-6">
                     <h3 class="">   ORDER OVERVIEW     </h3>
                     <?php
                        echo GoogleChart::widget(array('visualization' => 'PieChart',
                            'data' => array(
                                array('Task', 'All Statuses'),
                                array('Car on Way    '.(int) $vehicle_location_GA['car_on_way'].'', (int) $vehicle_location_GA['car_on_way']),
                                array('On Hand    '.(int) $vehicle_location_GA['on_hand'].'', (int) $vehicle_location_GA['on_hand']),
                                array('Shipped   '.(int) $vehicle_location_GA['shipped'].'', (int) $vehicle_location_GA['shipped']),
				array('Manifest   '.(int) $vehicle_location_GA['manifest'].'', (int) $vehicle_location_GA['manifest']),

                            ),
                            'options' => array('title' => 'GA','chartArea'=> ['left' => 50,'top' => 0,'width' => '100%','height' => '100%'],'width' => 480,
                        'height' => 400,'pieHole' => 0.4,'colors'=> ['#420e0e','#b18b1d','#000'],'pieSliceText' => 'none','legend'=>['legendShape'=>'square'])));
                        ?>
                  </div>
                  <div class="col-md-6">
                     <h3 class=""> VEHICLE STATUS  </h3>
                     <table class="table table-striped table-bordered" style="min-height: 447px;">
                        <thead>
                           <tr>
                              <th>Sort Type</th>
                              <th>Quantity</th>
                              <th>Inventory</th><th>Pdf</th>
                              <th>View</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td>ALL VEHICLES</td>
                              <td><?= $vehicle_location_GA['all']; ?></td>
                              <td></td>
                              <td></td>
                          <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>DISPATCHED</td>
                              <td><?= $vehicle_location_GA['car_on_way']; ?></td>
                              <td><span cursor="pointer" location="2" status="DISPATCHED" user=<?=$user_id?> class="labels label-danger all-status" id="3">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=3&user=<?=$user_id?>&location=2&status=DISPATCHED" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                             
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2&VehicleSearch[status]=3" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>ON HAND</td>
                              <td><?= $vehicle_location_GA['on_hand']; ?></td>
                              <td><span cursor="pointer" location="2" status="On hand" user=<?=$user_id?> class="labels label-danger all-status" id="1">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=1&user=<?=$user_id?>&location=2&status=On Hand" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                             
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2&VehicleSearch[status]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>MANIFEST</td>
                              <td><?php echo $vehicle_location_GA['manifest']; ?></td>
                              <td><span cursor="pointer" location="2" status="MANIFEST" user=<?=$user_id?> class="labels label-danger all-status" id="2">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=2&user=<?=$user_id?>&location=2&status=MANIFEST" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                              <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2&VehicleSearch[status]=2" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>PICKED UP</td>
                              <td><?php echo $vehicle_location_GA['picked_up']; ?></td>
                              <td><span cursor="pointer" location="2" status="Picked Up" user=<?=$user_id?> class="labels label-danger all-status" id="5">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=5&user=<?=$user_id?>&location=2&status=Picked Up" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                              <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2&VehicleSearch[status]=5" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>SHIPPED</td>
                              <td><?= $vehicle_location_GA['shipped']; ?></td>
                              <td></td>
                              <td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2&VehicleSearch[status]=4" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>WITH TITLE</td>
                              <td><?= $vehicle_location_GA['with_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>W/O TITLE</td>
                              <td><?= $vehicle_location_GA['with_out_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>CAR TOWED</td>
                              <td><?= $vehicle_location_GA['towed']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2&VehicleSearch[towed]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>NOT TOWED</td>
                              <td><?= $vehicle_location_GA['not_towed']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2&VehicleSearch[towed]=0" target="_blank">View</a></td>
                           </tr>
                           <tr style='display:none;'>
                              <td>Towed with title </td>
                              <td><?= $vehicle_location_GA['towed_with_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2" target="_blank">View</a></td>
                           </tr>
                           <tr style='display:none;'>
                              <td>TOWED W/O TITLE </td>
                              <td><?= $vehicle_location_GA['towed_with_out_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2" target="_blank">View</a></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <?php if(Yii::$app->user->can('customer_nj')){ ?>
         <div id='nj-loc-result' class="item">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-6">
                     <h3 class="">   ORDER OVERVIEW     </h3>
                     <?php
                        echo GoogleChart::widget(array('visualization' => 'PieChart',
                            'data' => array(
                                array('Task', '2'),
                                array('DISPATCHED    '.(int) $vehicle_location_NY['car_on_way'].'', (int) $vehicle_location_NY['car_on_way']),
                                array('ON HAND    '.(int) $vehicle_location_NY['on_hand'].'', (int) $vehicle_location_NY['on_hand']),
                                array('SHIPPED   '.(int) $vehicle_location_NY['shipped'].'', (int) $vehicle_location_NY['shipped']),
				array('Manifest   '.(int) $vehicle_location_NY['manifest'].'', (int) $vehicle_location_NY['manifest']),
                            ),
                            'options' => array('title' => 'NY','chartArea'=> ['left' => 50,'top' => 0,'width' => '100%','height' => '100%'],'width' => 480,
                                            'height' => 400,'pieHole' => 0.4,'colors'=> ['#420e0e','#b18b1d','#000'],'pieSliceText' => 'none','legend'=>['legendShape'=>'square'])));
                        ?>
                  </div>
                  <div class="col-md-6">
                     <h3 class=""> VEHICLE STATUS  </h3>
                     <table class="table table-striped table-bordered" style="min-height: 447px;">
                        <thead>
                           <tr>
                              <th>SORT TYPE</th>
                              <th>QUANTITY</th>
                              <th>INVENTORY</th><th>PDF</th>
                              <th>VIEW</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td>ALL VEHICLES</td>
                              <td><?= $vehicle_location_NY['all']; ?></td>
                              <td></td>
                              <td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>CAR DISPATCHED</td>
                              <td><?= $vehicle_location_NY['car_on_way']; ?></td>
                              <td><span cursor="pointer" location="3" status="DISPATCHED" user=<?=$user_id?> class="labels label-danger all-status" id="3">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=3&user=<?=$user_id?>&location=3&status=DISPATCHED" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                              
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[status]=3" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>ON HAND</td>
                              <td><?= $vehicle_location_NY['on_hand']; ?></td>
                              <td><span cursor="pointer" location="3" status="On hand" user=<?=$user_id?> class="labels label-danger all-status" id="1">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=1&user=<?=$user_id?>&location=3&status=On Hand" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                            
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[status]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>MANIFEST</td>
                              <td><?php echo $vehicle_location_NY['manifest']; ?></td>
                              <td><span cursor="pointer" location="3" status="MANIFEST" user=<?=$user_id?> class="labels label-danger all-status" id="2">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=2&user=<?=$user_id?>&location=3&status=MANIFEST" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                              <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[status]=2" target="_blank">View</a></td>
                            </tr>
                            <tr>
                              <td>Picked UP</td>
                              <td><?php echo $vehicle_location_NY['picked_up']; ?></td>
                              <td><span cursor="pointer" location="3" status="Picked Up" user=<?=$user_id?> class="labels label-danger all-status" id="5">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=5&user=<?=$user_id?>&location=3&status=Picked Up" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                              <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[status]=5" target="_blank">View</a></td>
                            </tr>
                           <tr>
                              <td>SHIPPED</td>
                              <td><?= $vehicle_location_NY['shipped']; ?></td>
                              <td></td>
                              <td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[status]=4" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>WITH TITLE</td>
                              <td><?= $vehicle_location_NY['with_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>W/O TITLE</td>
                              <td><?= $vehicle_location_NY['with_out_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>CAR TOWED</td>
                              <td><?= $vehicle_location_NY['towed']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[towed]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>NOT TOWED</td>
                              <td><?= $vehicle_location_NY['not_towed']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[towed]=0" target="_blank">View</a></td>
                           </tr>
                           <tr style='display:none;'>
                              <td>Towed with title </td>
                              <td><?= $vehicle_location_NY['towed_with_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                           </tr>
                           <tr style='display:none;'>
                              <td>TOWED W/O TITLE </td>
                              <td><?= $vehicle_location_NY['towed_with_out_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <?php } ?>
         <?php if(Yii::$app->user->can('customer_tx')){ ?>
         <div id='tx-loc-result' class="item">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-6">
                     <h3 class="">   ORDER OVERVIEW     </h3>
                     <?php
                        echo GoogleChart::widget(array('visualization' => 'PieChart',
                            'data' => array(
                                array('Task', 'All Statuses'),
                                array('DISPATCHED   '.(int) $vehicle_location_TX['car_on_way'].'', (int) $vehicle_location_TX['car_on_way']),
                                array('ON HAND    '.(int) $vehicle_location_TX['on_hand'].'', (int) $vehicle_location_TX['on_hand']),
                                array('SHIPPED   '.(int) $vehicle_location_TX['shipped'].'', (int) $vehicle_location_TX['shipped']),
				array('Manifest   '.(int) $vehicle_location_TX['manifest'].'', (int) $vehicle_location_TX['manifest']),

                            ),
                            'options' => array('title' => 'TX','chartArea'=> ['left' => 50,'top' => 0,'width' => '100%','height' => '100%'],'width' => 480,
                        'height' => 400,'pieHole' => 0.4,'colors'=> ['#420e0e','#b18b1d','#000'],'pieSliceText' => 'none','legend'=>['legendShape'=>'square'])));
                        ?>
                  </div>
                  <div class="col-md-6">
                     <h3 class=""> VEHICLE STATUS  </h3>
                     <table class="table table-striped table-bordered" style="min-height: 447px;">
                        <thead>
                           <tr>
                              <th>SORT TYPE</th>
                              <th>QUANTITY</th>
                              <th>INVENTORY</th><th>PDF</th>
                              <th>VIEW</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td>ALL VEHICLES</td>
                              <td><?= $vehicle_location_TX['all']; ?></td>
                              <td></td>
                              <td></td>
                             <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>CAR DISPATCHED</td>
                              <td><?= $vehicle_location_TX['car_on_way']; ?></td>
                              <td><span cursor="pointer" location="4" status="DISPATCHED" user=<?=$user_id?> class="labels label-danger all-status" id="3">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=3&user=<?=$user_id?>&location=4&status=DISPATCHED" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                          
                            <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&VehicleSearch[status]=3" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>ON HAND</td>
                              <td><?= $vehicle_location_TX['on_hand']; ?></td>
                              <td><span cursor="pointer" location="4" status="On hand" user=<?=$user_id?> class="labels label-danger all-status" id="1">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=1&user=<?=$user_id?>&location=4&status=On Hand" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                            
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&VehicleSearch[status]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>MANIFEST</td>
                              <td><?php echo $vehicle_location_TX['manifest']; ?></td>
                              <td><span cursor="pointer" location="4" status="MANIFEST" user=<?=$user_id?> class="labels label-danger all-status" id="2">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=2&user=<?=$user_id?>&location=4&status=Picked Up" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                              <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&VehicleSearch[status]=2" target="_blank">View</a></td>
                            </tr>
                            <tr>
                              <td>PICKED UP</td>
                              <td><?php echo $vehicle_location_TX['picked_up']; ?></td>
                              <td><span cursor="pointer" location="4" status="Picked Up" user=<?=$user_id?> class="labels label-danger all-status" id="5">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=5&user=<?=$user_id?>&location=4&status=Picked Up" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                              <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&VehicleSearch[status]=5" target="_blank">View</a></td>
                            </tr>
                           <tr>
                              <td>SHIPPED</td>
                              <td><?= $vehicle_location_TX['shipped']; ?></td>
                              <td></td>
                              <td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&VehicleSearch[status]=4" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>WITH TITLE</td>
                              <td><?= $vehicle_location_TX['with_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>W/O TITLE</td>
                              <td><?= $vehicle_location_TX['with_out_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>CAR TOWED</td>
                              <td><?= $vehicle_location_TX['towed']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&?VehicleSearch[towed]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>NOT TOWED</td>
                              <td><?= $vehicle_location_TX['not_towed']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&?VehicleSearch[towed]=0" target="_blank">View</a></td>
                           </tr>
                           <tr style='display:none;'>
                              <td>Towed with title </td>
                              <td><?= $vehicle_location_TX['towed_with_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                           </tr>
                           <tr style='display:none;'>
                              <td>TOWED W/O TITLE </td>
                              <td><?= $vehicle_location_TX['towed_with_out_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <?php } ?>
         <?php if(Yii::$app->user->can('customer_tx2')){ ?>
         <div id='tx2-loc-result' class="item">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-6">
                     <h3 class="">   ORDER OVERVIEW     </h3>
                     <?php
                        echo GoogleChart::widget(array('visualization' => 'PieChart',
                            'data' => array(
                                array('Task', 'All Statuses'),
                                array('DISPATCHED    '.(int) $vehicle_location_TX2['car_on_way'].'', (int) $vehicle_location_TX2['car_on_way']),
                                array('ON HAND    '.(int) $vehicle_location_TX2['on_hand'].'', (int) $vehicle_location_TX2['on_hand']),
                                array('SHIPPED   '.(int) $vehicle_location_TX2['shipped'].'', (int) $vehicle_location_TX2['shipped']),
				array('Manifest   '.(int) $vehicle_location_TX2['manifest'].'', (int) $vehicle_location_TX2['manifest']),

                            ),
                            'options' => array('title' => 'TX','chartArea'=> ['left' => 50,'top' => 0,'width' => '100%','height' => '100%'],'width' => 480,
                        'height' => 400,'pieHole' => 0.4,'colors'=> ['#420e0e','#b18b1d','#000'],'pieSliceText' => 'none','legend'=>['legendShape'=>'square'])));
                        ?>
                  </div>
                  <div class="col-md-6">
                     <h3 class=""> VEHICLE STATUS  </h3>
                     <table class="table table-striped table-bordered" style="min-height: 447px;">
                        <thead>
                           <tr>
                              <th>SORT TYPE</th>
                              <th>QUANTITY</th>
                              <th>INVENTORY</th><th>PDF</th>
                              <th>VIEW</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td>ALL VEHICLES</td>
                              <td><?= $vehicle_location_TX2['all']; ?></td>
                              <td></td>
                              <td></td>
                             <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=5" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>CAR ON WAY</td>
                              <td><?= $vehicle_location_TX2['car_on_way']; ?></td>
                              <td><span cursor="pointer" location="5" status="DISPATCHED" user=<?=$user_id?> class="labels label-danger all-status" id="3">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=3&user=<?=$user_id?>&location=5&status=DISPATCHED" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                          
                            <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=5&VehicleSearch[status]=3" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>ON HAND</td>
                              <td><?= $vehicle_location_TX2['on_hand']; ?></td>
                              <td><span cursor="pointer" location="5" status="On hand" user=<?=$user_id?> class="labels label-danger all-status" id="1">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=1&user=<?=$user_id?>&location=5&status=On Hand" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                            
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=5&VehicleSearch[status]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>MANIFEST</td>
                              <td><?php echo $vehicle_location_TX2['manifest']; ?></td>
                              <td><span cursor="pointer" location="5" status="MANIFEST" user=<?=$user_id?> class="labels label-danger all-status" id="2">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=2&user=<?=$user_id?>&location=5&status=Picked Up" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                              <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=5&VehicleSearch[status]=2" target="_blank">View</a></td>
                            </tr>
                            <tr>
                              <td>PICKED UP</td>
                              <td><?php echo $vehicle_location_TX2['picked_up']; ?></td>
                              <td><span cursor="pointer" location="5" status="Picked Up" user=<?=$user_id?> class="labels label-danger all-status" id="5">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=5&user=<?=$user_id?>&location=5&status=Picked Up" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                              <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=5&VehicleSearch[status]=5" target="_blank">View</a></td>
                            </tr>
                           <tr>
                              <td>SHIPPED</td>
                              <td><?= $vehicle_location_TX2['shipped']; ?></td>
                              <td></td>
                              <td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=5&VehicleSearch[status]=4" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>WITH TITLE</td>
                              <td><?= $vehicle_location_TX2['with_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=5&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>W/O TITLE</td>
                              <td><?= $vehicle_location_TX2['with_out_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=5&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>CAR TOWED</td>
                              <td><?= $vehicle_location_TX2['towed']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=5&?VehicleSearch[towed]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>NOT TOWED</td>
                              <td><?= $vehicle_location_TX2['not_towed']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=5&?VehicleSearch[towed]=0" target="_blank">View</a></td>
                           </tr>
                           <tr style='display:none;'>
                              <td>Towed with title </td>
                              <td><?= $vehicle_location_TX2['towed_with_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=5&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                           </tr>
                           <tr style='display:none;'>
                              <td>TOWED W/O TITLE </td>
                              <td><?= $vehicle_location_TX2['towed_with_out_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=5&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <?php } ?>
         <?php if(Yii::$app->user->can('customer_nj2')){ ?>
         <div id='nj2-loc-result' class="item">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-6">
                     <h3 class="">   ORDER OVERVIEW     </h3>
                     <?php
                        echo GoogleChart::widget(array('visualization' => 'PieChart',
                            'data' => array(
                                array('Task', 'All Statuses'),
                                array('DISPATCHED    '.(int) $vehicle_location_NJ2['car_on_way'].'', (int) $vehicle_location_NJ2['car_on_way']),
                                array('ON HAND    '.(int) $vehicle_location_NJ2['on_hand'].'', (int) $vehicle_location_NJ2['on_hand']),
                                array('SHIPPED   '.(int) $vehicle_location_NJ2['shipped'].'', (int) $vehicle_location_NJ2['shipped']),
				array('Manifest   '.(int) $vehicle_location_NJ2['manifest'].'', (int) $vehicle_location_NJ2['manifest']),

                            ),
                            'options' => array('title' => 'TX','chartArea'=> ['left' => 50,'top' => 0,'width' => '100%','height' => '100%'],'width' => 480,
                        'height' => 400,'pieHole' => 0.4,'colors'=> ['#420e0e','#b18b1d','#000'],'pieSliceText' => 'none','legend'=>['legendShape'=>'square'])));
                        ?>
                  </div>
                  <div class="col-md-6">
                     <h3 class=""> VEHICLE STATUS  </h3>
                     <table class="table table-striped table-bordered" style="min-height: 447px;">
                        <thead>
                           <tr>
                              <th>SORT TYPE</th>
                              <th>QUANTITY</th>
                              <th>INVENTORY</th><th>PDF</th>
                              <th>VIEW</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td>ALL VEHICLES</td>
                              <td><?= $vehicle_location_NJ2['all']; ?></td>
                              <td></td>
                              <td></td>
                             <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=6" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>CAR ON WAY</td>
                              <td><?= $vehicle_location_NJ2['car_on_way']; ?></td>
                              <td><span cursor="pointer" location="6" status="DISPATCHED" user=<?=$user_id?> class="labels label-danger all-status" id="3">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=3&user=<?=$user_id?>&location=6&status=DISPATCHED" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                          
                            <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=6&VehicleSearch[status]=3" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>ON HAND</td>
                              <td><?= $vehicle_location_NJ2['on_hand']; ?></td>
                              <td><span cursor="pointer" location="6" status="On hand" user=<?=$user_id?> class="labels label-danger all-status" id="1">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=1&user=<?=$user_id?>&location=6&status=On Hand" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                            
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=6&VehicleSearch[status]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>MANIFEST</td>
                              <td><?php echo $vehicle_location_NJ2['manifest']; ?></td>
                              <td><span cursor="pointer" location="6" status="MANIFEST" user=<?=$user_id?> class="labels label-danger all-status" id="2">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=2&user=<?=$user_id?>&location=6&status=Picked Up" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                              <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=6&VehicleSearch[status]=2" target="_blank">View</a></td>
                            </tr>
                            <tr>
                              <td>PICKED UP</td>
                              <td><?php echo $vehicle_location_NJ2['picked_up']; ?></td>
                              <td><span cursor="pointer" location="6" status="Picked Up" user=<?=$user_id?> class="labels label-danger all-status" id="5">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=5&user=<?=$user_id?>&location=6&status=Picked Up" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                              <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=6&VehicleSearch[status]=5" target="_blank">View</a></td>
                            </tr>
                           <tr>
                              <td>SHIPPED </td>
                              <td><?= $vehicle_location_NJ2['shipped']; ?></td>
                              <td></td>
                              <td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=6&VehicleSearch[status]=4" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>WITH TITLE</td>
                              <td><?= $vehicle_location_NJ2['with_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=6&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>W/O TITLE</td>
                              <td><?= $vehicle_location_NJ2['with_out_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=6&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>CAR TOWED</td>
                              <td><?= $vehicle_location_NJ2['towed']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=6&?VehicleSearch[towed]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>NOT TOWED</td>
                              <td><?= $vehicle_location_NJ2['not_towed']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=6&?VehicleSearch[towed]=0" target="_blank">View</a></td>
                           </tr>
                           <tr style='display:none;'>
                              <td>Towed with title </td>
                              <td><?= $vehicle_location_NJ2['towed_with_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=6&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                           </tr>
                           <tr style='display:none;'>
                              <td>TOWED W/O TITLE </td>
                              <td><?= $vehicle_location_NJ2['towed_with_out_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=6&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <?php } ?>
         <?php if(Yii::$app->user->can('customer_ca')){ ?>
         <div id='ca-loc-result' class="item">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-6">
                     <h3 class="">   ORDER OVERVIEW     </h3>
                     <?php
                        echo GoogleChart::widget(array('visualization' => 'PieChart',
                            'data' => array(
                                array('Task', 'All Statuses'),
                                array('DISPATCHED    '.(int) $vehicle_location_CA['car_on_way'].'', (int) $vehicle_location_CA['car_on_way']),
                                array('ON HAND    '.(int) $vehicle_location_CA['on_hand'].'', (int) $vehicle_location_CA['on_hand']),
                                array('SHIPPED   '.(int) $vehicle_location_CA['shipped'].'', (int) $vehicle_location_CA['shipped']),
				array('Manifest   '.(int) $vehicle_location_CA['manifest'].'', (int) $vehicle_location_CA['manifest']),

                            ),
                            'options' => array('title' => 'CA','chartArea'=> ['left' => 50,'top' => 0,'width' => '100%','height' => '100%'],'width' => 480,
                        'height' => 400,'pieHole' => 0.4,'colors'=> ['#420e0e','#b18b1d','#000'],'pieSliceText' => 'none','legend'=>['legendShape'=>'square'])));
                        ?>
                  </div>
                  <div class="col-md-6">
                     <h3 class=""> VEHICLE STATUS  </h3>
                     <table class="table table-striped table-bordered" style="min-height: 447px;">
                        <thead>
                           <tr>
                              <th>SORT TYPE</th>
                              <th>QUANTITY</th>
                              <th>INVENTORY</th><th>PDF</th>
                              <th>VIEW</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td>ALL VEHICLES</td>
                              <td><?= $vehicle_location_CA['all']; ?></td>
                              <td></td>
                              <td></td>
                             <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=7" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>CAR ON WAY</td>
                              <td><?= $vehicle_location_CA['car_on_way']; ?></td>
                              <td><span cursor="pointer" location="7" status="DISPATCHED" user=<?=$user_id?> class="labels label-danger all-status" id="3">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=3&user=<?=$user_id?>&location=7&status=DISPATCHED" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                          
                            <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=7&VehicleSearch[status]=3" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>ON HAND</td>
                              <td><?= $vehicle_location_CA['on_hand']; ?></td>
                              <td><span cursor="pointer" location="7" status="On hand" user=<?=$user_id?> class="labels label-danger all-status" id="1">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=1&user=<?=$user_id?>&location=7&status=On Hand" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                            
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=7&VehicleSearch[status]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>MANIFEST</td>
                              <td><?php echo $vehicle_location_CA['manifest']; ?></td>
                              <td><span cursor="pointer" location="7" status="MANIFEST" user=<?=$user_id?> class="labels label-danger all-status" id="2">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=2&user=<?=$user_id?>&location=7&status=Picked Up" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                              <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=7&VehicleSearch[status]=2" target="_blank">View</a></td>
                            </tr>
                            <tr>
                              <td>PICKED UP</td>
                              <td><?php echo $vehicle_location_CA['picked_up']; ?></td>
                              <td><span cursor="pointer" location="7" status="Picked Up" user=<?=$user_id?> class="labels label-danger all-status" id="5">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=5&user=<?=$user_id?>&location=7&status=Picked Up" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                              <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=7&VehicleSearch[status]=5" target="_blank">View</a></td>
                            </tr>
                           <tr>
                              <td>SHIPPED</td>
                              <td><?= $vehicle_location_CA['shipped']; ?></td>
                              <td></td>
                              <td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=7&VehicleSearch[status]=4" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>WITH TITLE</td>
                              <td><?= $vehicle_location_CA['with_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=7&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>W/O TITLE</td>
                              <td><?= $vehicle_location_CA['with_out_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=7&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>CAR TOWED</td>
                              <td><?= $vehicle_location_CA['towed']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=7&?VehicleSearch[towed]=1" target="_blank">View</a></td>
                           </tr>
                           <tr>
                              <td>NOT TOWED</td>
                              <td><?= $vehicle_location_CA['not_towed']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=7&?VehicleSearch[towed]=0" target="_blank">View</a></td>
                           </tr>
                           <tr style='display:none;'>
                              <td>Towed with title </td>
                              <td><?= $vehicle_location_CA['towed_with_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=7&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                           </tr>
                           <tr style='display:none;'>
                              <td>TOWED W/O TITLE </td>
                              <td><?= $vehicle_location_CA['towed_with_out_title']; ?></td>
                              <td></td><td></td>
                              <td><a href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=7&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <?php } ?>
         <!-- End Item -->
      </div>
      <!-- End Carousel Inner -->
   </div>
   <!-- End Carousel -->
</div>
</div>
</div>
<div class="modal fade" id="myModal" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <?php
               echo Html::a('<i class="status-button fa fa-file-pdf-o"></i> Open as Pdf', ['/site/statuspdfcustomer', 'id' => -1], [
                   'class' => 'btn btn-primary',
                   'target' => '_blank',
                   'data-toggle' => 'tooltip',
                   'title' => 'Will open the generated PDF file in a new window'
               ]);
               echo Html::a('<i class="status-exel fa fa-download"></i>Download as Excel', ['/site/statusexel', 'id' =>-1], [
                'class' => 'btn btn-primary',
                'target' => '_blank',
                'data-toggle' => 'tooltip',
                'title' => 'Will open the generated PDF file in a new window'
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
       $(document).ready(function(ev){
       $('#custom_carousel').on('slide.bs.carousel', function (evt) {
         $('#custom_carousel .controls li.active').removeClass('active');
         $('#custom_carousel .controls li:eq('+$(evt.relatedTarget).index()+')').addClass('active');
       })
   });
   $("body").delegate(".all-status", "click", function () {
       $("#myModal").modal();
   
       var id = $(this).attr('id');
       if($(this).attr('location')){
   var location =    $(this).attr('location');
   }else{
   var location = '';   
   }
       var status = $(this).attr('status');
       var user = $(this).attr('user');
       debugger;
       var newHref = $('.status-button').parent().attr('href').split('?')[0] + "?id="+id+"&user="+user+"&location="+location+"&status="+status;
       $('.status-button').parent().attr('href', newHref);
       var newHref = $('.status-exel').parent().attr('href').split('?')[0] + "?id="+id+"&user="+user+"&location="+location+"&status="+status;
       $('.status-exel').parent().attr('href', newHref);
       $.ajax({
           type: "POST",
           data: {id: id, status: status, user: user,location: location},
           // data: "id="+id+"status+"+status,
           url: "<?php echo Yii::$app->getUrlManager()->createUrl('site/ajaxcustomer'); ?>",
           success: function (test) {
               $('.modal-body').html(test);
           },
           error: function (exception) {
               alert(exception);
           }
       });
   
   });
</script>