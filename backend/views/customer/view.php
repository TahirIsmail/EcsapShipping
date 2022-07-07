<?php
use lavrentiev\widgets\toastr\Notification;
use scotthuangzl\googlechart\GoogleChart;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
?>
<?php
$this->title = $model->user_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$user_id = Yii::$app->user->getId();
$Role = Yii::$app->authManager->getRolesByUser($user_id);
?>
<?php
if (Yii::$app->request->get('mailed')) {
    if (Yii::$app->request->get('mailed') == true) {
        Notification::widget([
            'type' => 'success',
            'title' => 'Thank you ',
            'message' => 'Your mail has been successfully sent',
        ]);
    } else {
        Notification::widget([
            'type' => 'Sorry',
            'message' => 'There is some error while sending your mail',
        ]);
    }
}
$user_id = $model->user_id;
?>
<div class="customer-view">
    <?php 
    if (isset($Role['super_admin'])) 
    {
        ?>
   <div class="row">
      <div class="col-lg-3 col-sm-6 col-xs-12">
         <div class="card">
            <div class="card-body">
               <h5 class="card-title text-uppercase">DISPATCHED</h5>
               <div class="d-flex align-items-center no-block m-t-20 m-b-10">
                  <h1><i class="ti-home text-info"></i>
                     <img class="car-img" src="<?=Yii::$app->homeUrl; ?>uploads/usa-important-images/trailer.png" alt="car image">
                  </h1>
                  <div class="ml-auto">
                     <h1 class="text-muted"> <?=$all_vehicle['car_on_way']; ?></h1>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-3 col-sm-6 col-xs-12">
         <div class="card">
            <div class="card-body">
               <h5 class="card-title text-uppercase">ON HAND</h5>
               <div class="d-flex align-items-center no-block m-t-20 m-b-10">
                  <h1><i class="icon-tag text-purple"></i>
                     <img class="car-img" src="<?=Yii::$app->homeUrl; ?>uploads/usa-important-images/car-repair.png" alt="car image">
                  </h1>
                  <div class="ml-auto">
                     <h1 class="text-muted"> <?=$all_vehicle['on_hand']; ?></h1>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-3 col-sm-6 col-xs-12">
         <div class="card">
            <div class="card-body">
               <h5 class="card-title text-uppercase">LOADED</h5>
               <div class="d-flex align-items-center no-block m-t-20 m-b-10">
                  <h1><i class="icon-basket text-danger"></i>
                     <img class="car-img" src="<?=Yii::$app->homeUrl; ?>uploads/usa-important-images/notebook.png" alt="car image">
                  </h1>
                  <div class="ml-auto">
                     <h1 class="text-muted"><?=$all_vehicle['manifest']; ?></h1>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-3 col-sm-6 col-xs-12">
         <div class="card">
            <div class="card-body">
               <h5 class="card-title text-uppercase">SHIPPED</h5>
               <div class="d-flex align-items-center no-block m-t-20 m-b-10">
                  <h1><i class="ti-wallet text-success"></i>
                     <img class="car-img" src="<?=Yii::$app->homeUrl; ?>uploads/usa-important-images/cruise.png" alt="car image">
                  </h1>
                  <div class="ml-auto">
                     <h1 class="text-muted"><?=$all_vehicle['shipped']; ?></h1>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
    <?php } ?>
   <div class="row">
        <?php 
        if (isset($Role['super_admin'])) 
        {
            ?>
            <div class="col-md-12">
                <div class="" >
                    <p>
                        <?=Html::button(Yii::t('app', 'Update'), ['value' => Yii::$app->urlManager->createUrl('customer/update?id='.$model->user_id), 'class' => 'btn btn-primary click_modal']); ?>
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="" style="">
                    <?=DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'customer_name',
                            'legacy_customer_id',

                            'company_name',
                            'user.email',
                            'address_line_1',
                            'address_line_2',

                            'phone',
                            'phone_two',
                            'city',
                        ],
                    ]); ?>
                </div>
            </div>
            <div class="col-md-6">
            <?=DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'state',
                    'country',
                    'zip_code',
                    'tax_id',
                    'trn',
                    'other_emails',
                    'note',
                ],
            ]); ?>
            </div>
            <div class="col-md-6">
                <h4 style="text-align: center;">Customer Details</h4>
                <table width="100%" class="customerDetails">
                    <thead>
                        <tr>
                            <th>All Container</th>
                            <th><a target="_blank" href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/export/index?ExportSearch[customer_user_id]=<?=$model->user_id; ?>">View</a></th>
                        </tr>
                        <tr>
                            <th>All Exports</th>
                            <th><a target="_blank" href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle-export/index?VehicleExportSearch[customer_user_id]=<?=$model->user_id; ?>">View</a></th>
                        </tr>
                        <tr>
                            <th>All Invoices</th>
                            <th><a target="_blank" href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/invoice/index?InvoiceSearch[customer_user_id]=<?=$model->user_id; ?>">View</a></th>
                        </tr>
                        <tr>
                            <th>Paid Invoices</th>
                            <th><a target="_blank" href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/invoice/paid?InvoiceSearch[customer_user_id]=<?=$model->user_id; ?>">View</a></th>
                        </tr>
                        <tr>
                            <th>Partial Paid</th>
                            <th><a target="_blank" href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/invoice/partial-paid?InvoiceSearch[customer_user_id]=<?=$model->user_id; ?>">View</a></th>
                        </tr>
                        <tr>
                            <th>UnPaid Invoices</th>
                            <th><a target="_blank" href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/invoice/unpaid?InvoiceSearch[customer_user_id]=<?=$model->user_id; ?>">View</a></th>
                        </tr>
                    <thead>
                </table>
            </div>
            <?php
        }
        ?>
       
      
      
   </div>
</div>

