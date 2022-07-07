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

$this->title = 'Vehicles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicle-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-6">
            <?php
            $user_id = Yii::$app->user->getId();
            $Role = Yii::$app->authManager->getRolesByUser($user_id);
            if (isset($Role['customer'])) {
                
            } else {
                ?>

                <p>
                <?= Html::button(Yii::t('app', 'Create Vehicle'), ['value' => Url::to('@web/vehicle/create'), 'class' => 'btn btn-success click_modal']) ?>
                </p>
        <?php } ?>
        </div>
            <?php Pjax::begin(); ?>
        <div class="col-md-6">
<?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>
    <?php
    Modal::begin([

        'id' => 'modal',
        'size' => 'modal-lg',
    ]);

    echo '<div id="modalContent"></div>';

    Modal::end();
    ?>

    <?php
    // echo $this->render('_search', ['model' => $searchModel]); 
    if (isset($Role['customer']) || isset($Role['admin_LA'])) {
        ?>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                [
                    'attribute' => 'customer_user_id',
                    'label' => 'CUSTOMER NAME',
                    'value' => function ($model, $key, $index, $widget) {
                        return $model->customerUser->customer_name;
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
                    'label' => 'Status',
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $status = isset(\common\models\Lookup::$status[$model->status])?\common\models\Lookup::$status[$model->status]:$model->status;                   
                        return  $status;
                    },
                    'filter' => [1 => "ON HAND", 2 => "LOADED", 3 => "DISPATCHED", 4 => "SHIPPED", '' => "No Status"],
                ],
                [
                    'label' => 'Location',
                    'attribute' => 'location',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->location == 1 ? "LA" : ($model->location == 2 ? "GA" : ($model->location == 3 ? "NY" : ($model->location == 4 ? "TX" : ($model->location == '' ? "No Status" : "Unknown"))));
                    },
                    'filter' => [1 => "LA", 2 => "GA", 3 => "NY", 4 => "TX"],
                ],
//'towingRequest.towing_request_date',
                [
                    'attribute' => 'towingRequest.towing_request_date',
                    'format' => 'raw',
                    'label' => "Towing Date",
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'name' => 'VehicleSearch[request_dat]',
                        'value' => ArrayHelper::getValue($_GET, "VehicleSearch.request_dat"),
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'autoclose' => true,
                        ]
                    ])
                ],
                // 'year',
                // 'color',
                'lot_number',
                'model',
                // 'make',
                'vin',
                [
                    'attribute' => 'towingRequest.pickup_date',
                    'format' => 'raw',
                    'label' => "pickup Date",
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'name' => 'VehicleSearch[pickup_dates]',
                        'value' => ArrayHelper::getValue($_GET, "VehicleSearch.pickup_dates"),
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'autoclose' => true,
                        ]
                    ])
                ],
                [
                    'attribute' => 'towingRequest.title_recieved_date',
                    'format' => 'raw',
                    'label' => "Title Recive Date",
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'name' => 'VehicleSearch[title_recieved_dates]',
                        'value' => ArrayHelper::getValue($_GET, "VehicleSearch.title_recieved_dates"),
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'autoclose' => true,
                        ]
                    ])
                ],
                [
                    'attribute' => 'towingRequest.deliver_date',
                    'format' => 'raw',
                    'label' => "Deliver Date",
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'name' => 'VehicleSearch[deliver_dates]',
                        'value' => ArrayHelper::getValue($_GET, "VehicleSearch.deliver_dates"),
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'autoclose' => true,
                        ]
                    ])
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'options' => ['class' => 'action-column'],
                    'template' => '{update} {delete} {view}',
                    'buttons' => [
                        'update' => function($url, $model, $key) {
                            $btn = Html::a("<span class='glyphicon glyphicon-pencil'></span>", [''], [
                                        'value' => Yii::$app->urlManager->createUrl('vehicle/update?id=' . $key), //<---- here is where you define the action that handles the ajax request
                                        'class' => 'click_modal grid-action',
                                        'data-toggle' => 'tooltip',
                                        'data-placement' => 'bottom',
                                        'title' => 'Update'
                            ]);

                            return $btn;
                        }
                            ]
                        ],
                    ],
                ]);
            } else {
                ?>

                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        'id',
                        [
                            'attribute' => 'customer_user_id',
                            'label' => 'CUSTOMER NAME',
                            'value' => function ($model, $key, $index, $widget) {
                                return $model->customerUser->customer_name;
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
                            'label' => 'Status',
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $status = isset(\common\models\Lookup::$status[$model->status])?\common\models\Lookup::$status[$model->status]:$model->status;                   
                                return  $status;
                            },
                            'filter' => [1 => "ON HAND", 2 => "LOADED", 3 => "DISPATCHED", 4 => "SHIPPED", '' => "No Status"],
                        ],
                        [
                            'label' => 'Location',
                            'attribute' => 'location',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->location == 1 ? "LA" : ($model->location == 2 ? "GA" : ($model->location == 3 ? "NY" : ($model->location == 4 ? "TX" : ($model->location == '' ? "No Status" : "Unknown"))));
                            },
                            'filter' => [1 => "LA", 2 => "GA", 3 => "NY", 4 => "TX"],
                        ],
//'towingRequest.towing_request_date',
                        [
                            'attribute' => 'towingRequest.towing_request_date',
                            'format' => 'raw',
                            'label' => "Towing Date",
                            'filter' => DatePicker::widget([
                                'model' => $searchModel,
                                'name' => 'VehicleSearch[request_dat]',
                                'value' => ArrayHelper::getValue($_GET, "VehicleSearch.request_dat"),
                                'pluginOptions' => [
                                    'format' => 'yyyy-mm-dd',
                                    'autoclose' => true,
                                ]
                            ])
                        ],
                        // 'year',
                        // 'color',
                        'lot_number',
                        'model',
                        'vin',
                
                        [
                            'attribute' => 'towingRequest.title_recieved_date',
                            'format' => 'raw',
                            'label' => "Title Recive Date",
                            'filter' => DatePicker::widget([
                                'model' => $searchModel,
                                'name' => 'VehicleSearch[title_recieved_dates]',
                                'value' => ArrayHelper::getValue($_GET, "VehicleSearch.title_recieved_dates"),
                                'pluginOptions' => [
                                    'format' => 'yyyy-mm-dd',
                                    'autoclose' => true,
                                ]
                            ])
                        ],
                        [
                            'attribute' => 'towingRequest.deliver_date',
                            'format' => 'raw',
                            'label' => "Deliver Date",
                            'filter' => DatePicker::widget([
                                'model' => $searchModel,
                                'name' => 'VehicleSearch[deliver_dates]',
                                'value' => ArrayHelper::getValue($_GET, "VehicleSearch.deliver_dates"),
                                'pluginOptions' => [
                                    'format' => 'yyyy-mm-dd',
                                    'autoclose' => true,
                                ]
                            ])
                        ],
                        ['class' => 'yii\grid\ActionColumn',
                            'options' => ['class' => 'action-column'],
                            'template' => '{update} {delete} {view}',
                            'buttons' => [
                                'update' => function($url, $model, $key) {
                                    $btn = Html::a("<span class='glyphicon glyphicon-pencil'></span>", [''], [
                                                'value' => Yii::$app->urlManager->createUrl('vehicle/update?id=' . $key), //<---- here is where you define the action that handles the ajax request
                                                'class' => 'click_modal grid-action',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'bottom',
                                                'title' => 'Update'
                                    ]);

                                    return $btn;
                                }
                                    ]
                                ],
                            ],
                        ]);
                    }
                    ?>
                    <?php Pjax::end(); ?>
</div>
