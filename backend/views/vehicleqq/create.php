<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Vehicle */

$this->title = 'Create Vehicle';
$this->params['breadcrumbs'][] = ['label' => 'Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicle-create index-page">

    <h3><?= Html::encode($this->title) ?></h3>
<hr>
    <?= $this->render('_form', [
        'model' => $model,
        'towing' => $towing,
        'images' => $images,
        'features' => $features,
        'condition' => $condition,
        'vehiclefeatures' => $vehiclefeatures,
        'vehiclecondition' => $vehiclecondition,
        'all_images' => $all_images,
        'featuredata' => $featuredata,
        'conditiondata' => $conditiondata,
        'session_data' => $session_data,
        'all_images_preview' => $all_images_preview,
        'docs' => $docs,
        'all_docs' => $all_docs,
        'all_docs_preview' => $all_docs_preview,
    ]) ?>

</div>
