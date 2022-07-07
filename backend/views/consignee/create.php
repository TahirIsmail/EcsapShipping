<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Consignee */

$this->title = Yii::t('app', 'Create Consignee');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Consignees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consignee-create index-page">
<h3><?= Html::encode($this->title) ?></h3>
<hr>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
