<?php
use yii\grid\GridView;
use yii\helpers\Html;

?>
<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'showFooter' => true,
    'footerRowOptions' => ['style' => 'font-weight:bold;text-decoration: underline;'],
    //    'filterModel' => $searchModel,
    'columns' => [
        // 'id',
        [
            'label' => 'CUST ID',
            'attribute' => 'customer_user_id',
        ],
        [
            'label' => 'COMPANY NAME',

            'value' => function ($model) {
                $customer = \common\models\Customer::findOne(['user_id' => $model->customer_user_id]);
                if (!empty($customer)) {
                    return $customer->company_name;
                }
            },
        ],

        [
            'attribute' => 'total_amount',
            //'format' => 'currency',
            'footer' => number_format(\common\models\Invoice::getTotal($dataProvider->models, 'total_amount'), 2, '.', ','),
        ],
        [
            'attribute' => 'paid_amount',
            //'format' => 'currency',
            'contentOptions' => ['style' => 'color:green'],
            'footer' => number_format(\common\models\Invoice::getTotal($dataProvider->models, 'paid_amount'), 2, '.', ','),
        ],

        [
            'label' => 'BALANCE',
            'format' => 'raw',
            'contentOptions' => ['style' => 'color:red'],
            'value' => function ($model) {
                return $model->total_amount - $model->adjustment_damaged - $model->adjustment_storage - $model->adjustment_discount - $model->adjustment_other - $model->paid_amount;
            },
            'footer' => number_format(\common\models\Invoice::getTotalremaning($dataProvider->models), 2, '.', ','),
        ],
        //'note',

        ['class' => 'yii\grid\ActionColumn',
            'options' => ['class' => 'action-column'],
            'template' => '{view}',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    $btn = Html::a("<span class='glyphicon glyphicon-pencil'></span>", [''], [
                        'value' => Yii::$app->urlManager->createUrl('invoice/update?id='.$key), //<---- here is where you define the action that handles the ajax request
                        'class' => 'click_modal grid-action',
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'bottom',
                        'title' => 'Update',
                    ]);

                    return $btn;
                },
                'view' => function ($url, $model, $key) {
                    $btn = Html::a("<span class='glyphicon glyphicon-eye-open'></span>", Yii::$app->urlManager->createUrl('invoice/list?id='.$model->customer_user_id), [
                        'href' => Yii::$app->urlManager->createUrl('invoice/list?id='.$model->customer_user_id), //<---- here is where you define the action that handles the ajax request
                        'title' => 'View Invoices',
                    ]);

                    return $btn;
                },
            ],
            'visibleButtons' => [
                'update' => Yii::$app->user->can('super_admin'),
                'update' => Yii::$app->controller->action->id == 'list',
            ],
        ],
    ],
]);
