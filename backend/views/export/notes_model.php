<?php
use dosamigos\fileupload\FileUpload;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
  <!-- /.modal -->
  <?php if($model->notes_status!='1'){ ?>
    <div class="modal-add-notes" style="display:block;">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','id'=>'notes-form']])?>
        <?=$form->field($model, 'text')->textarea();?>
        <?=$form->field($model, 'id')->hiddenInput(['value' => $model->id])->label(false);?>
        <?=$form->field($model, 'imageurl')->hiddenInput()->label(false);?>

        <?=$form->field($model, 'customer_user_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false);?>

        <?=FileUpload::widget([
            'model' => $model,
            'attribute' => 'imageFile',
            'url' => ['vehicle/upload-notes', 'id' => $model->id], // your url, this is just for demo purposes,
            'clientOptions' => [
                'maxFileSize' => 2000000,
                'previewMaxWidth' => 80,
            ],
            // Also, you can specify jQuery-File-Upload events
            // see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
            'clientEvents' => [
                'fileuploaddone' => 'function(e, data) {
                                    console.log(e);
                                    $(".image a").append(JSON.parse(data.result).files[0].name);
                                $("#export-imageurl").val(JSON.parse(data.result).files[0].thumbnailUrl);
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
<?php ActiveForm::end();?>
<div class="image">
    
  <div class="modal-footer">
    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close
    </button>
    <button type="button" key="<?php echo $model->id; ?>" data="1" class="btn btn-success waves-effect waves-light close_conversatition">Close Conversatition
    </button>
  </div>
</div>
        <?php }else{ ?>
<div class="modal-footer model-openchat-notes">
  <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close
  </button>
  <button type="button" key="<?php echo $model->id; ?>" data="2" class="btn btn-success waves-effect waves-light close_conversatition">Open Conversatition
  </button>
</div>
        <?php } ?>


                                        <div class="modal-footer">
                                           <ul class="notes">
                                            <?php
foreach ($model->notes as $notes) {
    ?>
                                        <li>


                                            <?php
if ($notes->created_by != 1) {
        $created_by = \common\models\Customer::findOne(['user_id' => $notes->created_by]);
        if($created_by){
            $created_by = $created_by->customer_name;
            $color = '#23c6c8';
        }else{
            $created_by = 'Super Admin';
            $color = '#9C27B0';
        }
        
    } else {
        $created_by = 'Super Admin';
        $color = '#9C27B0';
    }
    ?>
                                             <div class="rotate-1 lazur-bg" style="background: <?php echo $color; ?>">
                                            <p><?=$created_by;?></p>
                                                <p><?=$notes->created_at;?></p>
                                                <p><?=$notes->description;?></p>
                                                <?php if ($notes->imageurl) {?>
          <span class="image_show_note"><a target="_blank" href="<?=$notes->imageurl?>">View Attachment</a></span>
     <?php }?>

                                            </div>
                                        </li>
                                            <?php }?>
                                    </ul>
                                        </div>


