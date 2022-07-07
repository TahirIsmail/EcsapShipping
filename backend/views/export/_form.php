
<?php
use kartik\date\DatePicker;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\Export */
/* @var $form yii\widgets\ActiveForm */
$formatJs = <<< JS
var formatRepo = function (repo) {
    if (repo.loading) {
        return repo.text;
    }
    var markup_dropdown =
'<div class="col-md-12">' +
    '<div>' +
        '<b>' + repo.customer_name + ':'+ repo.legacy_customer_id+ '</b>' +
    '</div>' +
'</div>';
    if (repo.company_name) {
        markup_dropdown += '<div class="col-md-12"><p>' + repo.company_name + '</p></div>';
    }
    return '<div style="overflow:hidden;">' + markup_dropdown + '</div>';
};
var formatRepoSelection = function (repo) {
    return repo.text || repo.name;
}
JS;
// Register the formatting script
$this->registerJs($formatJs, yii\web\View::POS_HEAD);
?>
<div class="export-form">

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],
    'id' => 'register-form',
    'enableClientValidation' => true,
    'options' => [
        'validateOnSubmit' => true,
        'class' => 'form',
    ],
    'layout' => 'horizontal',
    'fieldConfig' => [
        'horizontalCssClasses' => [
            'label' => 'col-sm-4',
            // 'offset' => 'col-sm-offset-2',
            'wrapper' => 'col-sm-8',
        ],
    ],

]);?>
    <div class="col-md-6"></div>
<div class="col-md-5">
<div class="input-group top_search">
<?php
echo Select2::widget([
    'model' => $model,
    'attribute' => 'vin_search',
    //    'id' => 'vin-search',
    //'value' => $model->customer_user_id,
    // 'initValueText' => isset($model->customerUser->customer_name) ? $model->customerUser->company_name : "",
    'options' => ['placeholder' => 'Select Vehicle Vin ...'],
    'theme' => Select2::THEME_BOOTSTRAP,
    'pluginOptions' => [
        'allowClear' => true,
        //'autocomplete' => true,
        'ajax' => [
            'url' => Yii::$app->urlManager->createUrl('vehicle/allvehicle'),
            'dataType' => 'json',
            'data' => new \yii\web\JsExpression('function(params) { return {q:params.term}; }'),
        ],
    ],
]);
?>
  <span class="input-group-btn">
    <a class="btn btn-success" id="button_vin">
        Add
    </a>
  </span>
</div>
</div>
<div class="col-md-1"></div>


<div id="vehicles"></div>

<input type="hidden" id="export-hidden" class="form-control" name="Export[vehicle_info]" maxlength="45"  aria-invalid="true">
  <h4>Customer Info</h4>
<div class="row">
 <div class="col-md-6">
  <?php
echo $form->field($model, 'customer_user_id')->widget(Select2::classname(), [
    'theme' => Select2::THEME_BOOTSTRAP,
    'options' => ['placeholder' => 'Select a Customer ...'],
    'initValueText' => isset($model->customerUser->customer_name) ? $model->customerUser->company_name : "",
    'pluginOptions' => [
        'allowClear' => true,
        //'autocomplete' => true,
        'ajax' => [
            'url' => Yii::$app->urlManager->createUrl('customer/allcustomer'),
            'dataType' => 'json',
            'data' => new \yii\web\JsExpression('function(params) { return {q:params.term}; }'),
        ],
        'escapeMarkup' => new \yii\web\JsExpression('function (markup) { return markup; }'),
        'templateResult' => new \yii\web\JsExpression('formatRepo'),
        'templateSelection' => new \yii\web\JsExpression('formatRepoSelection')
    ],

]);
?>

</div>
<div class="col-md-6">
          <div class="form-group field-vehicle-hat_number has-success">
                <label class="control-label col-sm-4" for="customer_name">Customer Address</label>
                <div class="col-sm-8">
                    <input type="text" readonly="true" id="export_customer_address" class="form-control"  maxlength="45" aria-invalid="false" value="<?php if (isset($session_data)) {
                    echo $session_data->address_line_1;
                }
