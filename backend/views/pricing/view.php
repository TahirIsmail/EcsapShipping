<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Pricing */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pricings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
if (!Yii::$app->user->can('restrict-pricing')){
?>
<div class="pricing-view">

    <h1>Pricing</h1>

    <p>
    <?php
                $user_id = Yii::$app->user->getId();
                $Role = Yii::$app->authManager->getRolesByUser($user_id);
                if (!isset($Role['customer'])) { ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]);
         } ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
        
            // 'upload_file',
            'month',
            [
    
                'attribute' => 'pricing_type',
                'value' => function($model) {
                    return isset(\common\models\Lookup::$pricing_type[$model->pricing_type])?\common\models\Lookup::$pricing_type[$model->pricing_type]:$model->pricing_type;
                    
                },
            ],
            [
    
                'attribute' => 'status',
                'value' => function($model) {
                    return isset(\common\models\Lookup::$pricing_status_type[$model->status])?\common\models\Lookup::$pricing_status_type[$model->status]:$model->status;
                    
                },
            ],
          
        ],
    ]) ?>
<div class="row">
    <div class="col-md-6">

                         
                    <h4>Download file</h4>
                    <?php  if($model->upload_file)  {?>
                    <iframe id="fred" style="border:1px solid #666CCC" title="PDF in an i-Frame" src="<?php echo \yii\helpers\Url::to('@web/uploads/'.$model->upload_file, true) ?>" frameborder="1" scrolling="auto" height="300" width="100%" ></iframe>
      <br> <a target="_blank" href="<?php echo \yii\helpers\Url::to('@web/uploads/'.$model->upload_file, true) ?>">Download</a>
                    <?php  }?>
                                    </div>
    </div>
</div>
</div>
<?php } ?>