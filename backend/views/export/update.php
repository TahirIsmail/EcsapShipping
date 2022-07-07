<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Export */

$this->title = 'Update Export: '.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Exports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="export-update index-page">
    <?= $this->render('_form', [
         'model' => $model,
         'dockrecipt' => $dockrecipt,
         'coverletter' => $coverletter,
         'container_images' => $container_images,
         'all_images' => $all_images,
         'session_data' => $session_data,
         'all_images_preview'=>$all_images_preview,
         
    ]) ?>

</div>