?>">
                    <div class="help-block"></div>
                </div>
            </div>
</div>
</div>
<div class="row">
 <div class="col-md-6">
     <div class="form-group field-export-customer_user_id required">
        <label class="control-label col-sm-4" for="export-customer_id">CUSTOMER ID</label>
        <div class="col-sm-8">
            <input type='text' class="form-control" id='customer_ref_id' value="<?php if (isset($model->customerUser->legacy_customer_id)) echo $model->customerUser->legacy_customer_id; ?>" />
        </div>

    </div>
</div>
</div>


<h4>Export Info</h4>
<div class="row">
 <div class="col-md-6">
   <?=
$form->field($model, 'export_date')->widget(DatePicker::className(), [
    'options' => ['placeholder' => 'Select Export date ...'],
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        'autoclose' => true,
    ],

])

?>
   </div>
   <div class="col-md-6">
   <?=
$form->field($model, 'loading_date')->widget(DatePicker::className(), [
    'options' => ['placeholder' => 'Select Loading date ...'],
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true, 'autoclose' => true,
        'autoclose' => true,
    ],

])

?>
   </div>
   </div>
   <div class="row">
        <div class="col-md-6">
        <?=$form->field($model, 'broker_name')->textInput(['maxlength' => true])?>
        </div>
        <div class="col-md-6">
        <?=$form->field($model, 'booking_number')->textInput(['maxlength' => true])?>
        </div>
   </div>
   <div class="row">
        <div class="col-md-6">
            <?=$form->field($model, 'oti_number')->textInput(['maxlength' => true,'placeholder'=>'OTI license'])?>
        </div>
   </div>
   <div class="row">
 <div class="col-md-6">
 <?=
$form->field($model, 'eta')->widget(DatePicker::className(), [
    'options' => ['placeholder' => 'Select ETA date ...'],
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        'autoclose' => true,
    ],

])

?>
   </div>
   <div class="col-md-6">
   <?=$form->field($model, 'ar_number')->textInput(['maxlength' => true])?>
   </div>
   </div>
   <div class="row">
 <div class="col-md-6">
 <?=$form->field($model, 'xtn_number')->textInput(['maxlength' => true])?>
   </div>
   <div class="col-md-6">
   <?=$form->field($model, 'seal_number')->textInput(['maxlength' => true])?>

   </div>
   </div>
   <div class="row">
 <div class="col-md-6">
 <?=$form->field($model, 'container_number')->textInput(['maxlength' => true])?>

   </div>
   <div class="col-md-6">
   <?=
$form->field($model, 'cutt_off')->widget(DatePicker::className(), [
    'options' => ['placeholder' => 'Select ETA date ...'],
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        'autoclose' => true,
    ],

])

?>
   </div>
   </div>
   <div class="row">
 <div class="col-md-6">
 <?=$form->field($model, 'vessel')->textInput(['maxlength' => true])?>

   </div>
   <div class="col-md-6">
   <?=$form->field($model, 'voyage')->textInput(['maxlength' => true])?>
   </div>
   </div>
   <div class="row">
 <div class="col-md-6">
 <?=$form->field($model, 'terminal')->textInput(['maxlength' => true])?>

   </div>
   <div class="col-md-6">
   <?=$form->field($model, 'streamship_line')->textInput(['maxlength' => true])?>
   </div>
   </div>
   <div class="row">
 <div class="col-md-6">
 <?=$form->field($model, 'destination')->textInput(['maxlength' => true])?>
   </div>
   <div class="col-md-6">
   <?=$form->field($model, 'itn')->textInput(['maxlength' => true])?>
   </div>
   </div>
   <div class="row">
 <div class="col-md-6">
 <?=$form->field($model, 'contact_details')->textarea(['rows' => 3])?>
   </div>
   <div class="col-md-6">
   </div>
   </div>
<hr>
<h4>Additional Info</h4>
<div class="row">
 <div class="col-md-6">
 <?=$form->field($model, 'special_instruction')->textarea(['rows' => 3])?>
   </div>
   <div class="col-md-6">
   <?php
