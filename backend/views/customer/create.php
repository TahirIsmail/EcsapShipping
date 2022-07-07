<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = Yii::t('app', 'Create Customer');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-create index-page">

    <h3><?= Html::encode($this->title) ?></h3>

<hr>
    <?= $this->render('_form', [
        'model' => $model,
        'all_images' => $all_images,
        'all_images_preview'=>$all_images_preview,
    ]) ?>

</div>
