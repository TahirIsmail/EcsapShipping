<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model common\models\Consignee */

$this->title = $model->consignee_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Consignees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consignee-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?= Html::button(Yii::t('app', 'Update'), ['value' => Yii::$app->urlManager->createUrl('consignee/update?id=' . $model->id), 'class' => 'btn btn-primary click_modal']) ?>
    
    </p>
    <?php
    Modal::begin([
       
        'id'=>'modal',
        'size'=>'modal-lg',
    ]);
    
    echo '<div id="modalContent"></div>';
    
    Modal::end(); ?>
    <div class="white-box">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'customerUser.company_name',
            'consignee_name',
            'consignee_address_1',
            'consignee_address_2',
            'city',
            'state',
            'country',
            'zip_code',
            'phone',
       
        ],
    ]) ?>
</div>
</div>
