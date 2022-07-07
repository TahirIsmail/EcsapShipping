<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Notification */

$this->title = Yii::t('app', 'Create Notification');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notifications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-create">
<div class="col-md-8 col-md-offset-2">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
