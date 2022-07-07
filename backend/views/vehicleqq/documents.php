    <div class="col-md-12">
    <h2>Attachments</h2>
       <?php foreach (\common\models\Documents::findAll(['vehicle_id' => $model->id]) as $key => $at) { ?>
            <a style="margin-right:30px;" target='_blank' href='/uploads/<?= $at->name; ?>'>Attachment - <?=$key + 1; ?></a>
       <?php } ?>
    </div>
    <style>
    #modalContent{
        overflow: hidden;
    }
    </style>