<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Export */

$this->title = 'Create Export';
$this->params['breadcrumbs'][] = ['label' => 'Exports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="export-create index-page">
<h3><?= Html::encode($this->title) ?></h3>
<hr>
    <?= $this->render('_form', [
        'model' => $model,
        'dockrecipt' => $dockrecipt,
        'coverletter' => $coverletter,
        'container_images' => $container_images,
        'all_images' => $all_images,
        'all_images_preview' => $all_images_preview,
        'blankcontainer_images' =>$blankcontainer_images,
        
    ]) ?>

</div>
