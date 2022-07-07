<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use kartik\file\FileInput;
use yii\helpers\Url;
use kartik\date\DatePicker;
use kartik\checkbox\CheckboxX;
use kartik\typeahead\TypeaheadBasic;
use kartik\typeahead\Typeahead;
/* @var $this yii\web\View */
/* @var $model common\models\Vehicle */
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
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<div class="vehicle-form">

    <?php
    $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],
                'id' => 'vehicle-form',
                'enableClientValidation' => true,
                'enableAjaxValidation' => false,
                'options' => [
                    'validateOnSubmit' => true,
                    'class' => 'form'
                ],
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'horizontalCssClasses' => [
                        'label' => 'col-sm-4',
                        // 'offset' => 'col-sm-offset-2',
                        'wrapper' => 'col-sm-8',
                    ],
                ],
    ]);
    ?>
    <div class="col-md-6">
        <h4>CUSTOMER INFO</h4>
        <div class="selection">
		<input type="hidden" name="MAX_FILE_SIZE" value="300000000" /> 
        <?php
                echo $form->field($model, 'customer_user_id')->widget(Select2::classname(), [
                    'attribute' => 'customer_user_id',
                    'id' => 'consignee-customer_user_id',
                    'value' => $model->customer_user_id,
                    'initValueText' => isset($model->customerUser->customer_name) ? $model->customerUser->company_name : "",
                //'theme' => Select2::THEME_KRAJEE,
                'options' => ['placeholder' => 'Select Customer ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    //'autocomplete' => true,
                    'tabindex' => false,
                    'ajax' => [
                        'url' => Yii::$app->urlManager->createUrl('customer/allcustomer'),
                        'dataType' => 'json',
                        'data' => new \yii\web\JsExpression('function(params) { return {q:params.term,withadmins:0}; }')
                    ],
                    'escapeMarkup' => new \yii\web\JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new \yii\web\JsExpression('formatRepo'),
                    'templateSelection' => new \yii\web\JsExpression('formatRepoSelection')
                ],
                ]);
            ?>
            <div class="form-group field-vehicle-hat_number has-success">
                <label class="control-label col-sm-4" for="customer_name">Customer ID</label>  
                <div class="col-sm-8">
                    <input type="text" id="customer_id_ref" readonly="true" class="form-control"  maxlength="45" aria-invalid="false" value="<?php if (isset($model->customerUser->legacy_customer_id)) echo $model->customerUser->legacy_customer_id; ?>">
                    <div class="help-block"></div>
                </div>
            </div>
            <div class="form-group field-vehicle-hat_number has-success">
                <label class="control-label col-sm-4" for="customer_name">Company Name</label>
                <div class="col-sm-8">
                    <input type="text" id="customer_address" readonly="true" class="form-control"  maxlength="45" aria-invalid="false" value="<?php if (isset($model->customerUser->company_name)) echo $model->customerUser->company_name; ?>">
                    <div class="help-block"></div>
                </div>
            </div>

        </div>
        <hr>
         <h4>TOWING INFO</h4>
        <?php
        if ($model->isNewRecord) {
            // $towing->condition = '0';
            // $towing->damaged = '1';
            // $towing->towed = '0';
            // $model->keys = '0';
            // $towing->pictures = '0';
        }
        ?>
        <?=
        $form->field($towing, 'condition')->inline()->radioList(['0' => 'Non-Op','1' => 'Operable']);
        ?>
        <?=
        $form->field($towing, 'damaged')->inline()->radioList([
            '1' => 'Yes',
            '0' => 'No'
        ]);
        ?>
        <?=
        $form->field($towing, 'pictures')->inline()->radioList([
            '1' => 'Yes',
            '0' => 'No'
        ]);
        ?>

         <?=
        $form->field($towing, 'towed')->inline()->radioList([
            '1' => 'Yes',
            '0' => 'No'
        ]);
        ?>
