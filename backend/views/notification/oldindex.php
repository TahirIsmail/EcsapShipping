<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\NotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Notifications');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-index">
<div class="white-box">
<div class="">
<div class="col-md-6">
    <h1><?= Html::encode($this->title) ?></h1>
  
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php 
               $user_id = Yii::$app->user->getId();
                $Role = Yii::$app->authManager->getRolesByUser($user_id);
                if (!isset($Role['customer'])) { ?>
        <?= Html::a(Yii::t('app', 'Create Notification'), ['create'], ['class' => 'btn btn-primary']) ?>
                <?php } ?>
    </p>
    </div>
  <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'subject',
            [
            'label'=>'Message',
            'value'=>function($model)
            {
               return   \yii\helpers\StringHelper::truncate($model->message, 100, '......', 'UTF-8', true);
            }
            ],
            // 'is_read:boolean',
            // 'status:boolean',
            //'created_by',
            //'updated_by',
            //'created_at',
            //'updated_at',
            //'user_id',
            'expire_date',

            ['class' => 'yii\grid\ActionColumn',
            'options'=>['class'=>'action-column'],
            'template'=>'{update} {view} {delete}',
            'visibleButtons' => [
                'delete' => Yii::$app->user->can('super_admin'),
                'update' => Yii::$app->user->can('super_admin')
                
             ]
        ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
</div>
</div>

