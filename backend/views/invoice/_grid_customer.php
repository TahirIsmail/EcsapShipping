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
        'id',
        [
            'label' => 'DATE',
            'attribute' => 'created_at',
            'value' => function ($model) {
                return date('Y-m-d', strtotime($model->created_at));
            },
        ],
        'export.container_number',
        'export.ar_number',
        [
            'label' => 'INV AMOUNT(AED)',
            'attribute' => 'total_amount',
            //'format' => 'currency',
            'footer' => number_format(\common\models\Invoice::getTotal($dataProvider->models, 'total_amount'), 2, '.', ','),
        ],
        [
            'attribute' => 'adjustment_damaged',
            //'format' => 'currency',
            'footer' => number_format(\common\models\Invoice::getTotal($dataProvider->models, 'adjustment_damaged'), 2, '.', ','),
        ],
        [
            'attribute' => 'adjustment_storage',
            //'format' => 'currency',
            'footer' => number_format(\common\models\Invoice::getTotal($dataProvider->models, 'adjustment_storage'), 2, '.', ','),
        ],
        [
            'attribute' => 'adjustment_discount',
            //'format' => 'currency',
            'footer' => number_format(\common\models\Invoice::getTotal($dataProvider->models, 'adjustment_discount'), 2, '.', ','),
        ],
        [
            'attribute' => 'adjustment_other',
            //'format' => 'currency',
            'footer' => number_format(\common\models\Invoice::getTotal($dataProvider->models, 'adjustment_other'), 2, '.', ','),
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
        'note',

        ['class' => 'yii\grid\ActionColumn',
            'options' => ['class' => 'action-column'],
            'template' => '{update}  {view} {usa}',
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
                    if (!empty($model->upload_invoice)) {
                        return Html::a('DXB INV', Yii::$app->urlManager->createUrl('uploads/'.$model->upload_invoice), [
                            'target' => '_blank',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'bottom',
                            'title' => 'view',
                        ]);
                    }
                },
                'usa' => function ($url, $model, $key) {
                    if (isset($model->export->export_invoice) && !empty($model->export->export_invoice)) {
                        return "<a target='_blank' href=".Yii::$app->urlManager->createUrl('/uploads/'.$model->export->export_invoice).'>USA INV<a>';
                    } else {
                        return '-';
                    }
                },
            ],
            'visibleButtons' => [
                'update' => Yii::$app->user->can('super_admin'),
            ],
        ],
    ],
]);
