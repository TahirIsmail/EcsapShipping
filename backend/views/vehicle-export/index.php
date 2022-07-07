<?php

use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\data\SqlDataProvider;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\VehicleExportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'AUTO CONTAINER');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicle-export-index">
    <div class="white-box">
        <div class="">
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
                <h1><?=Html::encode($this->title); ?></h1>
            </div>
                <?php //Pjax::begin();?>
            <div class="col-md-6">
				<?php echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
</div>
            
            <?php
$user_id = Yii::$app->user->getId();
$Role = Yii::$app->authManager->getRolesByUser($user_id);
if (isset($Role['customer'])) {
    ?>
                <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed'],
        'bootstrap' => true,
        'condensed' => true,
        //  'perfectScrollbar'=>true,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'expandAllTitle' => 'EXPAND ALL',
                'collapseTitle' => 'COLLAPSE ALL',
                'expandIcon' => 'VIEW',
                'collapseIcon' => 'CLOSE',

                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model, $key, $index, $column) {
                    $searchModel = new \common\models\VehicleSearch();
                    //   $all_vehicele = Yii::$app->db->createCommand('SELECT * FROM vehicle v where v.id in (SELECT vf.vehicle_id FROM vehicle_export vf  where vf.export_id='.$model->export_id.'))->queryAll();
                    $user_id = Yii::$app->user->getId();
                    $Role = Yii::$app->authManager->getRolesByUser($user_id);
                    if (isset($Role['customer'])) {
                        $provider = new SqlDataProvider([
                            'sql' => 'SELECT * FROM vehicle v where v.customer_user_id = '.$user_id.' AND  v.id in (SELECT vf.vehicle_id FROM vehicle_export vf  where vf.export_id='.$model->export_id.')',
                            // 'params' => [':status' => 1],
                            'totalCount' => 6,
                            'pagination' => [
                                'pageSize' => 100,
                            ],
                            'sort' => [
                                'attributes' => [
                                    'title',
                                    'view_count',
                                    'created_at',
                                ],
                            ],
                        ]);
                    } else {
                        $provider = new SqlDataProvider([
                            'sql' => 'SELECT * FROM vehicle v where v.id in (SELECT vf.vehicle_id FROM vehicle_export vf  where vf.export_id='.$model->export_id.')',
                            // 'params' => [':status' => 1],
                            'totalCount' => 6,
                            'pagination' => [
                                'pageSize' => 100,
                            ],
                            'sort' => [
                                'attributes' => [
                                    'title',
                                    'view_count',
                                    'created_at',
                                ],
                            ],
                        ]);
                    }

                    //  $searchModel->customer_user_id = $model->customer_user_id;
                    return Yii::$app->controller->renderPartial('vehicles', [
                        'searchModel' => $searchModel,
                        'dataProviders' => $provider,
                    ]);
                },
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'expandOneOnly' => true,
            ],
            //   'id',
            // 'export_id',
            'export.ar_number',

            [
                'header' => 'PHOTOS',
                'format' => 'raw',
                'value' => function ($model) {
                    $image = isset($model->export->exportImages) ? $model->export->exportImages : null;
                    $x = $model->export_id;
                    if (isset($image[0]['thumbnail'])) {
                        return '<a id="'.$x.'"><img class="images_export" src="'.\yii\helpers\Url::to('@web/uploads/'.$image[0]->thumbnail, ['class' => 'image_cont']).'"></a>';
                    }
                },
            ],
            'export.container_number',
            'export.booking_number',
            [
                'label' => 'B/L',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('View', [''], [
                        'value' => Yii::$app->urlManager->createUrl('export/ladingmodal?id='.$model->export_id), //<---- here is where you define the action that handles the ajax request
                        'class' => 'click_modal_report grid-action',
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'bottom',
                        'title' => 'Update',
                    ]);
                },
            ],
            [
                'label' => 'MANIFEST',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('View', [''], [
                        'value' => Yii::$app->urlManager->createUrl('export/manifestmodal?id='.$model->export_id), //<---- here is where you define the action that handles the ajax request
                        'class' => 'click_modal_report grid-action',
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'bottom',
                        'title' => 'Update',
                    ]);
                },
            ],
            [
                'header' => 'POD',
                'attribute' => 'pod',
                'headerOptions' => ['style' => 'width:40px;'],
                //'filter'=>[1=>"ON HAND",2=>"MANIFEST",3=>"ON THE WAY",4=>"SHIPPED",''=>"No Status"],
                'value' => function ($model) {
                    $vehicle = \common\models\Vehicle::findOne(['id' => $model->vehicle_id]);
                    if ($vehicle) {
                        return isset(\common\models\Lookup::$location[$vehicle->location]) ? \common\models\Lookup::$location[$vehicle->location] : $vehicle->location;
                    }
                },
                'filter' => [1 => 'LA', 2 => 'GA', 3 => 'NY', 4 => 'TX', 5 => 'TX2', 6 => 'NJ2', 7=>'CA'],
            ],
            //'export.port_of_discharge',
            [
                'header' => 'LOADED DATE',
                'value' => 'export.loading_date',
                'attribute' => 'loading_date',
                'headerOptions' => ['style' => 'width:100px;'],
            ],
            [
                'header' => 'EXPORT DATE',
                'attribute' => 'export_date',
                'value' => 'export.export_date',
                'headerOptions' => ['style' => 'width:100px;'],
            ],
            [
                'attribute' => 'eta',
                'headerOptions' => ['style' => 'width:100px;'],
                'value' => 'export.eta',
            ],
            [
                'label' => 'INVOICE',
                'format' => 'raw',
                'value' => function ($model) {
                    if (isset($model->export->export_invoice) && !empty($model->export->export_invoice)) {
                        return "<a target='_blank' href=".Yii::$app->urlManager->createUrl('/uploads/'.$model->export->export_invoice).'>Invoice<a>';
                    } else {
                        return '-';
                    }

                    $dockrecipt = \common\models\Invoice::find()->where(['=', 'export_id', $model->export_id])->andWhere(['=', 'customer_user_id', $model->customer_user_id])->one();
                    if ($dockrecipt) {
                        return Html::a('View', [''], [
                            'value' => Yii::$app->urlManager->createUrl('invoice/customerinvoice?id='.$dockrecipt->id), //<---- here is where you define the action that handles the ajax request
                            'class' => 'click_modal_report grid-action',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'bottom',
                            'title' => 'Update',
                        ]);
                    } else {
                        return '';
                    }
                },
            ],
            [
                'label' => 'INVOICE AMOUNT',
                'format' => 'raw',
                'value' => function ($model) {
                    $dockrecipt = \common\models\Invoice::find()->where(['=', 'export_id', $model->export_id])->andWhere(['=', 'customer_user_id', $model->customer_user_id])->one();

                    if ($dockrecipt) {
                        return $dockrecipt->total_amount;
                    } else {
                        return '';
                    }
                },
            ],
            [
                'label' => 'PAID AMOUNT',
                'format' => 'raw',
                'value' => function ($model) {
                    $dockrecipt = \common\models\Invoice::find()->where(['=', 'export_id', $model->export_id])->andWhere(['=', 'customer_user_id', $model->customer_user_id])->one();

                    if ($dockrecipt) {
                        return $dockrecipt->paid_amount;
                    } else {
                        return '';
                    }
                },
            ],
            [
                'label' => 'NOTE',
                'format' => 'raw',
                'value' => function ($model) {
                    $notes = \common\models\Note::find()->where(['export_id' => $model->export_id])->all();
                    if ($notes) {
                        $class = 'link_red';
                    } else {
                        $class = 'link_blue';
                    }

                    return Html::a('NOTES', [''], [
                        'value' => Yii::$app->urlManager->createUrl('export/notesmodal?id='.$model->export_id), //<---- here is where you define the action that handles the ajax request
                        'class' => 'click_modal_report grid-action '.$class.'',
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'bottom',
                        'title' => 'Update',
                    ]);
                },
            ],