echo $form->field($model, 'container_type')->widget(Select2::classname(), [
    'data' => common\models\Lookup::$container_type,
    'theme' => Select2::THEME_BOOTSTRAP,
    'options' => ['placeholder' => 'Select a state ...'],
    'pluginOptions' => [
        'allowClear' => false,
    ],
]);

?>
   </div>
   </div>
   <div class="row">
 <div class="col-md-6">
 <?=$form->field($model, 'port_of_loading')->textInput(['maxlength' => true])?>
   </div>
   <div class="col-md-6">
   <?=$form->field($model, 'port_of_discharge')->textInput(['maxlength' => true])?>
   </div>
   </div>
   <div class="row">
 <div class="col-md-6">
 <?=$form->field($model, 'bol_note')->textInput(['maxlength' => true])?>
   </div>
   <div class="col-md-6">
   </div>
   </div>
   <hr>
   <h4>Dock Receipt - More Info</h4>

   <div class="row">
   <div class="col-md-6">
   <?=$form->field($dockrecipt, 'awb_number')->textInput(['maxlength' => true])?>
   </div>
   <div class="col-md-6">
   <?=$form->field($dockrecipt, 'export_reference')->textInput(['maxlength' => true])?>
   </div>
   </div>
   <div class="row">
 <div class="col-md-6">
 <?=$form->field($dockrecipt, 'forwarding_agent')->textarea(['rows' => 3])?>

   </div>
   <div class="col-md-6">
 <?=$form->field($dockrecipt, 'domestic_routing_insctructions')->textarea(['rows' => 3])?>

   </div>
   </div>
   <div class="row">
 <div class="col-md-6">
 <?=$form->field($dockrecipt, 'pre_carriage_by')->textInput(['maxlength' => true])?>
   </div>
   <div class="col-md-6">
 <?=$form->field($dockrecipt, 'place_of_receipt_by_pre_carrier')->textInput(['maxlength' => true])?>
   </div>
   </div>

<div class="row">
 <div class="col-md-6">
<?=$form->field($dockrecipt, 'final_destination')->textInput(['maxlength' => true])?>

</div>
<div class="col-md-6">
<?=$form->field($dockrecipt, 'loading_terminal')->textInput(['maxlength' => true])?>

</div>
</div>
<div class="row">
 <div class="col-md-6">
<?=$form->field($dockrecipt, 'container_type')->textInput(['maxlength' => true])?>

</div>
<div class="col-md-6">
<?=$form->field($dockrecipt, 'number_of_packages')->textInput(['maxlength' => true])?>

</div>
</div>
<div class="row">
 <div class="col-md-6">
<?=$form->field($dockrecipt, 'by')->textInput(['maxlength' => true])?>

</div>
<div class="col-md-6">
<?=$form->field($dockrecipt, 'exporting_carrier')->textInput(['maxlength' => true])?>

</div>
</div>
<div class="row">
 <div class="col-md-6">
 <?=
$form->field($dockrecipt, 'date')->widget(DatePicker::className(), [
    'options' => ['placeholder' => 'Select date ...'],
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true, 'autoclose' => true,
        'autoclose' => true,
    ],

])

?>
</div>
<div class="col-md-6">
<?=
$form->field($dockrecipt, 'auto_recieving_date')->widget(DatePicker::className(), [
    'options' => ['placeholder' => 'Select Auto Recieving date ...'],
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        'autoclose' => true,
        'autoclose' => true,
    ],

])

?>
</div>
</div>
<div class="row">
 <div class="col-md-6">
 <?=
$form->field($dockrecipt, 'auto_cut_off')->widget(DatePicker::className(), [
    'options' => ['placeholder' => 'Select Auto Cutt off date ...'],
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        'autoclose' => true,
        'autoclose' => true,
    ],

])

?>
</div>
<div class="col-md-6">
<?php //$form->field($dockrecipt, 'auto_cut_off')->textInput(['maxlength' => true]) ?>
<?=
$form->field($dockrecipt, 'vessel_cut_off')->widget(DatePicker::className(), [
    'options' => ['placeholder' => 'Select Vessel Cutt off date ...'],
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        'autoclose' => true,
        'autoclose' => true,
    ],

])

