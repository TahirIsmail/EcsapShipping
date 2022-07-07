<?php
use kartik\select2\Select2;
use scotthuangzl\googlechart\GoogleChart;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;


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
$vehicle_location_MD = '';
$all_export = '';
$location = '';
if (isset($Role['customer'])) {
    $all_vehicle = \common\models\Vehicle::all_vehicle_report_customer($user_id);
    $vehicle_location_LA = \common\models\Vehicle::all_vehicle_location_report_customer($location = '1', $user_id);
    $vehicle_location_GA = \common\models\Vehicle::all_vehicle_location_report_customer($location = '2', $user_id);
    $vehicle_location_NY = \common\models\Vehicle::all_vehicle_location_report_customer($location = '3', $user_id);
    $vehicle_location_TX = \common\models\Vehicle::all_vehicle_location_report_customer($location = '4', $user_id);
    $vehicle_location_TX = \common\models\Vehicle::all_vehicle_location_report_customer($location = '8', $user_id);

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
} elseif (isset($Role['admin_MD'])) {
    $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '8');
    $view = 'customer_admin';
}
elseif (isset($Role['sub_admin'])) {
    $all_vehicle_array = [];
    $all_vehicle_array[] = $vehicle_location_LA = \common\models\Vehicle::all_vehicle_location_report($location = '1');
    $all_vehicle_array[] = $vehicle_location_GA = \common\models\Vehicle::all_vehicle_location_report($location = '2');
    $all_vehicle_array[] = $vehicle_location_NY = \common\models\Vehicle::all_vehicle_location_report($location = '3');
    $all_vehicle_array[] = $vehicle_location_TX = \common\models\Vehicle::all_vehicle_location_report($location = '4');
    $all_vehicle_array[] = $vehicle_location_TX = \common\models\Vehicle::all_vehicle_location_report($location = '8');

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
    $vehicle_location_MD = \common\models\Vehicle::all_vehicle_location_report($location = '8');
    
    $view = 'index';
}
if (Yii::$app->user->can('super_admin')) {
    $view = 'index';
}

// print_r($_SESSION);

/* @var $this yii\web\View */
?>
<style>
    .empty{
        display:none;
    }