//             'export.booking_number',
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
                    <?php
} else {
        ?>
                        <?=
    GridView::widget([
        'bootstrap' => true,
        'condensed' => true,
        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed'],
        //'perfectScrollbar'=>true,
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //   'id',
            // 'export_id',
            [
                'attribute' => 'export.loading_date',
                'headerOptions' => ['style' => 'width:80px;'],
            ],
            [
                'attribute' => 'export.export_date',
                'headerOptions' => ['style' => 'width:80px;'],
            ],
            [
                'header'=>'Status',
                'format'=>'raw',
                'value'=>function($model){
                    $vx = \common\models\VehicleExport::find()->joinWith(['vehicle'])->where('export_id', $model->id)->one();
                    if(!empty($vx['vehicle']['status']) && ($vx['vehicle']['status'] == 2 || $vx['vehicle']['status'] == 4)) {
                        return \common\models\Lookup::$status[$vx['vehicle']['status']];
                    }

                    return '';
                }
            ],
            [
                'attribute' => 'eta',
                'headerOptions' => ['style' => 'width:100px;'],
                'value' => 'export.eta',
            ],
            'export.booking_number',
            [
                'header'=>'CONTAINER NO',
                'format'=>'html',
                'value'=>function($model){
                    return "<a href='".Yii::$app->urlManager->createUrl('/export/index?ExportSearch[export_global_search]=' . $model['export']['container_number'])."'>".$model['export']['container_number']."<a>";
                }
            ],
            'export.ar_number',
            'export.terminal',
            'export.vessel',
            'export.destination',
            [
                'label' => 'NOTE',
                'format' => 'raw',
                'value' => function ($model) {
                    $export = \common\models\Export::findOne(['id' => $model->export_id]);
                    if ($export) {
                        if ($export->notes_status == '1') {
                            $class = 'link_green';
                            $title = 'Closed';
                        } else {
                            //$notes = \common\models\Note::find()->where(['export_id' => $model->export_id])->all();
                            if ($export->notes_status == '2') {
                                $class = 'link_red';
                                $title = 'Open';
                            } else {
                                $class = 'link_blue';
                                $title = 'Notes';
                            }
                        }

                        return Html::a("$title", [''], [
                            'value' => Yii::$app->urlManager->createUrl('export/notesmodal?id='.$model->export_id), //<---- here is where you define the action that handles the ajax request
                            'class' => 'click_modal_report grid-action '.$class.'',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'bottom',
                            'title' => 'Update',
                        ]);
                    }
                },
            ],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'expandAllTitle' => 'Expand all',
                'collapseTitle' => 'Collapse all',
                'expandIcon' => 'View',
                'collapseIcon' => 'Close',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model, $key, $index, $column) {
                    $searchModel = new \common\models\VehicleSearch();
                    //   $all_vehicele = Yii::$app->db->createCommand('SELECT * FROM vehicle v where v.id in (SELECT vf.vehicle_id FROM vehicle_export vf  where vf.export_id='.$model->export_id.'))->queryAll();
                    $user_id = Yii::$app->user->getId();
                    $Role = Yii::$app->authManager->getRolesByUser($user_id);
                    if (isset($Role['customer'])) {
                        $provider = new SqlDataProvider([
                            'sql' => 'SELECT * FROM vehicle v where v.customer_user_id = '.$user_id.' AND  v.id in (SELECT vf.vehicle_id FROM vehicle_export vf  where vf.export_id='.$model->export_id.') ORDER BY v.id DESC',
                            // 'params' => [':status' => 1],
                            'totalCount' => 6,
                            'pagination' => [
                                'pageSize' => 100,
                            ],
                            'sort' => [
                                'attributes' => [
                                    'title',
                                    'view_count',
                                    'created_at',
                                ],
                            ],
                        ]);
                    } else {
                        $provider = new SqlDataProvider([
                            'sql' => 'SELECT * FROM vehicle v where v.id in (SELECT vf.vehicle_id FROM vehicle_export vf  where vf.export_id='.$model->export_id.') ORDER BY v.id DESC',
                            // 'params' => [':status' => 1],
                            'totalCount' => 6,
                            'pagination' => [
                                'pageSize' => 100,
                            ],
                            'sort' => [
                                'attributes' => [
                                    'title',
                                    'view_count',
                                    'created_at',
                                ],
                            ],
                        ]);
                    }

                    //  $searchModel->customer_user_id = $model->customer_user_id;
                    return Yii::$app->controller->renderPartial('vehicles', [
                        'searchModel' => $searchModel,
                        'dataProviders' => $provider,
                    ]);
                },
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'expandOneOnly' => true,
            ],
            //'export.voyage',
            //'export.terminal',
            //  'export.container_number',
            //'export.broker_name',
//              'export.booking_number',
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    }
?>
                            <?php //Pjax::end();?>

        </div>
    </div>
