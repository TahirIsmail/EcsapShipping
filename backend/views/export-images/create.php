<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ExportImages */

$this->title = Yii::t('app', 'Create Export Images');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Export Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="export-images-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
