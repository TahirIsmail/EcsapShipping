<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\HoustanCustomCoverLetter */

$this->title = 'Create Houstan Custom Cover Letter';
$this->params['breadcrumbs'][] = ['label' => 'Houstan Custom Cover Letters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="houstan-custom-cover-letter-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
