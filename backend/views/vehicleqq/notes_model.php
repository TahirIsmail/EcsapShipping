<?php 
use dosamigos\fileupload\FileUploadUI;
use dosamigos\fileupload\FileUpload;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<!-- /.modal -->
<?php if($model->notes_status != '1'){?>
<div class="modal-add-notes_form">
<div class="modal-add-notes">
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<?= $form->field($model, 'text')->textarea(); ?>
<?= $form->field($model, 'id')->hiddenInput(['value'=> $model->id])->label(false); ?>
<?= $form->field($model, 'imageurl')->hiddenInput()->label(false); ?>

<?= $form->field($model, 'customer_user_id')->hiddenInput(['value'=> Yii::$app->user->identity->id])->label(false); ?>

<?= FileUpload::widget([
	'model' => $model,
	'attribute' => 'imageFile',
	'url' => ['vehicle/upload-notes', 'id' => $model->id], // your url, this is just for demo purposes,
	'clientOptions' => [
    'maxFileSize' => 2000000,
    'previewMaxWidth'=> 80
	],
	// Also, you can specify jQuery-File-Upload events
	// see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
	'clientEvents' => [
	    'fileuploaddone' => 'function(e, data) {
                              console.log(e);
                              $(".image a").append(JSON.parse(data.result).files[0].name);
                         $("#vehicle-imageurl").val(JSON.parse(data.result).files[0].thumbnailUrl);
                              debugger;
	                        }',
        'fileuploadfail' => 'function(e, data) {
	                            console.log(e);
	                            console.log(data);
                            }',
	],
]);

?>  
<button type="button" class="btn btn-success subm notes_vehicle">Add Notes</button>
<?php ActiveForm::end(); ?>
<div class="image">
<a href=""></a>
</div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close
    </button>
    <!-- <button type="button" key="<?php //echo $model->id; ?>" user="<?php //echo Yii::$app->user->identity->id; ?>" class="btn btn-primary waves-effect waves-light notes_vehicle">Add Notes -->
    </button>
    <button type="button" key="<?php echo $model->id; ?>" data="1" class="btn btn-success waves-effect waves-light close_conversatition">Close Conversatition
    </button>
    </div>
    </div>
    <div class="modal-footer">
    <div class="modal-footer model-close-chat-notes" style="display:none;">
      <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close
      </button>
  <button type="button" key="<?php echo $model->id; ?>" data="0" class="btn btn-success waves-effect waves-light close_conversatition">Open Conversatition
      
    </div>
  </div>
</div>
<?php }else{?>
    <div class="modal-add-notes" style="display:none;">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<?= $form->field($model, 'text')->textarea() ?>
<?= $form->field($model, 'id')->hiddenInput(['value'=> $model->id])->label(false); ?>
<?= $form->field($model, 'imageurl')->hiddenInput()->label(false); ?>

<?= $form->field($model, 'customer_user_id')->hiddenInput(['value'=> Yii::$app->user->identity->id])->label(false); ?>

<?= FileUpload::widget([
	'model' => $model,
	'attribute' => 'imageFile',
	'url' => ['vehicle/upload-notes', 'id' => $model->id], // your url, this is just for demo purposes,

	'clientOptions' => [
		'maxFileSize' => 2000000
	],
	// Also, you can specify jQuery-File-Upload events
	// see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
	'clientEvents' => [
	    'fileuploaddone' => 'function(e, data) {
                              console.log(e);
                              $(".image a").append(JSON.parse(data.result).files[0].name);
                         $("#vehicle-imageurl").val(JSON.parse(data.result).files[0].thumbnailUrl);
                              debugger;
	                        }',
        'fileuploadfail' => 'function(e, data) {
	                            console.log(e);
	                            console.log(data);
                            }',
	],
]);?>  
<button type="button" class="btn btn-success subm notes_vehicle">Add Notes</button>
<?php ActiveForm::end(); ?>
<div class="image">
<img src="" alt="">
</div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close
    </button>
    <button type="button" key="<?php // echo $model->id; ?>" user="<?php //echo Yii::$app->user->identity->id; ?>" class="btn btn-primary waves-effect waves-light notes_vehicle">Add Notes
    </button>
    <button type="button" key="<?php echo $model->id; ?>" data="1" class="btn btn-success waves-effect waves-light close_conversatition">Close Conversatition
    </button>
  
  </div>
</div>
<div class="modal-footer model-openchat-notes">
  <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close
  </button>
  <button type="button" key="<?php echo $model->id; ?>" data="0" class="btn btn-success waves-effect waves-light close_conversatition">Open Conversatition
  </button>
</div>
<?php }?>
<div class="modal-footer">
  <ul class="notes">
    <?php 
$notes = \common\models\Note::find()->where(['vehicle_id'=>$model->id])->all();
if($notes){
foreach($notes as $notes){
?>
    <li>
      <?php
if($notes->created_by != 1){
$created_by = \common\models\Customer::findOne(['user_id'=>$notes->created_by]);
if($created_by){
  $created_by = $created_by->customer_name;
  $color = '#23c6c8';
}else{
  $created_by = 'Admin';
  $color = '#9C27B0';
}


}else{
$created_by = 'Super Admin';
$color = '#9C27B0';
}
?>
      <div class="rotate-1 lazur-bg" style="background: <?php echo $color; ?>">
        <p>
          <?= $created_by; ?>
        </p>
        <p>
          <?= $notes->created_at; ?>
        </p>
        <p>
          <?= $notes->description; ?>
        </p>
        <?php if($notes->imageurl){ ?>
          <span class="image_show_note"><a target="_blank" href="<?= $notes->imageurl ?>">View Attachment</a></span>
     <?php   } ?>
      </div>
    </li>   
    <?php } } ?>
  </ul>
</div>