</div>
<div class="modal fade" id="gallery" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">CONTAINER IMAGES</h4>
                </div>
                <div class="gallery-body">

                </div>
                <div class="gallery-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <script>
    $(document).ready(function(){
                            $('body').delegate(".images_export","click",function(){

                                    var id = $(this).parent().attr('id');
                                   $.ajax({
                                       type : 'POST',
                                       data : {id:id},
                                       url :  "<?=Yii::$app->getUrlManager()->createUrl('vehicle-export/container-images'); ?>",
                                       success: function(data){
                                         $("#gallery").modal();
                                         $('.gallery-body').html(data);
                                       },
                                       error: function (exception) {
                               alert(exception);
                                        }
                                   })
                                })
                            })
                            $("body").on("click", ".notes_vehicle", function () {

                                var formData = new FormData($('#notes-form')[0]);
                                $.ajax({
                                    type: "POST",
                                    data:  formData,
                                    // data: "id="+id+"status+"+status,
                                    url: "<?php echo Yii::$app->getUrlManager()->createUrl('export/notes'); ?>",
                                    success: function (test) {
                                        // $('.show-notes').html(test);
                                    //    alert(test);
                                        $('.modal-footer ul').prepend(test);
                                        $("#notes-form").yiiActiveForm('resetForm');
                                    },
                                    error: function (exception) {
                                        alert(exception);
                                    },
                                    cache: false,
                            contentType: false,
                            processData: false
                                });
                        });


        $("body").delegate(".close_conversatition", "click", function () {

       var id =    $(this).attr('key');
       var open =    $(this).attr('data');

            $.ajax({
                type: "POST",
                data:  {id:id,open:open},
               // data: "id="+id+"status+"+status,
                url: "<?php echo Yii::$app->getUrlManager()->createUrl('export/close-conversatition'); ?>",
                success: function (test) {
                    $('#modal-report').modal('hide');
                },
                error: function (exception) {
                    alert(exception);
                }
            });

        });

                            </script>
<style>
    .table-responsive {
    overflow-x: inherit;
}
.grid-view .summary {
	float:none;
}
</style>