?>


</div>
</div>
<div class="row">
 <div class="col-md-6">
 <?=
$form->field($dockrecipt, 'sale_date')->widget(DatePicker::className(), [
    'options' => ['placeholder' => 'Select Sale date ...'],
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        'autoclose' => true,
        'autoclose' => true,
    ],

])

?>
</div>
<div class="col-md-6">

</div>
</div>
<hr>
<h4>Houston Customs Cover Letter</h4>
<div class="row">
 <div class="col-md-6">
 <?=$form->field($coverletter, 'vehicle_location')->textInput(['maxlength' => true])?>
</div>
<div class="col-md-6">
<?=$form->field($coverletter, 'exporter_id')->textInput(['maxlength' => true])?>
</div>
</div>
<div class="row">
 <div class="col-md-6">
 <?=$form->field($coverletter, 'exporter_type_issuer')->textInput(['maxlength' => true])?>

</div>
<div class="col-md-6">
<?=$form->field($coverletter, 'transportation_value')->textInput(['maxlength' => true])?>

</div>
</div>
<div class="row">
 <div class="col-md-6">
 <?=$form->field($coverletter, 'exporter_dob')->textInput(['maxlength' => true])?>
</div>
<div class="col-md-6">
<?=$form->field($coverletter, 'ultimate_consignee_dob')->textInput(['maxlength' => true])?>
</div>
</div>
<div class="row">
 <div class="col-md-6">

 <?php
echo $form->field($coverletter, 'consignee')->widget(Select2::classname(), [
    'theme' => Select2::THEME_BOOTSTRAP,
    'options' => ['placeholder' => 'Select a consignee party ...'],
    'initValueText' => \common\models\Consignee::getNameFromId($coverletter->consignee),
    'pluginOptions' => [
        'allowClear' => true,
        //'autocomplete' => true,
        'ajax' => [
            'url' => Yii::$app->urlManager->createUrl('consignee/customer-consignee'),
            'dataType' => 'json',
            'data' => new \yii\web\JsExpression('function(params) { var type = $("#export-customer_user_id").val();return {q:params.term,type:type}; }'),
        ],
    ],
]);

?>
</div>
<div class="col-md-6">
    <?php

echo $form->field($coverletter, 'notify_party')->widget(Select2::classname(), [
    'theme' => Select2::THEME_BOOTSTRAP,
    'options' => ['placeholder' => 'Select a consignee party ...'],
    //'initValueText'=>\common\models\,
    'initValueText' => \common\models\Consignee::getNameFromId($coverletter->notify_party),
    'pluginOptions' => [
        'allowClear' => true,
        //'autocomplete' => true,
        'ajax' => [
            'url' => Yii::$app->urlManager->createUrl('consignee/customer-consignee'),
            'dataType' => 'json',
            'data' => new \yii\web\JsExpression('function(params) { var type = $("#export-customer_user_id").val();return {q:params.term,type:type}; }'),
        ],
    ],
]);

if ($model->isNewRecord) {
    $all_images_preview = [];
}
?>


</div>
</div>
<div class="row">
 <div class="col-md-6">
        <?php
        echo $form->field($coverletter, 'menifest_consignee')->widget(Select2::classname(), [
            'theme' => Select2::THEME_BOOTSTRAP,
            'options' => ['placeholder' => 'Select a manifest consignee ...'],
            //'initValueText'=>\common\models\,
            'initValueText' => \common\models\Consignee::getNameFromId($coverletter->menifest_consignee),
            'pluginOptions' => [
                'allowClear' => true,
                //'autocomplete' => true,
                'ajax' => [
                    'url' => Yii::$app->urlManager->createUrl('consignee/customer-consignee'),
                    'dataType' => 'json',
                    'data' => new \yii\web\JsExpression('function(params) { var type = $("#export-customer_user_id").val();return {q:params.term,type:type}; }'),
                ],
            ],
        ]);
?>

