<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;
use yii2assets\printthis\PrintThis;
?>

<?php
echo PrintThis::widget([
	'htmlOptions' => [
		'id' => 'btnhazardous',
		'btnClass' => 'btn btn-primary',
		'btnId' => 'btnPrintThishazardous',
		'btnText' => 'Print',
		'btnIcon' => 'fa fa-print'
	],
	'options' => [
		'debug' => false,
		'importCSS' => true,
		'importStyle' => false,

		//'loadCSS' => "path/to/my.css",
		'pageTitle' => "NON HAZARDOUS MATERIAL",
		'removeInline' => false,
		'printDelay' => 200,
		'header' => null,
		'formValues' => true,
	]
]);

$all_vehicles_ids = $model->vehicleExports;
?>


 <div id="btnhazardous" class="condition_report" contenteditable="true">

                            <div class="non_haz">

                                <table width="100%">
                                    <tbody><tr>
                                            <td align="center">  
                                            <img src="<?= \yii\helpers\Url::to('@web/uploads/logo.png', true) ?>" width="224" height="72" alt="AFG GlobalW Logo">
                                            </td></tr>
                                    </tbody></table>
                                <br>
                                <table width="100%">
                                    <tbody><tr><th id="impa">NON-HAZARDOUS DECLERATION</th></tr>
                                    </tbody></table>

                                <br>
                                <table width="100%" border="1">
                                    <tbody><tr><td width="33%">CARRIER</td><td align="center" width="67%"><?php if(isset($model->streamship_line)){echo $model->streamship_line;}; ?></td></tr>
                                        <tr><td>VESSEL NAME / VOYAGE</td><td align="center"><?= $model->vessel.'&nbsp;/&nbsp;'.$model->voyage; ?></td></tr>
                                        <tr><td>ORIGIN</td><td align="center"><?= $model->port_of_loading; ?></td></tr>
                                        <tr><td>DESTINATION</td><td align="center"><?= $model->destination; ?></td></tr>
                                        <tr><td>BOOKING NUMBER</td><td align="center"><?= $model->booking_number; ?></td></tr>
                                        <tr><td>CONTAINER NUMBER</td><td align="center"><?= $model->container_number; ?></td></tr>
                                        <tr><td>NUMBER OF VEHICLES</td><td align="center"><?= count($all_vehicles_ids) ?></td></tr>
                                    </tbody></table>
                                <br>
                                <br>
                                <table width="100%">
                                    <tbody><tr><td align="left">THIS IS TO CERTIFY THAT ALL VEHICLES INCLUDED IN
                                                THIS CONTAINER HAVE BEEN COMPLETELY DRAINED
                                                OF FUEL AND RUN UNTIL STALLED. BATTERIES ARE
                                                DISCONNECTED AND TAPED BACK AND ARE PROPERLY
                                                SECURED TO PREVENT MOVEMENT IN ANY DIRECTION.
                                                NO UNDECLARED HAZARDOUS MATERIALS ARE
                                                CONTAINERIZED, SECURED TO, OR STOWED IN THIS
                                                VEHICLE.<br>
                                                WITH THE ABOVE STATEMENT, THESE VEHICLES ARE
                                                CLASSIFIED AS NON-HAZARDOUS.</td>
                                        </tr></tbody></table>
                                <br>
                                <table width="100%">
                                    <tbody><tr>
                                            <td width="11%">SIGNED</td>
                                            <td width="46%" align="center" class="line_under">
                                            
                                            </td>
                                            <td width="8%">DATE</td>
                                            <td width="35%" align="center" class="line_under"><?php // date('Y-m-d'); ?></td>
                                        </tr>

                                    </tbody></table>
                            </div>



                        </div>


