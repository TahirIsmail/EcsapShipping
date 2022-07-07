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
                    'initValueText' => isset($model->customerUser->customer_name) ? $model->customerUser->address_line_2 : "",
                //'theme' => Select2::THEME_KRAJEE,
                'options' => ['placeholder' => 'Select Customer ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    //'autocomplete' => true,
                    'tabindex' => false,
                    'ajax' => [
                        'url' =>  Yii::$app->urlManager->createUrl('/customer/allcustomer'),
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
                <label class="control-label col-sm-4" for="customer_name">Customer Address</label>  
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
            $towing->condition = '0';
            $towing->damaged = '1';
            //$towing->title_type = '1';
        }
        ?>
        <?=
        $form->field($towing, 'condition')->radioList([
            '0' => 'Non-Op',
            '1' => 'Operable',
            
        ]);
        ?>
        <?=
        $form->field($towing, 'damaged')->radioList([
            '1' => 'Yes',
            '0' => 'No',
        ]);
        ?>
        <div class="checkbox-kartick">
            <?php
            echo CheckboxX::widget([
                'model' => $towing,
                'attribute' => 'pictures',
                'autoLabel' => true,
                'pluginOptions' => [
                    'threeState' => false,
                    'size' => 'lg'
                ],
                'labelSettings' => [
                    'position' => CheckboxX::LABEL_LEFT
                ]
            ]);
            ?>
        </div>

        <div class="checkbox-kartick-one">
            <?php
            echo CheckboxX::widget([
                'model' => $towing,
                'attribute' => 'towed',
                'autoLabel' => true,
                'pluginOptions' => [
                    'threeState' => false,
                    'size' => 'lg'
                ],
                'labelSettings' => [
                    'position' => CheckboxX::LABEL_LEFT
                ]
            ]);
            ?>
        </div>
  
        <div class="checkbox-kartick-one check-box-keys">
            <?php
            echo CheckboxX::widget([
                'model' => $model,
                'attribute' => 'keys',
                'autoLabel' => true,
                'pluginOptions' => [
                    'threeState' => false,
                    'size' => 'lg',
                    'checked'=> '1',
                    'onchange'=>'keysChanged()'
                ],
                'labelSettings' => [
                    'position' => CheckboxX::LABEL_LEFT
                ]
            ]);
            ?>
        </div>
       <h4>TITLE INFO</h4>
       <hr>
   
        <div class="checkbox-kartick-two">
            <?php
            echo CheckboxX::widget([
                'model' => $towing,
                'id'=>'title_recieved',
                'attribute' => 'title_recieved',
                'autoLabel' => true,
                'pluginOptions' => [
                    'threeState' => false,
                    'size' => 'lg'
                ],
                'labelSettings' => [
                    'position' => CheckboxX::LABEL_LEFT
                ]
            ]);
            ?>
        </div>
        <?=
        $form->field($towing, 'title_type')->radioList(\common\models\Lookup::$title_type_front);
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
        <?=  $form->field($model, 'color')->widget(TypeaheadBasic::classname(), [
                'data' => $model->getUniqueColors(),
                'pluginOptions' => ['highlight' => true],
                'options' => ['placeholder' => 'AUTO COLOR ...'],
            ]); ?>
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

        <?= $form->field($model, 'lot_number')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'towed_amount')->textInput() ?>

        <?= $form->field($model, 'storage_amount')->textInput() ?>
        <?= $form->field($model, 'title_amount')->textInput() ?>
        <?= $form->field($model, 'check_number')->textInput() ?>

        <?= $form->field($model, 'additional_charges')->textInput() ?>
        <?php
       // if(Yii::$app->user->can('super_admin')) {
            echo $form->field($model, 'location')->widget(Select2::classname(), [
                'data' => common\models\Lookup::$location,
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Select a state ...'],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ]);
       // }
        ?>
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

            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
            </div>

        </div>
        <div class="col-md-2"></div>
    </div>


<?php ActiveForm::end(); ?>

</div>
<script>
    $('body').on('change','#vehicle-customer_user_id', function () {

        $.post("<?php echo Yii::$app->urlManager->createUrl('/customer/getcustomer?id='); ?>" + $(this).val(), function (data) {
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
        var $el = $("#customer_user_id"), // your input id for the HTML select input
    settings = $el.attr('data-krajee-select2');
settings = window[settings];
// reinitialize plugin
$el.select2(settings);
        $("body").on('DOMSubtreeModified', ".checkbox-kartick-two .cbx.cbx-lg.cbx-active", function() {
            if($('.checkbox-kartick-two').find('span').length==0)
            {
                return;
            }
            
            if($('.checkbox-kartick-two').find('span').find('i').length==1)
            {
            $('.field-towingrequest-title_type').addClass('show_title');
            }
            else
            {
            $('.field-towingrequest-title_type').removeClass('show_title');
            }
           
        });      
    });
$(function()
{
    $("body").on('change','#vehicle-keys', function()
    {
        if ( $("#vehicle-keys").val() == 0)
        {
            $('.key_checkbox')[0].checked = false;
        }else{
            $('.key_checkbox')[0].checked = true;
        }
    });
    $("body").on('change','.key_checkbox', function()
    {
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