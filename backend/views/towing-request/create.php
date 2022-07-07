<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TowingRequest */

$this->title = 'Create Towing Request';
$this->params['breadcrumbs'][] = ['label' => 'Towing Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="towing-request-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
