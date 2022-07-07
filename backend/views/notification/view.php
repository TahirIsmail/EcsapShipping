<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Notification */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notifications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-view">

    <h1><?= Html::encode($model->subject) ?></h1>
<?php if($model->user_id == Yii::$app->user->identity->id){?>
    <p>
        
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
        <?php } ?>
         <div class="white-box">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          
            [
                'attribute'=>'message',
                'format'=>'html'
            ],
            'created_at',
        ],
    ]) ?>
</div>
</div>