<div class="container-fluid class-using-index">
   <div id="custom_carousel" class="carousel slide" data-ride="carousel" data-interval="">
      <div class="controls">
         <ul class="nav">
         <?php if (Yii::$app->user->can('super_admin')) {
    ?>
            <li data-target="#custom_carousel" class="<?php if (Yii::$app->user->can('super_admin')) {
        echo 'active';
    } ?>" data-slide-to="0">
               <a href="#">
                  <div class="box-body2">
                     <p class="box-text2">LOCATION: <strong style=''> ALL</strong> <br>
                        ON THE WAY <span class="states">
                        <?=$all_vehicle['car_on_way']; ?>
                        </span><br>
                        ON THE HAND <span class="states">
                        <?=$all_vehicle['on_hand']; ?>
                        </span><br>
                        SHIPPED<span class="states">
                        <?=$all_vehicle['shipped']; ?>
                        </span>
                     </p>
                  </div>
               </a>
            </li>
        <?php
}?>
        <?php if (Yii::$app->user->can('admin_LA')) {
        ?>
            <li data-target="#custom_carousel" class="<?php if (Yii::$app->user->can('admin_LA') && !Yii::$app->user->can('super_admin')) {
            echo 'active';
        } ?>" data-slide-to="1">
               <a href="#">
                  <div class="box-body2">
                     <p class="box-text2">LOCATION: <strong style=''> LA</strong><br>
                        ON THE WAY <span class="states">
                        <?=$vehicle_location_LA['car_on_way']; ?>
                        </span><br>
                        ON THE HAND <span class="states">
                        <?=$vehicle_location_LA['on_hand']; ?>
                        </span><br>
                        SHIPPED<span class="states">
                        <?=$vehicle_location_LA['shipped']; ?>
                        </span>
                     </p>
                  </div>
               </a>
            </li>
        <?php
    }?>
        <?php if (Yii::$app->user->can('admin_GA')) {
        ?>
            <li data-target="#custom_carousel" class="<?php if (Yii::$app->user->can('admin_GA') && !Yii::$app->user->can('super_admin')) {
            echo 'active';
        } ?>" data-slide-to="2">
               <a href="#">
                  <div class="box-body2">
                     <p class="box-text2">LOCATION: <strong style=''> GA</strong><br>
                        ON THE WAY <span class="states">
                        <?=$vehicle_location_GA['car_on_way']; ?>
                        </span><br>
                        ON THE HAND <span class="states">
                        <?=$vehicle_location_GA['on_hand']; ?>
                        </span><br>
                        SHIPPED<span class="states">
                        <?=$vehicle_location_GA['shipped']; ?>
                        </span>
                     </p>
                  </div>
               </a>
            </li>
            <?php
    }?>
        <?php if (Yii::$app->user->can('admin_NY')) {
        ?>
            <li data-target="#custom_carousel" class="<?php if (Yii::$app->user->can('admin_NY') && !Yii::$app->user->can('super_admin')) {
            echo 'active';
        } ?>" data-slide-to="3">
               <a href="#">
                  <div class="box-body2 box-text-right">
                     <p class="box-text2">LOCATION: <strong style=''> NY</strong><br>
                        ON THE WAY <span class="states">
                        <?=$vehicle_location_NY['car_on_way']; ?>
                        </span><br>
                        ON THE HAND <span class="states">
                        <?=$vehicle_location_NY['on_hand']; ?>
                        </span><br>
                        SHIPPED<span class="states">
                        <?=$vehicle_location_NY['shipped']; ?>
                        </span>
                     </p>
                  </div>
               </a>
            </li>
        <?php
    }?>
        <?php if (Yii::$app->user->can('admin_TX')) {
        ?>
            <li data-target="#custom_carousel" class="<?php if (Yii::$app->user->can('admin_TX') && !Yii::$app->user->can('super_admin')) {
            echo 'active';
        } ?>" data-slide-to="4">
               <a href="#">
                  <div class="box-body2 box-text-right">
                     <p class="box-text2">LOCATION: <strong style=''> TX</strong><br>
                        ON THE WAY <span class="states">
                        <?=$vehicle_location_TX['car_on_way']; ?>
                        </span><br>
                        ON THE HAND <span class="states">
                        <?=$vehicle_location_TX['on_hand']; ?>
                        </span><br>
                        SHIPPED<span class="states">
                        <?=$vehicle_location_TX['shipped']; ?>
                        </span>
                     </p>
                  </div>
               </a>
            </li>
            <?php
    }?>
      
         </ul>
      </div>
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
      <?php if (Yii::$app->user->can('super_admin')) {
        ?>
         <div class="item <?php if (Yii::$app->user->can('super_admin')) {
            echo 'active';
        } ?>">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-5">
                     <h3 class="">   ORDER OVERVIEW     </h3>
                     <?php
                        echo GoogleChart::widget(array('visualization' => 'PieChart',
                            'data' => array(
                                array('Task', 'All Statuses'),
                                array('Car on Way    '.(int) $all_vehicle['car_on_way'].'', (int) $all_vehicle['car_on_way']),
                                array('On Hand    '.(int) $all_vehicle['on_hand'].'', (int) $all_vehicle['on_hand']),
                                array('Shipped   '.(int) $all_vehicle['shipped'].'', (int) $all_vehicle['shipped']),
                            ),

                        'options' => array('title' => 'All', 'chartArea' => ['left' => 50, 'top' => 0, 'width' => '100%', 'height' => '100%'], 'width' => 480,
                            'height' => 400, 'pieHole' => 0.4, 'colors' => ['#420e0e', '#b18b1d', '#000'], 'pieSliceText' => 'none', 'legend' => ['position' => 'right'], ), )); ?>
                  </div>
                  <div class="col-md-7">
                     <h3 class="pull-left"> VEHICLE STATUS  </h3>
                     <span cursor="pointer"  user="<?=$model->user_id; ?>" id="1" include="1" status="On hand" location="" class="labels label-danger all-status pull-right">Inventory Report</span>
                     <table class="table table-striped table-bordered"  style="min-height: 447px;">
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
                                            <td><?=$all_vehicle['all']; ?></td>
                                            <td></td>
                                            <td></td>

                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>" target="_blank">View</a></td>
                                        </tr>

                                        <tr>
                                            <td>Car on  way</td>
                                            <td><?=$all_vehicle['car_on_way']; ?></td>

                                            <td><span cursor="pointer" status="ON THE WAY" user="<?=$model->user_id; ?>" class="labels label-danger all-status" id="3">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=3&user=<?=$user_id; ?>&location=&status=ON THE WAY" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>

                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[status]=3" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Car On hand</td>
                                            <td><?=$all_vehicle['on_hand']; ?></td>
                                            <td><span cursor="pointer" status="On Hand" user="<?=$model->user_id; ?>" class="labels label-danger all-status" id="1">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=1&user=<?=$user_id; ?>&location=&status=On Hand" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[status]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Manifest</td>
                                            <td><?php echo $all_vehicle['manifest']; ?></td>
                                            <td><span cursor="pointer" status="Manifest" user=<?=$user_id; ?> class="labels label-danger all-status" id="2">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=2&user=<?=$user_id; ?>&location=&status=Manifest" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[status]=2&user=<?=$user_id; ?>" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Picked Up</td>
                                            <td><?php echo $all_vehicle['picked_up']; ?></td>
                                            <td><span cursor="pointer" status="Picked Up" user=<?=$user_id; ?> class="labels label-danger all-status" id="5">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=5&user=<?=$user_id; ?>&location=&status=Picked Up" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[status]=5&VehicleSearch[customer_user_id]=<?=$user_id; ?>" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>CAR SHIPPED </td>
                                            <td><?=$all_vehicle['shipped']; ?></td>
                                            <td><span cursor="pointer" status="Shipped" user=<?=$user_id; ?> class="labels label-danger all-status" id="4">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=4&user=<?=$user_id; ?>&location=&status=Shipped" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[status]=4" target="_blank">View</a></td>
                                        </tr>

                                        <tr>
                                            <td>WITH TITLE</td>
                                            <td><?=$all_vehicle['with_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>W/O TITLE</td>
                                            <td><?=$all_vehicle['with_out_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>CAR TOWED</td>
                                            <td><?=$all_vehicle['towed']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[towed]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Not Towed</td>
                                            <td><?=$all_vehicle['not_towed']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[towed]=0" target="_blank">View</a></td>

                                        </tr>
                                        <tr style='display:none;'>
                                            <td>Towed with title </td>
                                            <td><?=$all_vehicle['towed_with_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr style='display:none;'>
                                            <td>TOWED W/O TITLE </td>
                                            <td><?=$all_vehicle['towed_with_out_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                  </div>
               </div>
            </div>
         </div>
      <?php
    }?>
      <?php if (Yii::$app->user->can('admin_LA')) {
        ?>
         <div class="item <?php if (Yii::$app->user->can('admin_LA') && !Yii::$app->user->can('super_admin')) {
            echo 'active';
        } ?>">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-5">
                     <h3 class="">   ORDER OVERVIEW     </h3>
                     <?php
                        echo GoogleChart::widget(array('visualization' => 'PieChart',
                            'data' => array(
                                array('Task', 'All Statuses'),
                                array('Car on Way    '.(int) $vehicle_location_LA['car_on_way'].'', (int) $vehicle_location_LA['car_on_way']),
                                array('On Hand    '.(int) $vehicle_location_LA['on_hand'].'', (int) $vehicle_location_LA['on_hand']),
                                array('Shipped   '.(int) $vehicle_location_LA['shipped'].'', (int) $vehicle_location_LA['shipped']),
                            ),
                            'options' => array('title' => 'LA', 'chartArea' => ['left' => 50, 'top' => 0, 'width' => '100%', 'height' => '100%'], 'width' => 480,
                                'height' => 400, 'pieHole' => 0.4, 'colors' => ['#420e0e', '#b18b1d', '#000'], 'pieSliceText' => 'none', 'legend' => ['legendShape' => 'square'], ), )); ?>
                  </div>
                  <div class="col-md-7">
                     <h3 class="pull-left"> VEHICLE STATUS  </h3>
                     <span cursor="pointer"  user="<?=$model->user_id; ?>" id="1" include="1" status="On hand" location="1" class="labels label-danger all-status pull-right">Inventory Report</span>
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
                                            <td><?=$vehicle_location_LA['all']; ?></td>
                                            <td></td>
                                            <td></td>

                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=1" target="_blank">View</a></td>
                                        </tr>

                                        <tr>
                                            <td>Car on  way</td>
                                            <td><?=$vehicle_location_LA['car_on_way']; ?></td>
                                            <td><span cursor="pointer" location="1" status="ON THE WAY" user="<?=$model->user_id; ?>" class="labels label-danger all-status" id="3">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=1&user=<?=$user_id; ?>&location=1&status=On The Way" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=1&VehicleSearch[status]=3" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Car On hand</td>
                                            <td><?=$vehicle_location_LA['on_hand']; ?></td>
                                            <td><span cursor="pointer" location="1" status="On hand" user="<?=$model->user_id; ?>" class="labels label-danger all-status" id="1">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=1&user=<?=$user_id; ?>&location=1&status=On Hand" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>

                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=1&VehicleSearch[status]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Manifest</td>
                                            <td><?php echo $vehicle_location_LA['manifest']; ?></td>
                                            <td><span cursor="pointer" location='1' status="Manifest" user=<?=$user_id; ?> class="labels label-danger all-status" id="2">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=2&user=<?=$user_id; ?>&location=1&status=Manifest" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=1&VehicleSearch[status]=2" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Picked Up</td>
                                            <td><?php echo $vehicle_location_LA['picked_up']; ?></td>
                                            <td><span cursor="pointer" location='1' status="Picked Up" user=<?=$user_id; ?> class="labels label-danger all-status" id="5">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=5&user=<?=$user_id; ?>&location=1&status=Picked Up" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1&VehicleSearch[status]=5&VehicleSearch[customer_user_id]=<?=$user_id; ?>" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>CAR SHIPPED </td>
                                            <td><?=$vehicle_location_LA['shipped']; ?></td>
                                            <td><span cursor="pointer" location="1" status="Shipped" user=<?=$user_id; ?> class="labels label-danger all-status" id="4">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=4&user=<?=$user_id; ?>&location=1&status=Shipped" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=1&VehicleSearch[status]=4" target="_blank">View</a></td>
                                        </tr>

                                        <tr>
                                            <td>WITH TITLE</td>
                                            <td><?=$vehicle_location_LA['with_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=1&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>W/O TITLE</td>
                                            <td><?=$vehicle_location_LA['with_out_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>CAR TOWED</td>
                                            <td><?=$vehicle_location_LA['towed']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=1&VehicleSearch[towed]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Not Towed</td>
                                            <td><?=$vehicle_location_LA['not_towed']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=1" target="_blank">View</a></td>

                                        </tr>
                                        <tr style='display:none;'>
                                            <td>Towed with title </td>
                                            <td><?=$vehicle_location_LA['towed_with_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr style='display:none;'>
                                            <td>TOWED W/O TITLE </td>
                                            <td><?=$vehicle_location_LA['towed_with_out_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=1" target="_blank">View</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                  </div>
               </div>
            </div>
         </div>
      <?php
    }?>
      <?php if (Yii::$app->user->can('admin_GA')) {
        ?>
         <div class="item <?php if (Yii::$app->user->can('admin_GA') && !Yii::$app->user->can('super_admin')) {
            echo 'active';
        } ?>">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-5">
                     <h3 class="">   ORDER OVERVIEW     </h3>
                     <?php
                        echo GoogleChart::widget(array('visualization' => 'PieChart',
                            'data' => array(
                                array('Task', 'All Statuses'),
                                array('Car on Way    '.(int) $vehicle_location_GA['car_on_way'].'', (int) $vehicle_location_GA['car_on_way']),
                                array('On Hand    '.(int) $vehicle_location_GA['on_hand'].'', (int) $vehicle_location_GA['on_hand']),
                                array('Shipped   '.(int) $vehicle_location_GA['shipped'].'', (int) $vehicle_location_GA['shipped']),
                            ),
                            'options' => array('title' => 'GA', 'chartArea' => ['left' => 50, 'top' => 0, 'width' => '100%', 'height' => '100%'], 'width' => 480,
                                'height' => 400, 'pieHole' => 0.4, 'colors' => ['#420e0e', '#b18b1d', '#000'], 'pieSliceText' => 'none', 'legend' => ['legendShape' => 'square'], ), )); ?>
                  </div>
                  <div class="col-md-7">
                     <h3 class="pull-left"> VEHICLE STATUS  </h3>
                     <span cursor="pointer"  user="<?=$model->user_id; ?>" id="1" include="1" status="On hand" location="2" class="labels label-danger all-status pull-right">Inventory Report</span>
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
                                            <td><?=$vehicle_location_GA['all']; ?></td>
                                            <td></td>
                                            <td></td>

                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=2" target="_blank">View</a></td>
                                        </tr>

                                        <tr>
                                            <td>Car on  way</td>
                                            <td><?=$vehicle_location_GA['car_on_way']; ?></td>
                                            <td><span cursor="pointer" location="2" status="ON THE WAY" user="<?=$model->user_id; ?>" class="labels label-danger all-status" id="3">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=3&user=<?=$user_id; ?>&location=2&status=ON THE WAY" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>

                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=2&VehicleSearch[status]=3" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Car On hand</td>
                                            <td><?=$vehicle_location_GA['on_hand']; ?></td>
                                            <td><span cursor="pointer" location="2" status="On hand" user="<?=$model->user_id; ?>" class="labels label-danger all-status" id="1">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=1&user=<?=$user_id; ?>&location=2&status=On Hand" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>

                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=2&VehicleSearch[status]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Manifest</td>
                                            <td><?php echo $vehicle_location_GA['manifest']; ?></td>
                                            <td><span cursor="pointer" location='2' status="Manifest" user=<?=$user_id; ?> class="labels label-danger all-status" id="2">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=2&user=<?=$user_id; ?>&location=2&status=Manifest" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2&VehicleSearch[status]=2&VehicleSearch[customer_user_id]=<?=$user_id; ?>" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Picked Up</td>
                                            <td><?php echo $vehicle_location_GA['picked_up']; ?></td>
                                            <td><span cursor="pointer" location='2' status="Picked Up" user=<?=$user_id; ?> class="labels label-danger all-status" id="5">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=5&user=<?=$user_id; ?>&location=2&status=Picked Up" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2&VehicleSearch[status]=5&VehicleSearch[customer_user_id]=<?=$user_id; ?>" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>CAR SHIPPED </td>
                                            <td><?=$vehicle_location_GA['shipped']; ?></td>
                                            <td><span cursor="pointer" location="2" status="Shipped" user=<?=$user_id; ?> class="labels label-danger all-status" id="4">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=4&user=<?=$user_id; ?>&location=2&status=Shipped" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=2&VehicleSearch[status]=4" target="_blank">View</a></td>
                                        </tr>

                                        <tr>
                                            <td>WITH TITLE</td>
                                            <td><?=$vehicle_location_GA['with_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=2&VehicleSearch[status]=1&VehicleSearch[towed]=0" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>W/O TITLE</td>
                                            <td><?=$vehicle_location_GA['with_out_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=2&VehicleSearch[status]=1&VehicleSearch[towed]=0" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>CAR TOWED</td>
                                            <td><?=$vehicle_location_GA['towed']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=2&VehicleSearch[towed]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Not Towed</td>
                                            <td><?=$vehicle_location_GA['not_towed']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=2&VehicleSearch[towed]=0" target="_blank">View</a></td>

                                        </tr>
                                        <tr style='display:none;'>
                                            <td>Towed with title </td>
                                            <td><?=$vehicle_location_GA['towed_with_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=2" target="_blank">View</a></td>
                                        </tr>
                                        <tr style='display:none;'>
                                            <td>TOWED W/O TITLE </td>
                                            <td><?=$vehicle_location_GA['towed_with_out_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=2" target="_blank">View</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                  </div>
               </div>
            </div>
         </div>
      <?php
    }?>
      <?php if (Yii::$app->user->can('admin_NY')) {
        ?>
         <div class="item <?php if (Yii::$app->user->can('admin_NY') && !Yii::$app->user->can('super_admin')) {
            echo 'active';
        } ?>">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-5">
                     <h3 class="">   ORDER OVERVIEW     </h3>
                     <?php
                        echo GoogleChart::widget(array('visualization' => 'PieChart',
                            'data' => array(
                                array('Task', '2'),
                                array('Car on Way    '.(int) $vehicle_location_NY['car_on_way'].'', (int) $vehicle_location_NY['car_on_way']),
                                array('On Hand    '.(int) $vehicle_location_NY['on_hand'].'', (int) $vehicle_location_NY['on_hand']),
                                array('Shipped   '.(int) $vehicle_location_NY['shipped'].'', (int) $vehicle_location_NY['shipped']),
                            ),
                            'options' => array('title' => 'NY', 'chartArea' => ['left' => 50, 'top' => 0, 'width' => '100%', 'height' => '100%'], 'width' => 480,
                                'height' => 400, 'pieHole' => 0.4, 'colors' => ['#420e0e', '#b18b1d', '#000'], 'pieSliceText' => 'none', 'legend' => ['legendShape' => 'square'], ), )); ?>
                  </div>
                  <div class="col-md-7">
                     <h3 class="pull-left"> VEHICLE STATUS  </h3>
                     <span cursor="pointer"  user="<?=$model->user_id; ?>" id="1" include="1" status="On hand" location="3" class="labels label-danger all-status pull-right">Inventory Report</span>
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
                                            <td><?=$vehicle_location_NY['all']; ?></td>
                                            <td></td>
                                            <td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=3" target="_blank">View</a></td>
                                        </tr>

                                        <tr>
                                            <td>Car on  way</td>
                                            <td><?=$vehicle_location_NY['car_on_way']; ?></td>
                                            <td><span cursor="pointer" location="3" status="ON THE WAY" user="<?=$model->user_id; ?>" class="labels label-danger all-status" id="3">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=3&user=<?=$user_id; ?>&location=3&status=ON THE WAY" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=3&VehicleSearch[status]=3" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Car On hand</td>
                                            <td><?=$vehicle_location_NY['on_hand']; ?></td>
                                            <td><span cursor="pointer" location="3" status="On hand" user="<?=$model->user_id; ?>" class="labels label-danger all-status" id="1">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=1&user=<?=$user_id; ?>&location=3&status=On Hand" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=3&VehicleSearch[status]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Manifest</td>
                                            <td><?php echo $vehicle_location_NY['manifest']; ?></td>
                                            <td><span cursor="pointer" location='3' status="Manifest" user=<?=$user_id; ?> class="labels label-danger all-status" id="2">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=2&user=<?=$user_id; ?>&location=3&status=Manifest" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[status]=2&VehicleSearch[customer_user_id]=<?=$user_id; ?>" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Picked Up</td>
                                            <td><?php echo $vehicle_location_NY['picked_up']; ?></td>
                                            <td><span cursor="pointer" location='3' status="Picked Up" user=<?=$user_id; ?> class="labels label-danger all-status" id="5">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=5&user=<?=$user_id; ?>&location=3&status=Picked Up" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[status]=5&VehicleSearch[customer_user_id]=<?=$user_id; ?>" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>CAR SHIPPED </td>
                                            <td><?=$vehicle_location_NY['shipped']; ?></td>
                                            <td><span cursor="pointer" location="3" status="Shipped" user=<?=$user_id; ?> class="labels label-danger all-status" id="4">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=4&user=<?=$user_id; ?>&location=3&status=Shipped" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=3&VehicleSearch[status]=4" target="_blank">View</a></td>
                                        </tr>

                                        <tr>
                                            <td>WITH TITLE</td>
                                            <td><?=$vehicle_location_NY['with_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=3&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>W/O TITLE</td>
                                            <td><?=$vehicle_location_NY['with_out_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=3&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>CAR TOWED</td>
                                            <td><?=$vehicle_location_NY['towed']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=3&VehicleSearch[towed]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Not Towed</td>
                                            <td><?=$vehicle_location_NY['not_towed']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=3&VehicleSearch[towed]=0" target="_blank">View</a></td>

                                        </tr>
                                        <tr style='display:none;'>
                                            <td>Towed with title </td>
                                            <td><?=$vehicle_location_NY['towed_with_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=3&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr style='display:none;'>
                                            <td>TOWED W/O TITLE </td>
                                            <td><?=$vehicle_location_NY['towed_with_out_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=3&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                        </tr>

                                    </tbody>
                                </table>
                  </div>
               </div>
            </div>
         </div>
      <?php
    }?>
      <?php if (Yii::$app->user->can('admin_TX')) {
        ?>
         <div class="item <?php if (Yii::$app->user->can('admin_TX') && !Yii::$app->user->can('super_admin')) {
            echo 'active';
        } ?>">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-5">
                     <h3 class="">   ORDER OVERVIEW     </h3>
                     <?php
                        echo GoogleChart::widget(array('visualization' => 'PieChart',
                            'data' => array(
                                array('Task', 'All Statuses'),
                                array('Car on Way    '.(int) $vehicle_location_TX['car_on_way'].'', (int) $vehicle_location_TX['car_on_way']),
                                array('On Hand    '.(int) $vehicle_location_TX['on_hand'].'', (int) $vehicle_location_TX['on_hand']),
                                array('Shipped   '.(int) $vehicle_location_TX['shipped'].'', (int) $vehicle_location_TX['shipped']),
                            ),
                            'options' => array('title' => 'TX', 'chartArea' => ['left' => 50, 'top' => 0, 'width' => '100%', 'height' => '100%'], 'width' => 480,
                                'height' => 400, 'pieHole' => 0.4, 'colors' => ['#420e0e', '#b18b1d', '#000'], 'pieSliceText' => 'none', 'legend' => ['legendShape' => 'square'], ), )); ?>
                  </div>
                  <div class="col-md-7">
                     <h3 class="pull-left"> VEHICLE STATUS  </h3>
                     <span cursor="pointer"  user="<?=$model->user_id; ?>" id="1" include="1" status="On hand" location="4" class="labels label-danger all-status pull-right">Inventory Report</span>
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
                                            <td><?=$vehicle_location_TX['all']; ?></td>
                                            <td></td>
                                            <td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=4" target="_blank">View</a></td>
                                        </tr>

                                        <tr>
                                            <td>Car on  way</td>
                                            <td><?=$vehicle_location_TX['car_on_way']; ?></td>
                                            <td><span cursor="pointer" location="4" status="ON THE WAY" user="<?=$model->user_id; ?>" class="labels label-danger all-status" id="3">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=3&user=<?=$user_id; ?>&location=4&status=ON THE WAY" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>

                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=4&VehicleSearch[status]=3" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Car On hand</td>
                                            <td><?=$vehicle_location_TX['on_hand']; ?></td>
                                            <td><span cursor="pointer" location="4" status="On hand" user="<?=$model->user_id; ?>" class="labels label-danger all-status" id="1">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=1&user=<?=$user_id; ?>&location=4&status=On Hand" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>

                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=4&VehicleSearch[status]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Manifest</td>
                                            <td><?php echo $vehicle_location_TX['manifest']; ?></td>
                                            <td><span cursor="pointer" location='4' status="Manifest" user=<?=$user_id; ?> class="labels label-danger all-status" id="2">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=2&user=<?=$user_id; ?>&location=4&status=Manifest" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=4&VehicleSearch[status]=2" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Picked Up</td>
                                            <td><?php echo $vehicle_location_TX['picked_up']; ?></td>
                                            <td><span cursor="pointer" location='4' status="Picked Up" user=<?=$user_id; ?> class="labels label-danger all-status" id="5">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=5&user=<?=$user_id; ?>&location=4&status=Picked Up" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&VehicleSearch[status]=5&VehicleSearch[customer_user_id]=<?=$user_id; ?>" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>CAR SHIPPED </td>
                                            <td><?=$vehicle_location_TX['shipped']; ?></td>
                                            <td><span cursor="pointer" location="4" status="Shipped" user=<?=$user_id; ?> class="labels label-danger all-status" id="4">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=4&user=<?=$user_id; ?>&location=4&status=Shipped" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=4&VehicleSearch[status]=4" target="_blank">View</a></td>
                                        </tr>

                                        <tr>
                                            <td>WITH TITLE</td>
                                            <td><?=$vehicle_location_TX['with_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=4&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>W/O TITLE</td>
                                            <td><?=$vehicle_location_TX['with_out_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=4&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>CAR TOWED</td>
                                            <td><?=$vehicle_location_TX['towed']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=4&?VehicleSearch[towed]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Not Towed</td>
                                            <td><?=$vehicle_location_TX['not_towed']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=4&?VehicleSearch[towed]=0" target="_blank">View</a></td>

                                        </tr>
                                        <tr style='display:none;'>
                                            <td>Towed with title </td>
                                            <td><?=$vehicle_location_TX['towed_with_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=4&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr style='display:none;'>
                                            <td>TOWED W/O TITLE </td>
                                            <td><?=$vehicle_location_TX['towed_with_out_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=4&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                  </div>
               </div>
            </div>
         </div>
      <?php
    }?>
      <?php if (Yii::$app->user->can('admin_TX2')) {
        ?>
         <div class="item <?php if (Yii::$app->user->can('admin_TX2') && !Yii::$app->user->can('super_admin')) {
            echo 'active';
        } ?>">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-5">
                     <h3 class="">   ORDER OVERVIEW     </h3>
                     <?php
                        echo GoogleChart::widget(array('visualization' => 'PieChart',
                            'data' => array(
                                array('Task', 'All Statuses'),
                                array('Car on Way    '.(int) $vehicle_location_TX2['car_on_way'].'', (int) $vehicle_location_TX2['car_on_way']),
                                array('On Hand    '.(int) $vehicle_location_TX2['on_hand'].'', (int) $vehicle_location_TX2['on_hand']),
                                array('Shipped   '.(int) $vehicle_location_TX2['shipped'].'', (int) $vehicle_location_TX2['shipped']),
                            ),
                            'options' => array('title' => 'TX', 'chartArea' => ['left' => 50, 'top' => 0, 'width' => '100%', 'height' => '100%'], 'width' => 480,
                                'height' => 400, 'pieHole' => 0.4, 'colors' => ['#420e0e', '#b18b1d', '#000'], 'pieSliceText' => 'none', 'legend' => ['legendShape' => 'square'], ), )); ?>
                  </div>
                  <div class="col-md-7">
                     <h3 class="pull-left"> VEHICLE STATUS  </h3>
                     <span cursor="pointer"  user="<?=$model->user_id; ?>" id="1" include="1" status="On hand" location="5" class="labels label-danger all-status pull-right">Inventory Report</span>
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
                                            <td><?=$vehicle_location_TX2['all']; ?></td>
                                            <td></td>
                                            <td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=5" target="_blank">View</a></td>
                                        </tr>

                                        <tr>
                                            <td>Car on  way</td>
                                            <td><?=$vehicle_location_TX2['car_on_way']; ?></td>
                                            <td><span cursor="pointer" location="5" status="ON THE WAY" user="<?=$model->user_id; ?>" class="labels label-danger all-status" id="3">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=3&user=<?=$user_id; ?>&location=5&status=ON THE WAY" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>

                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=5&VehicleSearch[status]=3" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Car On hand</td>
                                            <td><?=$vehicle_location_TX2['on_hand']; ?></td>
                                            <td><span cursor="pointer" location="5" status="On hand" user="<?=$model->user_id; ?>" class="labels label-danger all-status" id="1">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=1&user=<?=$user_id; ?>&location=5&status=On Hand" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>

                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=5&VehicleSearch[status]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Manifest</td>
                                            <td><?php echo $vehicle_location_TX2['manifest']; ?></td>
                                            <td><span cursor="pointer" location='5' status="Manifest" user=<?=$user_id; ?> class="labels label-danger all-status" id="2">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=2&user=<?=$user_id; ?>&location=5&status=Manifest" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=5&VehicleSearch[status]=2" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Picked Up</td>
                                            <td><?php echo $vehicle_location_TX2['picked_up']; ?></td>
                                            <td><span cursor="pointer" location='5' status="Picked Up" user=<?=$user_id; ?> class="labels label-danger all-status" id="5">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=5&user=<?=$user_id; ?>&location=5&status=Picked Up" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=5&VehicleSearch[status]=5&VehicleSearch[customer_user_id]=<?=$user_id; ?>" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>CAR SHIPPED </td>
                                            <td><?=$vehicle_location_TX2['shipped']; ?></td>
                                            <td><span cursor="pointer" location="5" status="Shipped" user=<?=$user_id; ?> class="labels label-danger all-status" id="4">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=5&user=<?=$user_id; ?>&location=1&status=Shipped" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=5&VehicleSearch[status]=4" target="_blank">View</a></td>
                                        </tr>

                                        <tr>
                                            <td>WITH TITLE</td>
                                            <td><?=$vehicle_location_TX2['with_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=5&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>W/O TITLE</td>
                                            <td><?=$vehicle_location_TX2['with_out_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=5&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>CAR TOWED</td>
                                            <td><?=$vehicle_location_TX2['towed']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=5&?VehicleSearch[towed]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Not Towed</td>
                                            <td><?=$vehicle_location_TX2['not_towed']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=5&?VehicleSearch[towed]=0" target="_blank">View</a></td>

                                        </tr>
                                        <tr style='display:none;'>
                                            <td>Towed with title </td>
                                            <td><?=$vehicle_location_TX2['towed_with_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=5&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr style='display:none;'>
                                            <td>TOWED W/O TITLE </td>
                                            <td><?=$vehicle_location_TX2['towed_with_out_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=5&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                  </div>
               </div>
            </div>
         </div>
      <?php
    }?>
      <?php if (Yii::$app->user->can('admin_NJ2')) {
        ?>
         <div class="item <?php if (Yii::$app->user->can('admin_NJ2') && !Yii::$app->user->can('super_admin')) {
            echo 'active';
            } ?>">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-5">
                     <h3 class="">   ORDER OVERVIEW     </h3>
                     <?php
                        echo GoogleChart::widget(array('visualization' => 'PieChart',
                            'data' => array(
                                array('Task', 'All Statuses'),
                                array('Car on Way    '.(int) $vehicle_location_NJ2['car_on_way'].'', (int) $vehicle_location_NJ2['car_on_way']),
                                array('On Hand    '.(int) $vehicle_location_NJ2['on_hand'].'', (int) $vehicle_location_NJ2['on_hand']),
                                array('Shipped   '.(int) $vehicle_location_NJ2['shipped'].'', (int) $vehicle_location_NJ2['shipped']),
                            ),
                            'options' => array('title' => 'TX', 'chartArea' => ['left' => 50, 'top' => 0, 'width' => '100%', 'height' => '100%'], 'width' => 480,
                                'height' => 400, 'pieHole' => 0.4, 'colors' => ['#420e0e', '#b18b1d', '#000'], 'pieSliceText' => 'none', 'legend' => ['legendShape' => 'square'], ), )); ?>
                  </div>
                  <div class="col-md-7">
                     <h3 class="pull-left"> VEHICLE STATUS  </h3>
                     <span cursor="pointer"  user="<?=$model->user_id; ?>" id="1" include="1" status="On hand" location="6" class="labels label-danger all-status pull-right">Inventory Report</span>
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
                                            <td><?=$vehicle_location_NJ2['all']; ?></td>
                                            <td></td>
                                            <td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=6" target="_blank">View</a></td>
                                        </tr>

                                        <tr>
                                            <td>Car on  way</td>
                                            <td><?=$vehicle_location_NJ2['car_on_way']; ?></td>
                                            <td><span cursor="pointer" location="6" status="ON THE WAY" user="<?=$model->user_id; ?>" class="labels label-danger all-status" id="3">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=3&user=<?=$user_id; ?>&location=6&status=ON THE WAY" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>

                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=6&VehicleSearch[status]=3" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Car On hand</td>
                                            <td><?=$vehicle_location_NJ2['on_hand']; ?></td>
                                            <td><span cursor="pointer" location="6" status="On hand" user="<?=$model->user_id; ?>" class="labels label-danger all-status" id="1">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=1&user=<?=$user_id; ?>&location=6&status=On Hand" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>

                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=6&VehicleSearch[status]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Manifest</td>
                                            <td><?php echo $vehicle_location_NJ2['manifest']; ?></td>
                                            <td><span cursor="pointer" location='6' status="Manifest" user=<?=$user_id; ?> class="labels label-danger all-status" id="2">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=2&user=<?=$user_id; ?>&location=6&status=Manifest" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=6&VehicleSearch[status]=2" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Picked Up</td>
                                            <td><?php echo $vehicle_location_NJ2['picked_up']; ?></td>
                                            <td><span cursor="pointer" location='6' status="Picked Up" user=<?=$user_id; ?> class="labels label-danger all-status" id="5">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=5&user=<?=$user_id; ?>&location=6&status=Picked Up" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=6&VehicleSearch[status]=5&VehicleSearch[customer_user_id]=<?=$user_id; ?>" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>CAR SHIPPED </td>
                                            <td><?=$vehicle_location_NJ2['shipped']; ?></td>
                                            <td><span cursor="pointer" location="6" status="Shipped" user=<?=$user_id; ?> class="labels label-danger all-status" id="4">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=4&user=<?=$user_id; ?>&location=6&status=Shipped" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=6&VehicleSearch[status]=4" target="_blank">View</a></td>
                                        </tr>

                                        <tr>
                                            <td>WITH TITLE</td>
                                            <td><?=$vehicle_location_NJ2['with_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=6&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>W/O TITLE</td>
                                            <td><?=$vehicle_location_NJ2['with_out_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=6&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>CAR TOWED</td>
                                            <td><?=$vehicle_location_NJ2['towed']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=6&?VehicleSearch[towed]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Not Towed</td>
                                            <td><?=$vehicle_location_NJ2['not_towed']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=6&?VehicleSearch[towed]=0" target="_blank">View</a></td>

                                        </tr>
                                        <tr style='display:none;'>
                                            <td>Towed with title </td>
                                            <td><?=$vehicle_location_NJ2['towed_with_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=6&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr style='display:none;'>
                                            <td>TOWED W/O TITLE </td>
                                            <td><?=$vehicle_location_NJ2['towed_with_out_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=6&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                  </div>
               </div>
            </div>
         </div>
      <?php
    }?>
      <?php if (Yii::$app->user->can('admin_CA')) {
        ?>
         <div class="item <?php if (Yii::$app->user->can('admin_CA') && !Yii::$app->user->can('super_admin')) {
            echo 'active';
            } ?>">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-5">
                     <h3 class="">   ORDER OVERVIEW     </h3>
                     <?php
                        echo GoogleChart::widget(array('visualization' => 'PieChart',
                            'data' => array(
                                array('Task', 'All Statuses'),
                                array('Car on Way    '.(int) $vehicle_location_CA['car_on_way'].'', (int) $vehicle_location_CA['car_on_way']),
                                array('On Hand    '.(int) $vehicle_location_CA['on_hand'].'', (int) $vehicle_location_CA['on_hand']),
                                array('Shipped   '.(int) $vehicle_location_CA['shipped'].'', (int) $vehicle_location_CA['shipped']),
                            ),
                            'options' => array('title' => 'TX', 'chartArea' => ['left' => 50, 'top' => 0, 'width' => '100%', 'height' => '100%'], 'width' => 480,
                                'height' => 400, 'pieHole' => 0.4, 'colors' => ['#420e0e', '#b18b1d', '#000'], 'pieSliceText' => 'none', 'legend' => ['legendShape' => 'square'], ), )); ?>
                  </div>
                  <div class="col-md-7">
                     <h3 class="pull-left"> VEHICLE STATUS  </h3>
                     <span cursor="pointer"  user="<?=$model->user_id; ?>" id="1" include="1" status="On hand" location="7" class="labels label-danger all-status pull-right">Inventory Report</span>
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
                                            <td><?=$vehicle_location_CA['all']; ?></td>
                                            <td></td>
                                            <td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=6" target="_blank">View</a></td>
                                        </tr>

                                        <tr>
                                            <td>Car on  way</td>
                                            <td><?=$vehicle_location_CA['car_on_way']; ?></td>
                                            <td><span cursor="pointer" location="7" status="ON THE WAY" user="<?=$model->user_id; ?>" class="labels label-danger all-status" id="3">Report</span></td>
                              <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=3&user=<?=$user_id; ?>&location=7&status=ON THE WAY" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>

                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=7&VehicleSearch[status]=3" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Car On hand</td>
                                            <td><?=$vehicle_location_CA['on_hand']; ?></td>
                                            <td><span cursor="pointer" location="7" status="On hand" user="<?=$model->user_id; ?>" class="labels label-danger all-status" id="1">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=1&user=<?=$user_id; ?>&location=7&status=On Hand" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>

                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=7&VehicleSearch[status]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Manifest</td>
                                            <td><?php echo $vehicle_location_CA['manifest']; ?></td>
                                            <td><span cursor="pointer" location='7' status="Manifest" user=<?=$user_id; ?> class="labels label-danger all-status" id="2">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=2&user=<?=$user_id; ?>&location=7&status=Manifest" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=7&VehicleSearch[status]=2" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Picked Up</td>
                                            <td><?php echo $vehicle_location_CA['picked_up']; ?></td>
                                            <td><span cursor="pointer" location='7' status="Picked Up" user=<?=$user_id; ?> class="labels label-danger all-status" id="5">Report</span></td>
                                            <td><a class="btn btn-primary open-pdf" href="/site/statuspdfcustomer?id=5&user=<?=$user_id; ?>&location=7&status=Picked Up" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                            <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=7&VehicleSearch[status]=5&VehicleSearch[customer_user_id]=<?=$user_id; ?>" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>CAR SHIPPED </td>
                                            <td><?=$vehicle_location_CA['shipped']; ?></td>
                                            <td></td>
                                            <td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=7&VehicleSearch[status]=4" target="_blank">View</a></td>
                                        </tr>

                                        <tr>
                                            <td>WITH TITLE</td>
                                            <td><?=$vehicle_location_CA['with_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=7&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>W/O TITLE</td>
                                            <td><?=$vehicle_location_CA['with_out_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=7&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>CAR TOWED</td>
                                            <td><?=$vehicle_location_CA['towed']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=7&?VehicleSearch[towed]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Not Towed</td>
                                            <td><?=$vehicle_location_CA['not_towed']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=7&?VehicleSearch[towed]=0" target="_blank">View</a></td>

                                        </tr>
                                        <tr style='display:none;'>
                                            <td>Towed with title </td>
                                            <td><?=$vehicle_location_CA['towed_with_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=7&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                        </tr>
                                        <tr style='display:none;'>
                                            <td>TOWED W/O TITLE </td>
                                            <td><?=$vehicle_location_CA['towed_with_out_title']; ?></td>
                                            <td></td><td></td>
                                            <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>&VehicleSearch[location]=7&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                  </div>
               </div>
            </div>
         </div>
      <?php
    }?>
         <!-- End Item -->
      </div>
      <!-- End Carousel Inner -->
   </div>
   <!-- End Carousel -->
</div>
<?php 
    if (isset($Role['super_admin'])) 
    {
        ?>
        <div class="white-box consignee-tab">
            <h4>Consignee /Notifying party</h4>
            <div class="row">
                <?php $id = 12; ?>
                <?php
                $default_consignees = \common\models\Consignee::find()->where(['customer_user_id' => null])->all();

                foreach ($default_consignees as $default_consignee) {
                    ?>
                    <div class="col-md-6">
                        <table id="w0" class="table table-striped table-bordered detail-view">
                            <tbody>
                            <tr>
                                <th>Consignee Name</th>
                                <td><?=$default_consignee->consignee_name; ?></td>
                            </tr>
                            <tr>
                                <th>Consignee Address</th>
                                <td><?=$default_consignee->consignee_address_1; ?></td>
                            </tr>
                            <tr>
                                <th>Consignee City</th>
                                <td><?=$default_consignee->city; ?></td>
                            </tr>
                            <tr>
                                <th>Consignee Country</th>
                                <td><?=$default_consignee->country; ?></td>
                            </tr>
                            <tr>
                                <th>Consignee Phone</th>
                                <td><?=$default_consignee->phone; ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php
                }
                $all_consignee = $model->consignees;
                if ($all_consignee) {
                    foreach ($all_consignee as $all_consignees) {
                        ?>
                    <div class="col-md-6">
                        <table id="w0" class="table table-striped table-bordered detail-view">
                            <tbody>
                            <tr>
                                <th>Consignee Name</th>
                                <td><?=$all_consignees->consignee_name; ?></td>
                            </tr>
                            <tr>
                                <th>Consignee Address</th>
                                <td><?=$all_consignees->consignee_address_1; ?></td>
                            </tr>
                            <tr>
                                <th>Consignee Phone</th>
                                <td><?=$all_consignees->phone; //isset($all_consignees->customerUser->phone_two)?$all_consignees->customerUser->phone_two:$all_consignees->phone;?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    }
                }
                ?>
            </div>
        </div>
        <?php
    }
    ?>
<div class="col-md-4">
   <div class="price">
      <p>All Vehicle</p>
      <span><?=count($model->vehicles); ?> /</span><span class="period">item</span>
      <p><a class="btn btn-default" target="_blank" href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[customer_user_id]=<?=$model->user_id; ?>">View</a></p>
   </div>
</div>
<div class="col-md-4">
   <div class="price">
      <p>All Export</p>
      <span><?=\common\models\Export::find()->where(['customer_user_id' => $model->user_id])->count(); ?> /</span><span class="period">item</span>
      <p><a class="btn btn-default" target="_" href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/export/index?ExportSearch[customer_user_id]=<?=$model->user_id; ?>">View</a></p>
   </div>
</div>
<div class="col-md-4">
   <div class="price">
      <p>All Inventory</p>
      <span><?=count($model->invoices); ?> /</span><span class="period">item</span>
      <p><a class="btn btn-default" target="_" href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/invoice/index?InvoiceSearch[customer_user_id]=<?=$model->user_id; ?>">View</a></p>
   </div>
</div>

<div class="white-box">
   <div class="row">
      <div class="col-md-12">
         <h4>Customer Documents</h4>
         <?php
$items = array();
$saj = array();
foreach ($model->customerDocuments as $gallery) {
    // $image_type =  mime_content_type($gallery->file);
    //$file_path = Yii::getAlias('@app') . '/../uploads/'.$gallery->file;
    //$path_to_file = \yii\helpers\Url::to(Yii::getAlias('@app') . '/../uploads/' . $gallery->file);
    $path_exist = Yii::getAlias('@app').'/../uploads/'.$gallery->file;
    $path = \yii\helpers\Url::to(Yii::getAlias('@app').'/../uploads/'.$gallery->file);
    if (file_exists($path_exist)) {
        $info = getimagesize($path);
        $extension = image_type_to_extension($info[2]);
        if ($extension) {
            ?>
         <div class="col-md-3">
            <img src="<?= \yii\helpers\Url::to('/uploads/'.$gallery->file); ?>" class="img-responsive" alt="">
         </div>
         <?php
        } else {
            ?>
         <div class="col-md-3">
            <iframe id="fred" style="border:1px solid #666CCC" title="PDF in an i-Frame" src="<?php echo \yii\helpers\Url::to('/uploads/'.$gallery->file); ?>" frameborder="1" scrolling="auto" height="300" width="100%" ></iframe>
            <br> <a target="_blank" href="<?php echo \yii\helpers\Url::to('/uploads/'.$gallery->file); ?>">Download</a>
         </div>
         <?php
        }
    }
}
?>
      </div>
   </div>
</div>
</div>
<?php
Modal::begin([
    'id' => 'modal',
    'size' => 'modal-lg',
]);

echo '<div id="modalContent"></div>';

Modal::end();?>
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
    'title' => 'Will open the generated PDF file in a new window',
]);
?>
            <?php
echo Html::a('<i class="status-button-email fa fa-envelope"></i> Email', ['/site/statuspdfcustomer', 'id' => -1], [
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
       $(document).ready(function(ev){
       $('#custom_carousel').on('slide.bs.carousel', function (evt) {
         $('#custom_carousel .controls li.active').removeClass('active');
         $('#custom_carousel .controls li:eq('+$(evt.relatedTarget).index()+')').addClass('active');
       })
   });
   $("body").delegate(".all-status", "click", function () {
   $("#myModal").modal();
   var id =    $(this).attr('id');
   var include_on_the_way = false;
   if($(this).attr('location')){
   var location =    $(this).attr('location');
   }else{
   var location = '';
   }
   var status = $(this).attr('status');
   var user = $(this).attr('user');
   if($(this).attr('include')){
            include_on_the_way =    $(this).attr('include');
   }
   var newHref = $('.status-button').parent().attr('href').split('?')[0] + "?id="+id+"&user="+user+"&location="+location+"&status="+status+"&include="+include_on_the_way;
   $('.modal-content .status-button').parent().attr('href',newHref);

   var newHrefemail = $('.status-button-email').parent().attr('href').split('?')[0] + "?id="+id+"&user="+user+"&location="+location+"&status="+status+"&mail=1"+"&include="+include_on_the_way;
   $('.modal-content .status-button-email').parent().attr('href',newHrefemail);
       $.ajax({
           type: "POST",
           data:  {id:id, status:status,user:user,location: location,include:include_on_the_way },
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