<!-- ->inline() -->
        <?=
        $form->field($model, 'keys')->inline()->radioList([
            '1' => 'Yes',
            '0' => 'No',
        ],['class' => 'i-checks']);
        ?>
        <?= $form->field($model, 'key_note')->textInput(['maxlength' => true]); ?>
  
       <h4>TITLE INFO</h4>
       <hr>
   
        <?=
        $form->field($towing, 'title_type')->widget(Select2::className(),
            [
                'data' => common\models\Lookup::$title_type_front,
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Select a title ...'],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ]
            );
        ?>

        <?=
        $form->field($towing, 'title_recieved_date')->widget(DatePicker::className(), [
            'options' => ['placeholder' => 'Select title recieved date ...'],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ])
        ?>             

        <?= $form->field($towing, 'title_number')->textInput(['maxlength' => true]) ?>

        <?= $form->field($towing, 'title_state')->textInput(['maxlength' => true]) ?>
        <?=
        $form->field($towing, 'towing_request_date')->widget(DatePicker::className(), [
            'options' => ['placeholder' => 'Select towing request date ...'],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ])
        ?>
        <?=
        $form->field($towing, 'pickup_date')->widget(DatePicker::className(), [
            'options' => ['placeholder' => 'Select pickup date ...'],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ])
        ?>
        <?=
        $form->field($towing, 'deliver_date')->widget(DatePicker::className(), [
            'options' => ['placeholder' => 'Select deliver date ...'],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ])
        ?>
        <?= $form->field($towing, 'note')->textarea(['rows' => 3]) ?>

    </div>

    <div class="col-md-6">
        <h4>    VEHICLE INFO</h4>
<?php
echo $form->field($model, 'status')->widget(Select2::classname(), [
    'data' => common\models\Lookup::$status_without_auto,
    'theme' => Select2::THEME_BOOTSTRAP,
    'options' => ['placeholder' => 'Select a status ...'],
    'pluginOptions' => [
        'allowClear' => false
    ],
]);
?>
<!--  For vehicle type   -->
<?php
echo $form->field($model, 'vehicle_type')->widget(Select2::classname(), [
    'data' => common\models\Lookup::$vehicle_type,
    'theme' => Select2::THEME_BOOTSTRAP,
    'options' => ['placeholder' => 'Select a type ...'],
    'pluginOptions' => [
        'allowClear' => false
    ],
]);
?>
        
        <div class="col-md-10" style="padding-left: 60px;">
            <?= $form->field($model, 'vin')->textInput(['maxlength' => true], ['enableAjaxValidation' => true]) ?>
        </div>
        <div class="col-md-2">
            <button type='button' class='btn' id="vehicle-btn-auto">Auto Fill</button>
        </div>
        <?=
        $form->field($model, 'year')->widget(DatePicker::className(), [
            'options' => ['placeholder' => 'Select Year'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy',
                'minViewMode' => 2
            ]
        ])
        ?>

        <?php // $form->field($model, 'color')->textInput(['maxlength' => true]) ?>
        <?php echo $form->field($model, 'color')->widget(Select2::classname(), [
                'data' =>  $model->getUniqueColors(),
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Select a type ...'],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ]);?>
            <?=  $form->field($model, 'model')->widget(TypeaheadBasic::classname(), [
                'data' => $model->getUniqueModel(),
                'pluginOptions' => ['highlight' => true],
                'options' => ['placeholder' => 'AUTO MODEL ...'],
            ]); ?>
            <?=  $form->field($model, 'make')->widget(TypeaheadBasic::classname(), [
                'data' => $model->getUniqueMake(),
                'pluginOptions' => ['highlight' => true],
                'options' => ['placeholder' => 'AUTO MAKE ...'],
            ]); ?>
        <?= $form->field($model, 'hat_number')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'license_number')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'towed_from')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'lot_number')->textInput(['maxlength' => true,'minlength' => 8]) ?>

        <?= $form->field($model, 'towed_amount')->textInput() ?>

        <?= $form->field($model, 'storage_amount')->textInput() ?>
        <?= $form->field($model, 'title_amount')->textInput() ?>
        <?= $form->field($model, 'check_number')->textInput() ?>

        <?= $form->field($model, 'additional_charges')->textInput() ?>
        <?php
        if(Yii::$app->user->can('super_admin')) {
            echo $form->field($model, 'location')->widget(Select2::classname(), [
                'data' => common\models\Lookup::$location,
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Select a state ...'],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ]);
        }
        ?>
        <?= $form->field($model, 'preparedby')->textInput() ?>
    </div>
    <hr>
    <div class="col-md-12">
        <h4>CHECK OPTIONS INCLUDED ON THE VEHICLE</h4>
        <?php
      
        foreach ($features as $features) {
            $checked = false;
            $update_singel_feature = common\models\VehicleFeatures::find()->where(['=', 'features_id', $features['id']])->andWhere(['=', 'vehicle_id', $model->id])->one();
            if ($update_singel_feature ) {
                $checked = true;
            }
            $class = "";
            if($features['id']==1){
                $class="key_checkbox";
            }
            ?>
            <div class="col-md-3">
                <label>
                    <input class="<?= $class ?>" type="checkbox" id="" name="VehicleFeatures[value][<?php echo $features['id'] ?>]" value="1" <?php if ($checked == true) {
                        echo "checked='checked'";
                    } ?> aria-invalid="false">
                    <?php echo $features['name']; ?>
                </label>
            </div>
    <?php
}
?>
    </div>
    <hr>
    <div class="col-md-12">
        <h4>CONDITION OF VEHICLE</h4>
        <?php
      //  $c = 1;
       
        foreach ($condition as $key=>$condition) {
            $value = '';
            $count = $key+1;
            $update_singel_condition = common\models\VehicleCondition::find()->where(['=', 'condition_id', $condition['id']])->andWhere(['=', 'vehicle_id', $model->id])->one();
         
            if ($update_singel_condition) {
                $value = $update_singel_condition['value'];
            }
           
            ?>   
            <div class="col-md-2">
                <div class="form-group field-vehicle-location has-success">
                   <label style='font-size:12px;'><?= $count ?> - <?php echo $condition['name'] ?> </label>
                    <input type="text" style='text-transform: uppercase;' id="" class="form-control" name="VehicleCondition[value][<?php echo $condition['id'] ?>]" aria-invalid="false" value="<?php echo $value; ?>">
                </div>
            </div>

                    <?php
                   
                }
                if($model->isNewRecord){
                    $all_images_preview = [];
                }
                ?>
    </div>
    <hr>
    <style type="text/css">
    	#vehicle-form .error {
      color: #a94442;
     /* background-color: #acf; 
      border: 2px solid #a94442;*/
      font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 12px;
    line-height: 1.42857143;
    margin-top: 5px;
    margin-bottom: 10px;
   }
    </style>
    <div class="row">
        <div class="col-md-12">
            <label class="control-label">VEHICLE DOCUMENTS</label>
        </div>
        <div class="col-md-12">
        <?php
        echo $form->field($docs, 'name[]')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*', 'multiple' => true],
            'id' => 'docs_file_input',
            'pluginOptions' => [
                'previewFileType' => 'image',
                'allowedFileExtensions' => ['jpg', 'gif', 'png', 'bmp', 'jpeg', 'pdf', 'doc', 'docx'],
                'showUpload' => true,
                'initialPreview' => $all_docs,
                'initialPreviewConfig' => $all_docs_preview,
                'overwriteInitial' => false,
                'showRemove' => true,
                'showPreview' => true,
                'uploadUrl' => Url::to(['cases/upload']),
                //'onRemove'=>'alert()'
            ],
        ])->label(false);

        ?>
        </div>
        <div class="col-md-12">
            <label class="control-label">VEHICLE PHOTOS</label>
        </div>
        <div class="col-md-12">
        <?=
        $form->field($images, 'name[]')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*', 'multiple' => true],
            'pluginOptions' => [
                'previewFileType' => 'image',
                'allowedFileExtensions' => ['jpg', 'gif', 'png', 'bmp','jpeg'],
                'showUpload' => true,
                'initialPreview' => $all_images,
                'initialPreviewConfig'=>$all_images_preview,
                'overwriteInitial' => false,
                'showRemove' => true,
                'showPreview' => true,
                'uploadUrl' => Url::to(['cases/upload']),
                //'onRemove'=>'alert()'
            ],
        ])->label(false);;
        ?>
            <hr>
            <div class="col-md-offset-2 col-md-8">

            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary', 'id' => 'submitBtn']) ?>
            </div>

        </div>
        <div class="col-md-2"></div>
    </div>