</style>
<div class="row">
    <div class="col-lg-2 col-sm-4 col-xs-12">
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
    <div class="col-lg-2 col-sm-4 col-xs-12">
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
    <div class="col-lg-2 col-sm-4 col-xs-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-uppercase">MANIFEST</h5>
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
    <div class="col-lg-2 col-sm-4 col-xs-12">
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
    <div class="col-lg-2 col-sm-4 col-xs-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-uppercase">Arrived</h5>
                <div class="d-flex align-items-center no-block m-t-20 m-b-10">
                    <h1><i class="ti-wallet text-success"></i>
                        <img class="car-img" src="<?= Yii::$app->homeUrl ?>uploads/usa-important-images/cruise.png"
                             alt="car image">
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
                        <img class="car-img" src="<?= Yii::$app->homeUrl; ?>uploads/usa-important-images/cruise.png"
                             alt="car image">
                    </h1>
                    <div class="ml-auto">
                        <h1 class="text-muted"><?= $all_vehicle['arrived'] + $all_vehicle['shipped'] + $all_vehicle['manifest'] + $all_vehicle['on_hand'] + $all_vehicle['car_on_way']; ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class=""  >
    <div class="container-fluid">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="white-box" style="padding:0px;">
                <div class="col-md-2">
                </div>
                <?php
                Modal::begin(['id' => 'modal', 'size' => 'modal-lg']);
                echo '<div id="modalContent"></div>';
                Modal::end();
                Pjax::begin();
                echo $this->render('_search', ['model' => $searchModel]);
                ?>
                <hr>
                <?php
                echo GridView::widget(['dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-striped table-bordered'],
                    // 'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'headerOptions' => ['style' => 'width:200px;'],
                            'attribute' => 'customer_user_id',
                            'label' => 'CUSTOMER NAME',
                            'value' => function ($model, $key, $index, $widget) {
                                if (isset($model->customerUser->company_name)) {
                                    return $model->customerUser->company_name;
                                } else {
                                    return $model->customer_user_id;
                                }
                            },
                            'filter' => Select2::widget([
                                'model' => $searchModel,
                                'attribute' => 'customer_user_id',
                                'options' => ['placeholder' => 'Select Custoner Name ...'],
                                'data' => common\models\Consignee::getCustomer(),
                                // ... other params
                            ]),
                        ],
                        [
                            'attribute' => 'container_number',
                            'format' => 'html',
                            'value' => function ($model) {
                                $vehicle_export_id = \common\models\VehicleExport::find()->where(['=', 'vehicle_id', $model->id])->one();
                                if ($vehicle_export_id) {
                                    $export_id = \common\models\Export::find()->where(['=', 'id', $vehicle_export_id->export_id])->one();
                                    if ($export_id) {
                                        return Html::a($export_id->container_number, ['/export/view', 'id' => $export_id->id], ['target' => '_blank']);
                                    }
                                }
                            },
                        ],
                        // 'year',
                        // 'make',
                        // 'model',
                        //'vin',
                        [
                            'attribute' => 'vin',
                            'format' => 'html',
                            'value' => function ($model) {
                                return Html::a($model->vin, ['/vehicle/view', 'id' => $model->id], ['target' => '_blank']);
                            },
                        ],
                        [
                            'label' => 'STATUS',
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return \common\models\Lookup::$status_picked[$model->status];
                            },
                            'filter' => [1 => 'ON HAND', 2 => 'MANIFEST', 3 => 'ON THE WAY', 4 => 'SHIPPED', '' => 'No Status'],
                        ],

                        'lot_number',
                        [
                            'header' => 'ALL VEHICLE',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return "<div class='payment_button_lease_close' ><a target='_blank' href='../vehicle/index?VehicleSearch[customer_user_id]=".$model->customer_user_id."'  >View</a></div>";
                            },
                        ],
                        [
                            'header' => 'ALL EXPORT',
                            'format' => 'html',
                            'value' => function ($model) {
                                return Html::a('View', ['/export/index', 'ExportSearch'.'[customer_user_id]' => $model->customer_user_id], ['target' => '_blank']);
                            },
                        ],
                        [
                            'header' => 'CURRENT EXPORT',
                            'format' => 'html',
                            'value' => function ($model) {
                                //if ($model->container_number) {
                                $vehicle_export_id = \common\models\VehicleExport::find()->where(['=', 'vehicle_id', $model->id])->one();
                                if ($vehicle_export_id) {
                                    $export_id = \common\models\Export::find()->where(['=', 'id', $vehicle_export_id->export_id])->one();
                                    if ($export_id) {
                                        return Html::a('View', ['/export/view', 'id' => $export_id->id], ['target' => '_blank']);
                                    }
                                }
                                //}
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
                        // [
                        //  'header' => 'CURRENT CUSTOMER',
                        //  'format' => 'html',
                        //  'value' => function ($model) {
                        //      return Html::a('View', ['/customer/view', 'id' => $model->customer_user_id], ['target' => '_blank']);
                        //  },
                        // ],
                        ['class' => 'yii\grid\ActionColumn',
                            'options' => ['class' => 'action-column'],
                            'template' => '{manifest}',
                            'header' => 'DETAILS',
                            'buttons' => [
                                'manifest' => function ($url, $model, $key) {
                                    $vehicle_export_id = \common\models\VehicleExport::find()->where(['=', 'vehicle_id', $key])->one();
                                    if ($vehicle_export_id) {
                                        $export_id = \common\models\Export::find()->where(['=', 'id', $vehicle_export_id->export_id])->one();
                                        if ($export_id) {
                                            $btn = Html::a("<button class='btn btn-primary'>MANIFEST</button>", [''], [
                                                'value' => Yii::$app->urlManager->createUrl('/export/manifestmodal?id='.$vehicle_export_id->export_id), //<---- here is where you define the action that handles the ajax request
                                                'class' => 'click_modal grid-action',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'bottom',
                                                'title' => 'Update',
                                            ]);
                                            $btn2 = Html::a("<button class='btn btn-primary'>BL</button>", [''], [
                                                'value' => Yii::$app->urlManager->createUrl('/export/ladingmodal?id='.$vehicle_export_id->export_id), //<---- here is where you define the action that handles the ajax request
                                                'class' => 'click_modal grid-action',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'bottom',
                                                'title' => 'Update',
                                            ]);

                                            return $btn.$btn2;
                                        } else {
                                            return '-';
                                        }
                                    }
                                },
                            ],
                        ],
                    ],
                ]);
                ?>
                <?php ActiveForm::end(); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
