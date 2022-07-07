<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = Yii::t('app', 'Update Customer: {nameAttribute}', [
    'nameAttribute' => $model->company_name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="customer-update index-page">
    <h3><?= Html::encode($this->title) ?></h3>
    </div>
    <hr>

    <?= $this->render('_form', [
        'model' => $model,
         'all_images' => $all_images,
         'all_images_preview'=>$all_images_preview,

    ]) ?>

</div>