</div>
<div class="col-md-6">
</div>
</div>
<hr>
<h4>Container Images</h4>
<div class="row">
<div class="col-md-10">
<?=
$form->field($model, 'export_invoice')->widget(FileInput::classname(), [
    'pluginOptions' => [
        'allowedFileExtensions' => ['jpg', 'gif', 'png', 'bmp', 'pdf', 'jpeg'],
        'showUpload' => true,
        'showRemove' => true,
        'initialPreview' => [
            $model->export_invoice ? Html::img(Yii::$app->request->baseUrl . '/uploads/' . $model->export_invoice) : null, // checks the models to display the preview
        ],
        'initialPreviewConfig' => [
            [
                'url' => "/export/delete-export-invoice",
                'key' => $model->id,
            ],

        ],
        'overwriteInitial' => false,
    ],
]);
?>
<?=
$form->field($container_images, 'name[]')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*', 'multiple' => true, 'id' => 'container'],
    'pluginOptions' => [
        'previewFileType' => 'image',
        'allowedFileExtensions' => ['jpg', 'gif', 'png', 'bmp', 'jpeg'],
        'showUpload' => true,
        'initialPreview' => $all_images,
        'initialPreviewConfig' => $all_images_preview,
        'overwriteInitial' => false,
        'showRemove' => true,
        'showPreview' => true,
        'uploadUrl' => Url::to(['cases/upload']),
    ],
]);

?>




<div class="help-block help-block-error vehcle_not_found" style="color: #a94442;"></div>
    <hr>
        <div class="col-md-offset-2 col-md-8">
        <?=Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary save-button'])?>
            </div>
        </div>
        <div class="col-md-2"></div>
        </div>
    <hr>
    <?php ActiveForm::end();?>
</div>
<script>
$('.close').click(function(){
  db_export_vehicle.clients.splice(0,db_export_vehicle.clients.length);
});
  $('#export-customer_user_id').on('change', function () {
        $.post("<?php echo Yii::$app->urlManager->createUrl('customer/getcustomer'); ?>?id=" + $(this).val(), function (data) {
            var d =JSON.parse(data);
            if(d.address_line_1){
                $("#export_customer_address").val(d.address_line_1);
            }
            if(d.legacy_customer_id){
                $("#customer_ref_id").val(d.legacy_customer_id);
            }
            
        });
    });
