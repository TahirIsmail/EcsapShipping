<?php

use lavrentiev\widgets\toastr\Notification;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Export */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Exports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="export-view">
    <h1><?php //Html::encode($this->title)      ?></h1>
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

    ?>
    <p>
        <?= Html::button(Yii::t('app', 'Update'), [
            'value' => Yii::$app->urlManager->createUrl('export/update?id=' . $model->id),
            'class' => 'btn btn-primary click_modal'
        ]) ?>
        <?= Html::button(Yii::t('app', 'Dock Reciept'), [
            'value' => Yii::$app->urlManager->createUrl('export/dockmodal?id=' . $model->id),
            'class' => 'btn btn-primary click_modal_report',
            'target' => '_blank'
        ]) ?>
        <?= Html::button(Yii::t('app', 'Houston Cover Letter'), [
            'value' => Yii::$app->urlManager->createUrl('export/hustomcoverlettermodal?id=' . $model->id),
            'class' => 'btn btn-primary click_modal_report'
        ]) ?>
        <?= Html::button(Yii::t('app', 'Customs Cover Letter'), [
            'value' => Yii::$app->urlManager->createUrl('export/customcoverlettermodal?id=' . $model->id),
            'class' => 'btn btn-primary click_modal_report'
        ]) ?>
        <?= Html::button(Yii::t('app', 'Manifest'), [
            'value' => Yii::$app->urlManager->createUrl('export/manifestmodal?id=' . $model->id),
            'class' => 'btn btn-primary click_modal_report'
        ]) ?>
        <?= Html::button(Yii::t('app', 'Bill of Lading'), [
            'value' => Yii::$app->urlManager->createUrl('export/ladingmodal?id=' . $model->id),
            'class' => 'btn btn-primary click_modal_report'
        ]) ?>
        <?= Html::button(Yii::t('app', 'Non-Haz'), [
            'value' => Yii::$app->urlManager->createUrl('export/nonhazmodal?id=' . $model->id),
            'class' => 'btn btn-primary click_modal_report'
        ]) ?>


        <?php
        Modal::begin([

            'id' => 'modal',
            'size' => 'modal-lg',
        ]);

        echo '<div id="modalContent"></div>';

        Modal::end();
        ?>
        <?php
        Modal::begin([

            'id' => 'modal-report',
            'size' => 'modal-lg',
        ]);

        echo '<div id="modalContentreport"></div>';

        Modal::end();
        ?>

    <div class="white-box">
        <div class="row">

            <div class="col-md-4">
                <h4>Export Detail</h4>
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [

                        'export_date',
                        'loading_date',
                        'broker_name',
                        'booking_number',
                        'eta',
                        'ar_number',
                        'xtn_number',
                        'seal_number',
                        'container_number',
                        'cutt_off',
                        'vessel',
                        'voyage',
                        'terminal',
                        'streamship_line',
                        // 'destination',
                        'itn',
                        // 'contact_details:ntext',
                        // 'special_instruction:ntext',

                        [
                            'label' => "CONTAINER TYPE",

                            'value' => function ($model) {

                                return \yii\helpers\ArrayHelper::getValue(\common\models\Lookup::$container_type,
                                    $model->container_type);

                            },

                        ],
                        'port_of_loading',
                        'port_of_discharge',
                        'bol_note',
                        // 'is_deleted:boolean',
                        // 'created_by',
                        // 'updated_by',
                        //'created_at',
                        //'updated_at',
                    ],
                ])
                ?>
            </div>
            <div class="col-md-4">
                <h4>Houston Custom Cover Letter</h4>
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'export_date',
                        'houstanCustomCoverLetter.vehicle_location',
                        'houstanCustomCoverLetter.exporter_id',
                        'houstanCustomCoverLetter.exporter_type_issuer',
                        'houstanCustomCoverLetter.transportation_value',
                        // 'houstanCustomCoverLetter.exporter_dob',
                        // 'houstanCustomCoverLetter.ultimate_consignee_dob',
                        [
                            'label' => 'EXPORTER DOB',
                            'value' => function ($model) {
                                if ($model->houstanCustomCoverLetter) {
                                    return $model->houstanCustomCoverLetter->exporter_dob;
                                }
                            },
                        ],
                        [
                            'label' => 'ULTIMATE CONSIGNEE DOB',
                            'value' => function ($model) {
                                if ($model->houstanCustomCoverLetter) {
                                    return $model->houstanCustomCoverLetter->ultimate_consignee_dob;
                                }

                            },
                        ],
                        [
                            'label' => 'CONSIGNEE',
                            'attribute' => 'consignee',
                            'value' => function ($model) {
                                if (isset($model->houstanCustomCoverLetter->consignee)) {
                                    $consignee = \common\models\Consignee::findOne($model->houstanCustomCoverLetter->consignee);
                                    return isset($consignee->consignee_name) ? $consignee->consignee_name : "";
                                    /*
                                    $consignee = \common\models\Consignee::find(['id' => $model->houstanCustomCoverLetter->consignee])->asArray()->one();
                                    if($consignee){
                                        return $consignee['consignee_name'];
                                    }
                                    */
                                }
                            },
                        ],
                        [
                            'label' => 'NOTIFY PARTY',
                            'attribute' => 'Notify_party',
                            'value' => function ($model) {
                                if ($model->houstanCustomCoverLetter) {
                                    $notify_party = \common\models\Consignee::findOne($model->houstanCustomCoverLetter->notify_party);
                                    return isset($notify_party->consignee_name) ? $notify_party->consignee_name : "";
                                }
                            },
                        ],
                        [
                            'label' => 'LABEL',
                            'attribute' => 'Manifest',
                            'value' => function ($model) {
                                if ($model->houstanCustomCoverLetter) {
                                    $menifest = \common\models\Consignee::findOne($model->houstanCustomCoverLetter->menifest_consignee);
                                    return isset($menifest->consignee_name) ? $menifest->consignee_name : "";
                                }
                            },
                        ],

                    ],
                ])
                ?>
            </div>
            <div class="col-md-4">

                <h4>Customer Information</h4>
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'dockReceipt.export.customerUser.customer_name',
                        [
                            'label' => 'CUSTOMER ID',
                            'value' => function ($model) {
                                if ($model->customerUser) {
                                    return $model->customerUser->legacy_customer_id;
                                }
                            },
                        ],
                        'dockReceipt.export.customerUser.company_name',
                        [
                            'label' => 'EMAIL',
                            'value' => function ($model) {
                                if (isset($model->user->email)) {
                                    return $model->user->email;
                                }
                            }
                        ]

                    ],
                ]);
                if ($model->export_invoice) {
                    ?>
                    <h4>Download Invoice</h4>
                    <a href="<?php echo \yii\helpers\Url::to('@web/uploads/' . $model->export_invoice, true) ?>"
                       target="_blank"><img src="<?= \yii\helpers\Url::to('@web/uploads/images/invoice.jpg', true) ?>"
                                            width="150" height="150"></a>
                <?php } else { ?>
                    <h4>No Invoice Uploaded</h4>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <h4>Export Vehicles</h4>
        <table class="jsgrid-table">
            <thead>
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-header-sortable" style="width: auto;">YEAR</th>
                <th class="jsgrid-header-cell jsgrid-header-sortable" style="width: auto;">MAKE</th>
                <th class="jsgrid-header-cell jsgrid-header-sortable" style="width: auto;">MODEL</th>
                <th class="jsgrid-header-cell jsgrid-header-sortable" style="width: auto;">COLOR</th>
                <th class="jsgrid-header-cell jsgrid-header-sortable" style="width: 160px;">VIN</th>
                <th class="jsgrid-header-cell jsgrid-header-sortable" style="width: auto;">STATUS</th>
                <th class="jsgrid-header-cell jsgrid-header-sortable" style="width: auto;">TITLE NO</th>
                <th class="jsgrid-header-cell jsgrid-header-sortable" style="width: auto;">TITLE STATE</th>
                <th class="jsgrid-header-cell jsgrid-header-sortable" style="width: auto;">LOT NO</th>
                <th class="jsgrid-header-cell jsgrid-header-sortable" style="width: auto;">VIEW</th>

            </tr>
            </thead>
            <tbody>
            <?php
            $all_vehicles_ids = $model->vehicleExports;
            foreach ($all_vehicles_ids as $all_vehicles_id) {
                $singel_vehicle = common\models\Vehicle::find()->where([
                    '=',
                    'id',
                    $all_vehicles_id->vehicle_id
                ])->one();
                $singel_towing = common\models\TowingRequest::find()->where([
                    '=',
                    'id',
                    $singel_vehicle->towing_request_id
                ])->one();
                $status = isset(\common\models\Lookup::$status[$singel_vehicle->status]) ? \common\models\Lookup::$status[$singel_vehicle->status] : $singel_vehicle->status;
                $vex = \common\models\VehicleExport::find()->where(['vehicle_id' => $singel_vehicle->id])->andWhere('vehicle_export_is_deleted != 1')->one();
                $med = \common\models\Export::find()->where(['id' => $vex->export_id])->one();

                if (!empty($med['eta']) && $med['eta'] <= date("Y-m-d") && $med['eta'] > $med['export_date']) {
                    $status = 'ARRIVED';
                } else if (!empty($med['export_date']) && $med['export_date'] < date("Y-m-d")) {
                    $status = 'SHIPPED';
                }
                if (\common\models\Lookup::isAdmin() || Yii::$app->user->id == $singel_vehicle->customer_user_id) {
                    ?>
                    <tr class="jsgrid-row">
                        <td class="jsgrid-cell" style="width: auto;"><?= $singel_vehicle->year ?></td>
                        <td class="jsgrid-cell" style="width: auto;"><?= $singel_vehicle->make ?></td>
                        <td class="jsgrid-cell" style="width: auto;"><?= $singel_vehicle->model ?></td>
                        <td class="jsgrid-cell" style="width: auto;"><?= $singel_vehicle->color ?></td>
                        <td class="jsgrid-cell" style="width: 50px;"><?= $singel_vehicle->vin ?></td>
                        <td class="jsgrid-cell" style="width: auto;"><?php if ($singel_vehicle->status) {
                                echo $status;
                            } ?></td>
                        <td class="jsgrid-cell" style="width: auto;"><?= $singel_towing->title_number; ?></td>
                        <td class="jsgrid-cell" style="width: auto;"><?php if ($singel_vehicle->location) {
                                echo \common\models\Lookup::$location[$singel_vehicle->location];
                            } ?></td>
                        <td class="jsgrid-cell"
                            style="width: auto;white-space: nowrap;"><?= $singel_vehicle->lot_number ?></td>
                        <td class="jsgrid-cell" style="width: auto;"><a
                                    href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/vehicle/view?id=<?= $singel_vehicle->id; ?>"
                                    target="_blank">View</a></td>
                    </tr>
                    <?php
                }
            }
            ?>            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-12" style="text-align: center;">
            <!--<h4>Container Images Gallery</h4>-->
            <br>  
            <?php
            echo Html::a('<i class="fa fa-download"></i> Download Container Images', ['/export/download-images', 'id' => $model->id], [
                'class' => 'btn btn-primary',
                'target' => '_blank',
                'data-toggle' => 'tooltip',
                'title' => 'Will send the download the images',
            ]);
            ?>
            <?php
            //Commented below to adjust the image size | 22122020
            // $items = array();
            // $saj = array();
            // foreach ($model->exportImages as $gallery) {

            //     $saj[] = [
            //         'url' => \yii\helpers\Url::to('@web/uploads/' . $gallery->name, true),
            //         'src' => \yii\helpers\Url::to('@web/uploads/' . $gallery->thumbnail, true),
            //         'options' => array('title' => 'Images Gallery'),
            //     ];
            // }
            // // var_dump($saj);
            // $items = $saj;
            // ?>
            <?= '';//remove ''; 22122020 // dosamigos\gallery\Gallery::widget(['items' => $items]); ?>
            
            <h4>Container Images Gallery</h4>
            <?php

           
             $items = array();
             $saj =array();
            foreach($model->exportImages as $gallery){
              ?>
            <a data-fancybox="images" href="<?=\yii\helpers\Url::to('@web/../uploads/'.$gallery->name, true)?>">
                <img style="width:120px;height:120px;" class="img-fluid" src="<?= \yii\helpers\Url::to('@web/../uploads/'.$gallery->thumbnail, true) ?>">
            </a>
               <?php
             
         
          } 

        
          ?>
        </div>
    </div>
</div>
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