<?php ActiveForm::end(); ?>

</div>
<script>
    $('body').on('change','#vehicle-customer_user_id', function () {

        $.post("<?php echo Yii::$app->urlManager->createUrl('customer/getcustomer'); ?>?id=" + $(this).val(), function (data) {
            //$("#customer_address").val(data);
            var d =JSON.parse(data);
            if(d.address_line_1){
                $("#customer_address").val(d.address_line_1);
            }
            //customer_id_ref
            if(d.legacy_customer_id){
                $("#customer_id_ref").val(d.legacy_customer_id);
            }
        });
    });


    $( document ).ready(function() {
        let vehicleImageLimit = 20;
        var $el = $("#customer_user_id"), // your input id for the HTML select input
        settings = $el.attr('data-krajee-select2');
        settings = window[settings];
        // reinitialize plugin
        $el.select2(settings);

        // vehicle upload photo count
        $('#submitBtn').on('click', function () {
            let vehicleStatus = $('#vehicle-status').val();
            var rules = {};

            if(vehicleStatus == 3) {

                var towed = $('input[name="TowingRequest[towed]"]:checked').val();

                if(towed == 1) {
                	
                    rules["TowingRequest[towing_request_date]"] = {
                        required: true
                    };

                    rules["Vehicle[towed_from]"] = {
                        required: true
                    };
                    $('#vehicle-form').yiiActiveForm('remove','TowingRequest[deliver_date]');
                    
                   
                }  
            } else if(vehicleStatus == 1) {

                    rules["Vehicle[towed_from]"] = {
                        required: true
                    };

                    rules["Vehicle[year]"] = {
                        required: true
                    };
                    rules["Vehicle[make]"] = {
                        required: true
                    };
                    rules["Vehicle[model]"] = {
                        required: true
                    };
                    rules["Vehicle[location]"] = {
                    	required :true
                    }; 
                    rules["Images[name][]"]={
                    	required : true
                    };
                    rules["TowingRequest[towed]"]={
                    	required : true
                    };
                    rules["Vehicle[keys]"]={
                    	required : true
                    };
                    rules["TowingRequest[pictures]"]={
                    	required : true
                    };
                    rules["TowingRequest[title_number]"]={
                    	required : true
                    };
                    rules["TowingRequest[towing_request_date]"]={
                    	required : true
                    };
                    rules["TowingRequest[deliver_date]"]={
                    	required : true
                    };

                let totalImages = $('.field-images-name .kv-preview-thumb').length;

                if(totalImages < vehicleImageLimit) {
                    alert('Please upload '+vehicleImageLimit+' or more Vehicle Photos.');
                    return false;
                }
            }

           console.log(rules);
            $('#vehicle-form').validate({
            	
                rules: rules,
                 highlight: function (element) {
                $(element).parent().addClass('error')
                // closest("div.form-group")
            },
            unhighlight: function (element) {
                $(element).parent().removeClass('error')
            }
            });
        });
    });
    $(function() {
    $("body").on('change','#vehicle-keys', function()
    {
        if ( $("#vehicle-keys").val() == 0)
        {
            $('.key_checkbox')[0].checked = false;
        }else{
            $('.key_checkbox')[0].checked = true;
        }
    });
    $("body").on('change','.key_checkbox', function() {
        $("#vehicle-keys").click();
    });
    $('body').on('click','#vehicle-btn-auto',function(){
        vin = $('#vehicle-vin').val();
        if(vin.length!=17){
            //alert('VIN NEEDS TO BE 17 DIGIT');
            //return;
        }
        var url ='https://vpic.nhtsa.dot.gov/api/vehicles/decodevinvaluesextended/'+vin+'?format=json';
        $.ajax({
                type: "GET",
                //data:  {id:id, status:status,location: location },
               // data: "id="+id+"status+"+status,
                url: url,
                success: function (data) {
                    if(data.Results[0].Model){
                        $('#vehicle-year').val(data.Results[0].ModelYear);
                        $('#vehicle-model').val(data.Results[0].Model.toUpperCase());
                        $('#vehicle-make').val(data.Results[0].Make.toUpperCase());
                        $('#vehicle-weight').val(data.Results[0].GVWR.toUpperCase());
                        //$('.field-vehicle-vin .help-block').html('full match');
                    }
                    
                    //data.Results[0].Make
                    //debugger;
                },
                error: function (exception) {
                    alert(exception);
                }
            });
    })
});
</script>