<!-- tab section -->
<div class="container-fluid class-using-index">
    <div id="custom_carousel" class="carousel slide" data-ride="carousel" data-interval="">
        <div class="controls">
            <ul class="nav">
                <li data-target="#custom_carousel" class="active" data-slide-to="0">
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
                <li data-target="#custom_carousel" data-slide-to="1">
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
                <li data-target="#custom_carousel" data-slide-to="2">
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
                <li data-target="#custom_carousel" data-slide-to="3">
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
                <li data-target="#custom_carousel" data-slide-to="4">
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
                <li data-target="#custom_carousel" data-slide-to="5">
                    <a href="#">
                        <div class="box-body2">
                            <p class="box-text2">LOCATION: <strong style=''>MD</strong><br>
                                ON THE WAY <span class="states">
                        <?=$vehicle_location_MD['car_on_way']; ?>
                        </span><br>
                                ON THE HAND <span class="states">
                        <?=$vehicle_location_MD['on_hand']; ?>
                        </span><br>
                                SHIPPED<span class="states">
                        <?=$vehicle_location_MD['shipped']; ?>
                        </span>
                            </p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item active">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="">   ORDER OVERVIEW     </h3>
                            <?php
                            echo GoogleChart::widget(array('visualization' => 'PieChart',
                                'data' => array(
                                    array('Task', 'All Status'),
                                    array('Dispatched    '.$all_vehicle['car_on_way'], (int) $all_vehicle['car_on_way']),
                                    array('On Hand    '.$all_vehicle['on_hand'], (int) $all_vehicle['on_hand']),
                                    array('Manifest   ' . $all_vehicle['manifest'], (int) $all_vehicle['manifest']),
                                    array('Shipped   '.$all_vehicle['shipped'], (int) $all_vehicle['shipped']),
                                ),
                                'options' => array('title' => 'All', 'chartArea' => ['left' => 50, 'top' => 0, 'width' => '100%', 'height' => '100%'], 'width' => 480,
                                    'height' => 400, 'pieHole' => 0.4, 'colors' => ['#420e0e', '#b18b1d', '#000'], 'pieSliceText' => 'none', 'legend' => ['position' => 'right'], ), ));
                            ?>
                        </div>
                        <div class="col-md-6">
                            <h3 class="pull-left"> VEHICLE STATUS  </h3>
                            <span cursor="pointer" include="1" status="On hand" location="" class="labels label-danger all-status pull-right" id="1">Inventory Report</span>
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
                                    <td><?=$all_vehicle['all']; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>DISPATCHED</td>
                                    <td><?=$all_vehicle['car_on_way']; ?></td>
                                    <td><span cursor="pointer" status="ON THE WAY" class="labels label-danger all-status" id="3">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=3&location=&status=ON THE WAY" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[status]=3" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>ON HAND</td>
                                    <td><?=$all_vehicle['on_hand']; ?></td>
                                    <td><span cursor="pointer" status="On Hand" class="labels label-danger all-status" id="1">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=1&location=&status=On Hand" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[status]=1" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>MANIFEST</td>
                                    <td><?php echo $all_vehicle['manifest']; ?></td>
                                    <td><span cursor="pointer" status="Manifest" class="labels label-danger all-status" id="2">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=2&location=&status=Manifest" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[status]=2" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>SHIPPED </td>
                                    <td><?=$all_vehicle['shipped']; ?></td>
                                    <td><span cursor="pointer" status="Shipped" class="labels label-danger all-status" id="4">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=4&status=Shipped" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[status]=4" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>ARRIVED</td>
                                    <td><?php echo $all_vehicle['arrived']; ?></td>
                                    <td><span cursor="pointer" status="arrived" class="labels label-danger all-status" id="6">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=6&location=&status=arrived" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[status]=6" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>WITH TITLE</td>
                                    <td><?=$all_vehicle['with_title']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>W/O TITLE</td>
                                    <td><?=$all_vehicle['with_out_title']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>CAR TOWED</td>
                                    <td><?=$all_vehicle['towed']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[towed]=1" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>Not Towed</td>
                                    <td><?=$all_vehicle['not_towed']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[towed]=0" target="_blank">View</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="">   ORDER OVERVIEW     </h3>
                            <?php
                            echo GoogleChart::widget(array('visualization' => 'PieChart',
                                'data' => array(
                                    array('Task', 'All Statuses'),
                                    array('Car on Way    '.$vehicle_location_LA['car_on_way'], (int) $vehicle_location_LA['car_on_way']),
                                    array('On Hand    '.$vehicle_location_LA['on_hand'], (int) $vehicle_location_LA['on_hand']),
                                    array('Manifest   ' . $vehicle_location_LA['manifest'], (int)$vehicle_location_LA['manifest']),
                                    array('Shipped   '.$vehicle_location_LA['shipped'], (int) $vehicle_location_LA['shipped']),
                                ),
                                'options' => array('title' => 'LA', 'chartArea' => ['left' => 50, 'top' => 0, 'width' => '100%', 'height' => '100%'], 'width' => 480,
                                    'height' => 400, 'pieHole' => 0.4, 'colors' => ['#420e0e', '#b18b1d', '#000'], 'pieSliceText' => 'none', 'legend' => ['legendShape' => 'square'], ), ));
                            ?>
                        </div>
                        <div class="col-md-6">
                            <h3 class="pull-left"> VEHICLE STATUS  </h3>
                            <span cursor="pointer" include="1" status="On hand" location="1" class="labels label-danger all-status pull-right" id="1">Inventory Report</span>
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
                                    <td><?=$vehicle_location_LA['all']; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>DISPATCHED</td>
                                    <td><?=$vehicle_location_LA['car_on_way']; ?></td>
                                    <td><span cursor="pointer" status="ON THE WAY" location="1" class="labels label-danger all-status" id="3">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=3&location=1&status=ON THE WAY" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1&VehicleSearch[status]=3" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>ON HAND</td>
                                    <td><?=$vehicle_location_LA['on_hand']; ?></td>
                                    <td><span cursor="pointer" status="On hand" location="1" class="labels label-danger all-status" id="1">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=1&location=1&status=On hand" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1&VehicleSearch[status]=1" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>MANIFEST</td>
                                    <td><?php echo $vehicle_location_LA['manifest']; ?></td>
                                    <td><span cursor="pointer" location='1' status="Manifest" class="labels label-danger all-status" id="2">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=2&location=1&status=Manifest" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1&VehicleSearch[status]=2" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>SHIPPED</td>
                                    <td><?=$vehicle_location_LA['shipped']; ?></td>
                                    <td><span cursor="pointer" location='1' status="Shipped" class="labels label-danger all-status" id="4">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=4&location=1&status=Shipped" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1&VehicleSearch[status]=4" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>ARRIVED</td>
                                    <td><?php echo $vehicle_location_LA['arrived']; ?></td>
                                    <td><span cursor="pointer" location='1' status="arrived" class="labels label-danger all-status" id="6">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=6&location=1&status=arrived" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1&VehicleSearch[status]=6" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>WITH TITLE</td>
                                    <td><?=$vehicle_location_LA['with_title']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index/?VehicleSearch[location]=1&VehicleSearch[status]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>W/O TITLE</td>
                                    <td><?=$vehicle_location_LA['with_out_title']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>CAR TOWED</td>
                                    <td><?=$vehicle_location_LA['towed']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1&VehicleSearch[towed]=1" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>NOT TOWED</td>
                                    <td><?=$vehicle_location_LA['not_towed']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1" target="_blank">View</a></td>
                                </tr>
                                <tr style='display:none;'>
                                    <td>TOWED WITH TITLE </td>
                                    <td><?=$vehicle_location_LA['towed_with_title']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1" target="_blank">View</a></td>
                                </tr>
                                <tr style='display:none;'>
                                    <td>TOWED W/O TITLE </td>
                                    <td><?=$vehicle_location_LA['towed_with_out_title']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=1" target="_blank">View</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="">   ORDER OVERVIEW     </h3>
                            <?php
                            echo GoogleChart::widget(array('visualization' => 'PieChart',
                                'data' => array(
                                    array('Task', 'All Statuses'),
                                    array('Dispatched    '.$vehicle_location_GA['car_on_way'], (int) $vehicle_location_GA['car_on_way']),
                                    array('On Hand    '.$vehicle_location_GA['on_hand'], (int) $vehicle_location_GA['on_hand']),
                                    array('Manifest   ' . (int) $vehicle_location_GA['manifest'] . '', (int) $vehicle_location_GA['manifest']),
                                    array('Shipped   '.$vehicle_location_GA['shipped'], (int) $vehicle_location_GA['shipped']),
                                ),
                                'options' => array('title' => 'GA', 'chartArea' => ['left' => 50, 'top' => 0, 'width' => '100%', 'height' => '100%'], 'width' => 480,
                                    'height' => 400, 'pieHole' => 0.4, 'colors' => ['#420e0e', '#b18b1d', '#000'], 'pieSliceText' => 'none', 'legend' => ['legendShape' => 'square'], ), ));
                            ?>
                        </div>
                        <div class="col-md-6">
                            <h3 class="pull-left"> VEHICLE STATUS  </h3>
                            <span cursor="pointer" include="1" status="On hand" location="2" class="labels label-danger all-status pull-right" id="1">Inventory Report</span>
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
                                    <td><?=$vehicle_location_GA['all']; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>DISPATCHED</td>
                                    <td><?=$vehicle_location_GA['car_on_way']; ?></td>
                                    <td><span cursor="pointer" status="Car on way" location="2" class="labels label-danger all-status" id="3">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=3&location=2&status=ON THE WAY" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>

                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2&VehicleSearch[status]=3" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>ON HAND</td>
                                    <td><?=$vehicle_location_GA['on_hand']; ?></td>
                                    <td><span cursor="pointer" status="On hand" location="2" class="labels label-danger all-status" id="1">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=1&location=2&status=On hand" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>

                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2&VehicleSearch[status]=1" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>MANIFEST</td>
                                    <td><?php echo $vehicle_location_GA['manifest']; ?></td>
                                    <td><span cursor="pointer" location='2' status="Manifest" class="labels label-danger all-status" id="2">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=2&location=2&status=Manifest" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2&VehicleSearch[status]=2" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>SHIPPED</td>
                                    <td><?=$vehicle_location_GA['shipped']; ?></td>
                                    <td><span cursor="pointer" location='2' status="Shipped" class="labels label-danger all-status" id="4">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=4&location=2&status=Shipped" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2&VehicleSearch[status]=4" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>ARRIVED</td>
                                    <td><?php echo $vehicle_location_GA['arrived']; ?></td>
                                    <td><span cursor="pointer" location='2' status="arrived" class="labels label-danger all-status" id="6">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=6&location=2&status=arrived" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2&VehicleSearch[status]=6" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>WITH TITLE</td>
                                    <td><?=$vehicle_location_GA['with_title']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>W/O TITLE</td>
                                    <td><?=$vehicle_location_GA['with_out_title']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2&VehicleSearch[status]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>CAR TOWED</td>
                                    <td><?=$vehicle_location_GA['towed']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2&VehicleSearch[towed]=1" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>NOT TOWED</td>
                                    <td><?=$vehicle_location_GA['not_towed']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2&VehicleSearch[towed]=0" target="_blank">View</a></td>
                                </tr>
                                <tr style='display:none;'>
                                    <td>TOWED WITH TITLE </td>
                                    <td><?=$vehicle_location_GA['towed_with_title']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                </tr>
                                <tr style='display:none;'>
                                    <td>TOWED W/O TITLE </td>
                                    <td><?=$vehicle_location_GA['towed_with_out_title']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=2&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="">   ORDER OVERVIEW     </h3>
                            <?php
                            echo GoogleChart::widget(array('visualization' => 'PieChart',
                                'data' => array(
                                    array('Task', '2'),
                                    array('Dispatched    '.$vehicle_location_NY['car_on_way'], (int) $vehicle_location_NY['car_on_way']),
                                    array('On Hand    '.$vehicle_location_NY['on_hand'], (int) $vehicle_location_NY['on_hand']),
                                    array('Manifest   ' . (int) $vehicle_location_NY['manifest'] . '', (int) $vehicle_location_NY['manifest']),
                                    array('Shipped   '.$vehicle_location_NY['shipped'], (int) $vehicle_location_NY['shipped']),
                                ),
                                'options' => array('title' => 'NY', 'chartArea' => ['left' => 50, 'top' => 0, 'width' => '100%', 'height' => '100%'], 'width' => 480,
                                    'height' => 400, 'pieHole' => 0.4, 'colors' => ['#420e0e', '#b18b1d', '#000'], 'pieSliceText' => 'none', 'legend' => ['legendShape' => 'square'], ), ));
                            ?>
                        </div>
                        <div class="col-md-6">
                            <h3 class="pull-left"> VEHICLE STATUS  </h3>
                            <span cursor="pointer" include="1" status="On hand" location="3" class="labels label-danger all-status pull-right" id="1">Inventory Report</span>
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
                                    <td><?=$vehicle_location_NY['all']; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>DISPATCHED</td>
                                    <td><?=$vehicle_location_NY['car_on_way']; ?></td>
                                    <td><span cursor="pointer" status="Dispatched" location="3" class="labels label-danger all-status" id="3">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=3&location=3&status=Dispatched" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[status]=3" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>ON HAND</td>
                                    <td><?=$vehicle_location_NY['on_hand']; ?></td>
                                    <td><span cursor="pointer" status="On Hand" location="3" class="labels label-danger all-status" id="1">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=1&location=3&status=On Hand" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[status]=1" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>MANIFEST</td>
                                    <td><?php echo $vehicle_location_NY['manifest']; ?></td>
                                    <td><span cursor="pointer" location=3 status="Manifest" class="labels label-danger all-status" id="2">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=2&location=3&status=Manifest" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[status]=2" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>SHIPPED </td>
                                    <td><?=$vehicle_location_NY['shipped']; ?></td>
                                    <td><span cursor="pointer" location='3' status="Shipped" class="labels label-danger all-status" id="4">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=4&location=3&status=Shipped" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[status]=4" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>ARRIVED</td>
                                    <td><?php echo $vehicle_location_NY['arrived']; ?></td>
                                    <td><span cursor="pointer" location=3 status="arrived" class="labels label-danger all-status" id="6">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=6&location=3&status=arrived" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[status]=6" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>WITH TITLE</td>
                                    <td><?=$vehicle_location_NY['with_title']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>W/O TITLE</td>
                                    <td><?=$vehicle_location_NY['with_out_title']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[status]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>CAR TOWED</td>
                                    <td><?=$vehicle_location_NY['towed']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[towed]=1" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>NOT TOWED</td>
                                    <td><?=$vehicle_location_NY['not_towed']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[towed]=0" target="_blank">View</a></td>
                                </tr>
                                <tr style='display:none;'>
                                    <td>TOWED WITH TITLE </td>
                                    <td><?=$vehicle_location_NY['towed_with_title']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                </tr>
                                <tr style="display:none;">
                                    <td>TOWED W/O TITLE </td>
                                    <td><?=$vehicle_location_NY['towed_with_out_title']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=3&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="">   ORDER OVERVIEW     </h3>
                            <?php
                            echo GoogleChart::widget(array('visualization' => 'PieChart',
                                'data' => array(
                                    array('Task', 'All Statuses'),
                                    array('Dispatched    '.$vehicle_location_TX['car_on_way'], (int) $vehicle_location_TX['car_on_way']),
                                    array('On Hand    '.$vehicle_location_TX['on_hand'], (int) $vehicle_location_TX['on_hand']),
                                    array('Manifest   ' . (int) $vehicle_location_TX['manifest'] . '', (int) $vehicle_location_TX['manifest']),
                                    array('Shipped   '.$vehicle_location_TX['shipped'], (int) $vehicle_location_TX['shipped']),
                                ),
                                'options' => array('title' => 'TX', 'chartArea' => ['left' => 50, 'top' => 0, 'width' => '100%', 'height' => '100%'], 'width' => 480,
                                    'height' => 400, 'pieHole' => 0.4, 'colors' => ['#420e0e', '#b18b1d', '#000'], 'pieSliceText' => 'none', 'legend' => ['legendShape' => 'square'], ), ));
                            ?>
                        </div>
                        <div class="col-md-6">
                            <h3 class="pull-left"> VEHICLE STATUS  </h3>
                            <span cursor="pointer" include="1" status="On hand" location="4" class="labels label-danger all-status pull-right" id="1">Inventory Report</span>
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
                                    <td><?=$vehicle_location_TX['all']; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>DISPATCHED</td>
                                    <td><?=$vehicle_location_TX['car_on_way']; ?></td>
                                    <td><span cursor="pointer" status="Car on way" location="4" class="labels label-danger all-status" id="3">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=3&location=4&status=ON THE WAY" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>

                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&VehicleSearch[status]=3" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>ON HAND</td>
                                    <td><?=$vehicle_location_TX['on_hand']; ?></td>
                                    <td><span cursor="pointer" status="On hand" location="4" class="labels label-danger all-status" id="1">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=1&location=4&status=On hand" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>

                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&VehicleSearch[status]=1" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>MANIFEST</td>
                                    <td><?php echo $vehicle_location_TX['manifest']; ?></td>
                                    <td><span cursor="pointer" location=4 status="Manifest" class="labels label-danger all-status" id="2">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=2&location=4&status=Picked Up" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&VehicleSearch[status]=2" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>SHIPPED</td>
                                    <td><?=$vehicle_location_TX['shipped']; ?></td>
                                    <td><span cursor="pointer" location='4' status="Shipped" class="labels label-danger all-status" id="4">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=4&location=4&status=Shipped" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&VehicleSearch[status]=4" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>ARRIVED</td>
                                    <td><?php echo $vehicle_location_TX['arrived']; ?></td>
                                    <td><span cursor="pointer" location=4 status="arrived" class="labels label-danger all-status" id="6">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=6&location=4&status=arrived" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&VehicleSearch[status]=6" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>WITH TITLE</td>
                                    <td><?=$vehicle_location_TX['with_title']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>W/O TITLE</td>
                                    <td><?=$vehicle_location_TX['with_out_title']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&VehicleSearch[status]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>CAR TOWED</td>
                                    <td><?=$vehicle_location_TX['towed']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&?VehicleSearch[towed]=1" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>NOT TOWED</td>
                                    <td><?=$vehicle_location_TX['not_towed']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&?VehicleSearch[towed]=0" target="_blank">View</a></td>
                                </tr>
                                <tr style='display:none;'>
                                    <td>TOWED WITH TITLE </td>
                                    <td><?=$vehicle_location_TX['towed_with_title']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                </tr>
                                <tr style='display:none;'>
                                    <td>TOWED W/O TITLE </td>
                                    <td><?=$vehicle_location_TX['towed_with_out_title']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=4&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="">   ORDER OVERVIEW     </h3>
                            <?php
                            echo GoogleChart::widget(array('visualization' => 'PieChart',
                                'data' => array(
                                    array('Task', 'All Statuses'),
                                    array('Dispatched    '.$vehicle_location_MD['car_on_way'], (int) $vehicle_location_MD['car_on_way']),
                                    array('On Hand    '.$vehicle_location_MD['on_hand'], (int) $vehicle_location_MD['on_hand']),
                                    array('Manifest   ' . (int) $vehicle_location_MD['manifest'] . '', (int) $vehicle_location_MD['manifest']),
                                    array('Shipped   '.$vehicle_location_MD['shipped'], (int) $vehicle_location_MD['shipped']),
                                ),
                                'options' => array('title' => 'MD', 'chartArea' => ['left' => 50, 'top' => 0, 'width' => '100%', 'height' => '100%'], 'width' => 480,
                                    'height' => 400, 'pieHole' => 0.4, 'colors' => ['#420e0e', '#b18b1d', '#000'], 'pieSliceText' => 'none', 'legend' => ['legendShape' => 'square'], ), ));
                            ?>
                        </div>
                        <div class="col-md-6">
                            <h3 class="pull-left"> VEHICLE STATUS  </h3>
                            <span cursor="pointer" include="1" status="On hand" location="8" class="labels label-danger all-status pull-right" id="1">Inventory Report</span>
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
                                    <td><?=$vehicle_location_MD['all']; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=8" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>DISPATCHED</td>
                                    <td><?=$vehicle_location_MD['car_on_way']; ?></td>
                                    <td><span cursor="pointer" status="Car on way" location="8" class="labels label-danger all-status" id="3">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=3&location=8&status=ON THE WAY" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>

                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=8&VehicleSearch[status]=3" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>ON HAND</td>
                                    <td><?=$vehicle_location_MD['on_hand']; ?></td>
                                    <td><span cursor="pointer" status="On hand" location="8" class="labels label-danger all-status" id="1">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=1&location=8&status=On hand" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>

                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=8&VehicleSearch[status]=1" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>MANIFEST</td>
                                    <td><?php echo $vehicle_location_MD['manifest']; ?></td>
                                    <td><span cursor="pointer" location='8' status="Manifest" class="labels label-danger all-status" id="2">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=2&location=8&status=Manifest" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=8&VehicleSearch[status]=2" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>SHIPPED</td>
                                    <td><?=$vehicle_location_MD['shipped']; ?></td>
                                    <td><span cursor="pointer" location='8' status="Shipped" class="labels label-danger all-status" id="4">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=4&location=8&status=Shipped" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=8&VehicleSearch[status]=4" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>ARRIVED</td>
                                    <td><?php echo $vehicle_location_MD['arrived']; ?></td>
                                    <td><span cursor="pointer" location='8' status="arrived" class="labels label-danger all-status" id="6">Report</span></td>
                                    <td><a class="btn btn-primary open-pdf" href="/site/statuspdf?id=6&location=8&status=arrived" title="Will open the generated PDF file in a new window" target="_blank" data-toggle="tooltip"><i class="status-button fa fa-file-pdf-o"></i> Open as Pdf</a></td>
                                    <td><a href="<?php Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=8&VehicleSearch[status]=6" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>WITH TITLE</td>
                                    <td><?=$vehicle_location_MD['with_title']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=8&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>W/O TITLE</td>
                                    <td><?=$vehicle_location_MD['with_out_title']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=8&VehicleSearch[status]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>CAR TOWED</td>
                                    <td><?=$vehicle_location_MD['towed']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=8&VehicleSearch[towed]=1" target="_blank">View</a></td>
                                </tr>
                                <tr>
                                    <td>NOT TOWED</td>
                                    <td><?=$vehicle_location_MD['not_towed']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=8&VehicleSearch[towed]=0" target="_blank">View</a></td>
                                </tr>
                                <tr style='display:none;'>
                                    <td>TOWED WITH TITLE </td>
                                    <td><?=$vehicle_location_MD['towed_with_title']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=8&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=1" target="_blank">View</a></td>
                                </tr>
                                <tr style='display:none;'>
                                    <td>TOWED W/O TITLE </td>
                                    <td><?=$vehicle_location_MD['towed_with_out_title']; ?></td>
                                    <td></td><td></td>
                                    <td><a href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/index?VehicleSearch[location]=8&VehicleSearch[towed]=1&VehicleSearch[title_recieved]=0" target="_blank">View</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

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
                echo Html::a('<i class="status-button inventory-status fa fa-file-pdf-o"></i> Open as Pdf', ['/site/inventory-report', 'id' => -1], [
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
    $(document).ready(function(ev){
        $('#custom_carousel').on('slide.bs.carousel', function (evt) {
            $('#custom_carousel .controls li.active').removeClass('active');
            $('#custom_carousel .controls li:eq('+$(evt.relatedTarget).index()+')').addClass('active');
        })
    });
    $("body").delegate(".all-status", "click", function () {
        $("#myModal").modal();

        var id =    $(this).attr('id');
        var location = '';
        var include_on_the_way = false;
        if($(this).attr('location')){
            location =    $(this).attr('location');
        }
        if($(this).attr('include')){
            include_on_the_way =    $(this).attr('include');
        }
        var status = $(this).attr('status');
        var newHref;
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