<?php
if (!$model->isNewRecord) {
    $all_vehicle_ids = common\models\VehicleExport::find()->where(['=', 'export_id', $model->id])->all();
    $object_script = "db_export_vehicle.clients = [];";
    foreach ($all_vehicle_ids as $single_vehicle) {
        $update_singel_vehicle = common\models\Vehicle::find()->where(['=', 'id', $single_vehicle->vehicle_id])->one();
        $customer_name = common\models\Customer::find()->where(['=', 'user_id', $update_singel_vehicle->customer_user_id])->one();
        $update_singel_towing = common\models\TowingRequest::find()->where(['=', 'id', $update_singel_vehicle->towing_request_id])->one();
        if ($update_singel_vehicle->status) {
            $location = common\models\Lookup::$status[$update_singel_vehicle->status];
        } else {
            $location = '';
        }
        if ($update_singel_vehicle->location) {
            $v_location = \common\models\Lookup::$location[$update_singel_vehicle->location];
        } else {
            $v_location = 'no location';
        }
        $cmpany = isset($customer_name->company_name)?$customer_name->company_name:'';
        $object_script .= 'InsertObj ={Year: "' . $update_singel_vehicle->year . '"
              ,Make: "' . $update_singel_vehicle->make . '"
              ,Model: "' . $update_singel_vehicle->model . '"
              ,Color: "' . $update_singel_vehicle->color . '"
              ,Vin: "' . $update_singel_vehicle->vin . '"
              ,Status: "' . $location . '"
              ,Title: "' . $update_singel_towing->title_number . '"
                  ,State: "' . $update_singel_towing->title_state . '"
                  ,Location: "' . $v_location . '"
              ,Lot: "' . $update_singel_vehicle->lot_number . '"
             ,Customer: "' . $cmpany . '" };';
        $object_script .= 'db_export_vehicle.clients.push(InsertObj);console.log(InsertObj);';
        echo $object_script;
    }

}
?>
/************vehicle grid******** */
$('document').ready(function(){
    $("#vehicles").jsGrid({
    //height: "70%",
    width: "100%",
    filtering: true,
    editing: false,
    inserting: true,
    sorting: true,
    //paging: true,
    autoload: true,


    //pageSize: 15,
    //pageButtonCount: 5,
    controller: db_export_vehicle,
    fields: [
        //{name: "DebitAccount", title: "Debit Account", type: "select",id:"invocie_account_drop", items: db_invoice_debit.accounts, valueField: "id", textField: "Name"},
        {name: "Year", title: "Year", type: "text",id:"years", width: "auto",validate: "required"},
      //  {name: "CreditAccount", title: "Credit Account", type: "text", width: 150, validate: "required"},
        {name: "Make", title: "Make", type: "text", width: "auto", validate: "required"},
        {name: "Model", title: "Model", type: "text", width: "auto", validate: "required"},
        {name: "Color", title: "Color", type: "text", width: "auto"},
        {name: "Vin", title: "VIN", type: "text", width: "140", validate:"required"},
        {name: "Status", title: "Status", type: "text", width: "auto"},
        {name: "Title", title: "Title Number", type: "text", width: "auto"},
        {name: "State", title: "Title State", width: "auto", type: "text"},
        {name: "Location", title: "Location", width: "auto", type: "text"},
        {name: "Lot", title: "Lot Number", width: "auto", type: "text"},
        {name: "Customer", title: "CUSTOMER NAME", width: "auto", type: "text"},
        //{ name: "Married", title: "Marié", type: "checkbox", sorting: false },
        {type: "control"}
    ]
});
$('.jsgrid-insert-mode-button').click();
});
function addToGrid(vin_id){
    if(vin_id){
        var url = '<?php echo Yii::$app->urlManager->createUrl('vehicle/vehicledetail?vin_id='); ?>'+vin_id;
    $.get(url, function (vehicle_detail) {
        try
        {
            var json = $.parseJSON(vehicle_detail);
            already_in_table = false;
            for (var i = 0; i < window.db_export_vehicle.clients.length; i++) {
              if(window.db_export_vehicle.clients[i].Vin == json.vin){
                      already_in_table = true;
                  }
                  if(window.db_export_vehicle.clients[i].Location != json.location){
                      already_in_table = true;
                  }
            }

            if(already_in_table==false){
              db_export_vehicle.clients.push({
                           Year: json.year,
                           Make: json.make,
                           Model: json.model,
                          Color: json.color,
                          Vin:json.vin,
                          Status: json.status,
                          Title:json.title_number,
                          State:json.title_state,
                          Lot:json.lot_number,
                          Location:json.location,
                          Customer:json.customer,
                       });
             $("#vehicles").jsGrid("loadData");
             $('#vehicles').jsGrid('refresh');
            }

        }
        catch (e) {
        }
    });
}
}


$('#button_vin').click(function(){
    var vin_id = $('#export-vin_search').val();
    addToGrid(vin_id);
});
<?php if(Yii::$app->request->get('cart') && !empty(Yii::$app->session['cart'])){ foreach(Yii::$app->session['cart'] as $cart) { ?>
    addToGrid('<?= $cart ?>');
<?php } } ?>
$('.save-button').click(function(e){
    //let containerImageLimit = 2;
    if(db_export_vehicle.clients == ''){
    $('.vehcle_not_found').html('Add Vehicle Please');
    e.preventDefault();
    return;
    }else{

          let totalImages = $('.field-container .kv-preview-thumb').length;

    if(totalImages > 0 && totalImages <0) {
        alert('Please upload 50 or more Container Images.');
        return false;
    }


    // let totalImagesblank = $('.field-blankcontainer .kv-preview-thumb').length;
    // if(totalImagesblank > 0 && totalImagesblank < 0) {
    //     alert('Please upload 4 or more Blank Container Images.');
    //     return false;
    // }
    $('#export-hidden').val(JSON.stringify({ vehicle_info: db_export_vehicle.clients }));
    }


});
</script>