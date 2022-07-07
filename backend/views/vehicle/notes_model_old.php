
<!-- /.modal -->
<?php if($model->notes_status != '1'){?>
  <div class="modal-add-notes" style="display:block;">
    <form>
      <div class="form-group">
        <label for="message-text" class="control-label">Write Note:
        </label>
        <textarea class="form-control" id="message-text">
        </textarea>
      </div>
    </form>
    <div class="modal-footer">
      <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close
      </button>
      <button type="button" key="<?php echo $model->id; ?>" user="<?php echo Yii::$app->user->identity->id; ?>" class="btn btn-primary waves-effect waves-light notes_vehicle">Add Notes
      </button>
      <button type="button" key="<?php echo $model->id; ?>" data="1" class="btn btn-success waves-effect waves-light close_conversatition">Close Conversatition
      </button>
    </div>
</div>
<?php }else{ ?>
<div class="modal-footer model-openchat-notes">
  <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close
  </button>
  <button type="button" key="<?php echo $model->id; ?>" data="0" class="btn btn-success waves-effect waves-light close_conversatition">Open Conversatition
  </button>
</div>
<?php } ?>
<div class="modal-footer">
  <ul class="notes">
    <?php
$notes = \common\models\Note::find()->where(['vehicle_id' => $model->id])->all();
if ($notes) {
    foreach ($notes as $notes) {
        ?>
    <li>
      <?php
if ($notes->created_by != 1) {
            $created_by = \common\models\Customer::findOne(['user_id' => $notes->created_by]);
            $created_by = $created_by->customer_name;
            $color = '#23c6c8';
        } else {
            $created_by = 'Super Admin';
            $color = '#9C27B0';
        }
        ?>
      <div class="rotate-1 lazur-bg" style="background: <?php echo $color; ?>">
        <p>
          <?=$created_by;?>
        </p>
        <p>
          <?=$notes->created_at;?>
        </p>
        <p>
          <?=$notes->description;?>
        </p>
      </div>
    </li>
    <?php }}?>
  </ul>
</div>
