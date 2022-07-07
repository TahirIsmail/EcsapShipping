<?php

use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'PAYMENTS');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-index">

    <div class="white-box">

        <div class="">
            <div class="col-md-6">
            <div class="col-md-6">
                <h1><?=Html::encode($this->title)?></h1>
                <?php
                    $user_id = Yii::$app->user->getId();
                    $Role = Yii::$app->authManager->getRolesByUser($user_id);
?>
            </div>
            <div class="col-md-6">
            </div>
            </div>
            <?php Pjax::begin();?>
            <div class="col-md-6">

            <?php echo $this->render('_search_payments', ['model' => $searchModel]); ?>
        </div>

   <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'showFooter' => true,
        'footerRowOptions' => ['style' => 'font-weight:bold;text-decoration: underline;'],
        //    'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => 'DATE',
                'attribute' => 'created_at',
                'value'=>function($model){
                    return date('Y-m-d',strtotime($model->created_at));
                }
            ],
            [
                'label' => 'CUST ID',
                'attribute' => 'customerUser.legacy_customer_id',

            ],
            'invoice_id',
            'paymentInvoice.export.ar_number',
            'paymentInvoice.export.container_number',
            [

                'label' => 'COMPANY NAME',

                'value' => function ($model) {
                    if (!empty($model->customerUser->company_name)) {
                        return $model->customerUser->company_name;
                    }
                },
            ],
            [
                'attribute' => 'paid_amount',
                'format' => 'currency',
                'footer' => number_format(\common\models\Invoice::getTotal($dataProvider->models, 'paid_amount'), 2, ".", ","),
            ],
            [
                'attribute' => 'remaining_amount',
                'format' => 'currency',
                //'contentOptions' => ['style' => 'color:green'],
                //'footer' => number_format(\common\models\Invoice::getTotal($dataProvider->models, 'remaining_amount'), 2, ".", ","),
            ],

            'note',

            ['class' => 'yii\grid\ActionColumn',
                'options' => ['class' => 'action-column'],
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/invoice/view', 'id' => $model->invoice_id], ['class' => '']);
                    },
                ],
                'visibleButtons' => [
                    'update' => Yii::$app->user->can('super_admin'),
                ],
            ],
        ],
    ]);
?>
        <?php Pjax::end();?>

        </div>
    </div>
</div>

