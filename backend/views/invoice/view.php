<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii2assets\printthis\PrintThis;
/* @var $this yii\web\View */
/* @var $model common\models\Invoice */
$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Invoices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-view">

    <h1></h1>
      <?php
                $user_id = Yii::$app->user->getId();
                $Role = Yii::$app->authManager->getRolesByUser($user_id);
                if (isset($Role['customer'])) {
                    
                } else {
                    ?>
                   <p>
                <?= Html::button(Yii::t('app', 'Update'), ['value' => Yii::$app->urlManager->createUrl('invoice/update?id=' . $model->id), 'class' => 'btn btn-primary click_modal']) ?>
 
    </p>
            <?php } ?>
   
    <?php
    Modal::begin([
       
        'id'=>'modal',
        'size'=>'modal-lg',
    ]);
    
    echo '<div id="modalContent"></div>';
    
    Modal::end(); ?>

                  <div class="panel-body" id="btninvoice" style="margin:auto;">
                                        <div class="">
                                             <section class="content invoice">
                                                <!-- title row -->
                                                <div class="row">
                                                  <div class=" invoice-header">
                                                    <h1>
                                                      <i class="fa fa-globe"></i> Invoice
                                                        <small class="pull-right">Invoice Date: <?= date('Y-m-d',strtotime($model->created_at));?></small>
                                                    </h1>
                                                  </div>
                                                  <!-- /.col -->
                                                </div>
                                                <!-- info row -->

                                                <div class="row invoice-info">
                                                  <div class="col-sm-4 invoice-col" style="float: left;">
                                                  To
                                                    <address>

                                                        <strong><?php echo isset($model->customerUser->customer_name)?$model->customerUser->customer_name:null; ?></strong>
                                                          <br><?php echo isset( $model->customerUser->address_line_2)?$model->customerUser->address_line_2:null; ?>
                                                          <br>Phone: <?php echo isset($model->customerUser->phone_two)?$model->customerUser->phone_two:null ?>
                                                          <br>Email: <?php echo isset($model->customerUser->user->email)?$model->customerUser->user->email:null; ?>
                                                          <br>TIN OVERSEAS: <?php echo isset($model->customerUser->tax_id)?$model->customerUser->tax_id:null; ?>
                                                       
                                                          
                                                          
                                                    </address>
                                                  </div>
                                                  <!-- /.col -->
                                                  <div class="col-sm-4 invoice-col" style="float:left">
                                                  From
                                                    <address>
                                                       <strong>AFG Global SHIPPING LLC</strong>
                                                            <br>AFG Global Shipping 290 NYE AVE, Irvington, NJ 07111
                                                            <BR>Port Saeed, Dubai 
                                                              <br>Phone: +971-4224-9714–715    
                                                              <br>  Fax : 04-2249718                                                  
                                                                    <br>Email: amin@AFG Globalworldwide.com  
                                                                    <br> VAT REG NO: 100286677800003  
                                                       <br>                                                    </address>
                                                  </div>
                                                  <!-- /.col -->


                                                  <div class="col-sm-4 invoice-col">
                                                    <address>
                                                        <strong>Invoice # <?= $model->id?>                                                      </strong><br>
                                                        ETA: <?= $model->export->eta;?>   </br>
                                                        Booking#: <?= $model->export->booking_number;?><br>
                                                        <?php $vehicleExportdetal =  common\models\VehicleExport::find()->where(['export_id'=>$model->export->id])->one(); ?>
                                                        <?php if($vehicleExportdetal) { ?>
                                                        <?php $vehicledetal =  common\models\Vehicle::findOne(['id'=>$vehicleExportdetal->vehicle_id]) ?>
                                                        Location#: <?= isset(\common\models\Lookup::$location[$vehicledetal->location])?\common\models\Lookup::$location[$vehicledetal->location]:$vehicledetal->location;?>                                                                                                          
                                                        <br>
                                                        <?php } ?>
                                                        Container#: <?= $model->export->container_number;?> </br>
                                                        AR Number#: <?= $model->export->ar_number;?>                                                      </address>
                                                  </div>
                                                  <!-- /.col -->
                                                </div>
                                                <!-- /.row -->

                                                <!-- Table row -->
                                                <div class="row">
                                                  <div class="vehicle-export-invoice-table">
                                                    <table class="table table-striped table-responsive" style="">
                                                      <thead>
                                                        <tr>
                                                          <th style="width:120px;text-align: center;background: #f5f5ef;padding: 5px;font-size: 12px;color:black !important;;font-weight:bold;">VIN NO</th>
                                                          <th style="width:85px;text-align: center;background: #f5f5ef;padding: 5px;font-size: 12px;color:black !important;;font-weight:bold;">Information</th>

                                                          <th style="width:280px;text-align: center;background: #f5f5ef;padding: 5px;font-size: 12px;color:black !important;;font-weight:bold;">Amount Description</th>
                                                          <th style="width:50px;text-align: center;background: #f5f5ef;padding: 5px;font-size: 12px;color:black !important;;font-weight:bold;">Amount</th>
                                                        </tr>
                                                      </thead>

                                                      <tbody>
                                                      <?php
                                                      $vehicle_export_id = common\models\VehicleExport::find()->where(['=','export_id',$model->export_id])->andWhere(['=','customer_user_id',$model->customer_user_id])->all();            
                                                      foreach($vehicle_export_id as $vehicle_export){
                                                        $singel_vehicle = common\models\Vehicle::find()->where(['=', 'id', $vehicle_export->vehicle_id])->one();
                                                        $total_dues = 0;
                                                      ?>
                                                                    <tr>
                                                                        <td><p class="design"><?php echo isset($singel_vehicle->vin)?$singel_vehicle->vin:null ?></p></td>
                                                                        <td><p class="design"><?php echo isset( $singel_vehicle->make,$singel_vehicle->model)?$singel_vehicle->make.' '.$singel_vehicle->model:null; ?></p></td>
                                                                      
                                                                        <td><p class="design"></p><table class="table table-bordered">
                                                               <tbody><tr style="font-size:12px;">
                                                                    <th>TOWING CHGS</th>
                                                                    <th>STORAGE CHGS</th>
                                                                    <th>TITLE FEE</th>
                                                                    
                                                                    <th>EXCH RATE</th>
                                                                    <th>OCEAN FREIGH & LOADING</th>
                                                                    <th>OTHERS CHGS</th>
                                                                    <th>LOCAL CHGS</th>
                                                                   
                                                                    <!-- <th>Custom Duty</th>
                                                                    <th>Clearance</th>
                                                                    <th>Transportation</th> -->
                                                                    <th>VAT%</th>
                                                                    
                                                                   
                                                                </tr>

                                                                <tr>
                                                                    <td><?= $vehicle_export->towing;?>$</td>
                                                                    <?php  $total_dues = $total_dues + $vehicle_export->towing ; ?>
                                                                    <td><?= $vehicle_export->storage;?>$</td>
                                                                    <?php  $total_dues = $total_dues + $vehicle_export->storage ; ?>
                                                                    <td><?= $vehicle_export->title;?> $</td>
                                                                     <?php  $total_dues = $total_dues + $vehicle_export->title ; ?>
                                                                     <td><?php echo $vehicle_export->exchange_rate;?> AED</td>
                                                                     <?php  $total_dues = $total_dues * $vehicle_export->exchange_rate ; ?>
                                                                    
                                                                     <td><?php echo $vehicle_export->additional;?> AED</td>
                                                                     <?php  $total_dues = $total_dues + $vehicle_export->additional ; ?>
                                                                    
                                                                    <!-- <td> // $vehicle_export->shipping;?> $</td> -->
                                                                  <!-- // $total_dues = $total_dues + $vehicle_export->shipping ;  -->
                                                                    <td><?= $vehicle_export->others;?> AED</td>
                                                                     <?php  $total_dues = $total_dues + $vehicle_export->others ; ?>
                                                                    
                                                                 <td><?= $vehicle_export->local;?> AED</td>
                                                                    <?php  $total_dues = $total_dues + $vehicle_export->local ; ?>
                                                                 <!-- <td> // $vehicle_export->custom_duty;$</td> -->
                                                                     <!-- //$total_dues = $total_dues + $vehicle_export->custom_duty ; -->
                                                                    <!-- <td> // $vehicle_export->clearance;?> $</td> -->
                                                                       <!-- $total_dues = $total_dues + $vehicle_export->clearance  -->
                                                                   
                                                                    <td><?= $vehicle_export->vat;?> AED</td>
                                                                     <?php  $total_dues = $total_dues + $vehicle_export->vat ; ?>
                                                                    
                                                                </tr>


                                                                </tbody></table><p></p></td>
                                                                        <td><br>&gt;Total <br><p class="design"><?= $total_dues;?> $</p></td>

                                                                    </tr>
                                                  
                                                                    <?php } ?>
                                                                   

                                                            
                                                      </tbody>
                                                    </table>
                                                  </div>
                                                  <!-- /.col -->
                                                </div>
                                                <!-- /.row -->
                                                     
                                                <div class="row">
                                                  <!-- accepted payments column -->
                                                  <div class="col-xs-3"><br><br><br><br>
                                                    <p class="lead" contenteditable="">Payment Methods:
                                                    </p><p class="text-muted  well-sm no-shadow" style="margin-top:-20px;" contenteditable="">
                                                      ...................................................
                                                    </p>
                                                  </div>
                                                  <!-- /.col -->

                                                  <div class="col-xs-9">
                                                    <div class="table-responsive">
                                                      <table class="table">
                                                        <tbody>
                                                          <tr>
                                                          <th><b>Discount%</b></th>
                                                               <th><b>Total(before discount)</b></th>
                                                               <th><b>Total(after discount)</b></th>
                                                               <th><b>Total Payment</b></th>
                                                               <th><b>Total Remaining</b></th>
                                                          </tr>
                                                          <tr>
                                                          <td id="total" style="text-align:left;"><b>AED<?= $model->discount;?></b></td>
                                                          <td id="total" style="text-align:left;"><b>AED<?= $model->before_discount;?></b></td>
                                                            <td id="total" style="text-align:left;"><b>AED<?= $model->total_amount;?></b></td>
                                                            <td id="total" style="text-align:left;"><b>AED<?= $model->paid_amount;?></b></td>
                                                             <td id="total" style="text-align:left;"><b>AED<?= $model->total_amount - $model->paid_amount;?></b></td>
                                                          </tr>
                                                        </tbody>
                                                      </table>
                                                    </div>
                                                  </div>
                                                  <!-- /.col -->
                                                </div>
                                                <!-- /.row -->

                                                <!-- this row will not appear when printing -->
                                                <div class="row no-print">
                                                  <div class="col-xs-12">
                                                  <?php echo PrintThis::widget([
                                                            'htmlOptions' => [
                                                              'id' => 'btninvoice',
                                                              'btnClass' => 'btn btn-info',
                                                              'btnId' => 'btnPrintThisinvouce',
                                                              'btnText' => 'Print',
                                                              'btnIcon' => 'fa fa-print'
                                                            ],
                                                            'options' => [
                                                              'debug' => false,
                                                              'importCSS' => true,
                                                              'importStyle' => false,
                                                              'loadCSS' => "/assets_b/css/print.css",
                                                              'pageTitle' => "",
                                                              'removeInline' => false,
                                                              'printDelay' => 200,
                                                              'header' => null,
                                                              'formValues' => true,
                                                            ]
                                                          ]);
                                                    ?>
                                                  </div>
                                                </div>
                                              </section>
                                        </div>
                                  
                                    <div class="col-md-4 no-print">
                                    <?php
                                    if ($model->upload_invoice) {
                    ?>
                    <h4>Download Tax Invoice</h4>
                    <a href="<?php echo \yii\helpers\Url::to('@web/uploads/' . $model->upload_invoice, true) ?>" target="_blank"><img src="<?= \yii\helpers\Url::to('@web/uploads/invoice.png', true) ?>" width="150" height="150"></a>
                <?php } else { ?>
                    <h4>No Invoice Uploaded</h4>
                <?php } ?>
                                    </div>
                                    <div class="col-md-8"></div>

</div>
</div>