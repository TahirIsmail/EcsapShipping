<?php



namespace backend\controllers;

if (!isset($_SESSION)) {

    session_start();

}

use common\models\LoginForm;

use kartik\mpdf\Pdf;

use Yii;

use yii\filters\AccessControl;

use yii\filters\VerbFilter;

use yii\web\Controller;

use backend\models\PasswordResetRequestForm;

use yii\web\Response;

use  yii\web\Session;

use yii\widgets\ActiveForm;

use backend\models\ResetPasswordForm;

use common\models\User;



/**

 * Site controller.

 */

class SiteController extends \backend\components\AmayaController {



    /**

     * Displays homepage.

     *

     * @return string

     */

    public function actionIndex() {

        $searchModel = new \common\models\VehicleSearch();

        $searchModel->id = 0;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $user_id = Yii::$app->user->getId();

        $Role = Yii::$app->authManager->getRolesByUser($user_id);

        $all_vehicle = '';

        $vehicle_location_LA = '';

        $vehicle_location_GA = '';

        $vehicle_location_NY = '';

        $vehicle_location_TX = '';

        $vehicle_location_BALTO = '';

        $vehicle_location_NJ2 = '';

        $vehicle_location_TEXAS = '';
           $vehicle_location_NJ = '';

        $all_vehicle_location_wise = [];

        $all_export = '';

        $location = '';

        if (!isset($Role['customer'])) {

            $invoices = \common\models\Invoice::allInvoiceCounts();

        }

        if (isset($Role['customer'])) {

            $all_vehicle = \common\models\Vehicle::all_vehicle_report_customer($user_id);            

            $vehicle_location_LA = \common\models\Vehicle::all_vehicle_location_report_customer($location = '1', $user_id);

            $vehicle_location_GA = \common\models\Vehicle::all_vehicle_location_report_customer($location = '2', $user_id);

            $vehicle_location_NY = \common\models\Vehicle::all_vehicle_location_report_customer($location = '3', $user_id);

            $vehicle_location_TX = \common\models\Vehicle::all_vehicle_location_report_customer($location = '4', $user_id);

            $vehicle_location_BALTO = \common\models\Vehicle::all_vehicle_location_report_customer($location = '5', $user_id);

            $vehicle_location_NJ2 = \common\models\Vehicle::all_vehicle_location_report_customer($location = '6', $user_id);

            $vehicle_location_TEXAS = \common\models\Vehicle::all_vehicle_location_report_customer($location = '7', $user_id);  
             $vehicle_location_NJ = \common\models\Vehicle::all_vehicle_location_report_customer($location = '8', $user_id);    

            $locations = \common\models\Location::getLocationDropDrown(true);

            $all_vehicle_location_wise = [];

            foreach ($locations as $location_id => $location_name) {

                $all_vehicle_location_wise[$location_name] = \common\models\Vehicle::all_vehicle_location_report_customer($location_id, $user_id);

            }

            $all_export = \common\models\VehicleExport::all_export($user_id);

            $view = 'customer_index';

            $invoices = \common\models\Invoice::allInvoiceCounts($user_id);

        } elseif (isset($Role['admin_LA'])) {

            $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '1');

            $view = 'customer_admin';

        } elseif (isset($Role['admin_GA'])) {

            $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '2');

            $view = 'customer_admin';

        } elseif (isset($Role['admin_NY'])) {

            $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '3');

            $view = 'customer_admin';

        } elseif (isset($Role['admin_TX'])) {

            $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '4');

            $view = 'customer_admin';

        } elseif (isset($Role['admin_BALTO'])) {

            $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '5');

            $view = 'customer_admin';

        } elseif (isset($Role['admin_NJ2'])) {

            $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '6');

            $view = 'customer_admin';

        } elseif (isset($Role['admin_TEXAS'])) {

            $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '7');

            $view = 'customer_admin';

        }
        elseif (isset($Role['admin_NEWJ'])) {

            $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '8');

            $view = 'customer_admin';

        }







        else {

            $all_vehicle = \common\models\Vehicle::all_vehicle_report();

            $vehicle_location_LA = \common\models\Vehicle::all_vehicle_location_report($location = '1');

            $vehicle_location_GA = \common\models\Vehicle::all_vehicle_location_report($location = '2');

            $vehicle_location_NY = \common\models\Vehicle::all_vehicle_location_report($location = '3');

            $vehicle_location_TX = \common\models\Vehicle::all_vehicle_location_report($location = '4');

            $vehicle_location_BALTO = \common\models\Vehicle::all_vehicle_location_report($location = '5');

            $vehicle_location_NJ2 = \common\models\Vehicle::all_vehicle_location_report($location = '6');

            $vehicle_location_TEXAS= \common\models\Vehicle::all_vehicle_location_report($location = '7');
            $vehicle_location_NJ= \common\models\Vehicle::all_vehicle_location_report($location = '8');

            $locations = \common\models\Location::getLocationDropDrown(true);

            $all_vehicle_location_wise = [];

            foreach ($locations as $location_id => $location_name) {

                $all_vehicle_location_wise[$location_name] = \common\models\Vehicle::all_vehicle_location_report($location_id);

            }

            $view = 'index';

        }

         $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

        //   if (!Yii::$app->user->isGuest) {

        //     return $this->goHome();

        // }

      $sql = "select * from user where id = " . Yii::$app->user->id .' AND status != 0';



            $connection = Yii::$app->getDb();

            $cmdrow = $connection->createCommand($sql);

            $rows = $cmdrow->queryOne();

            if(!empty($rows) > 0){

                        

                        $session = Yii::$app->session;

                        // open a session

                        $session->open();

                        $session->set('amaya_auth_key',$rows['auth_key']);

                        $_SESSION["user_array"]=$rows;

                        $session->close();

            

                        $searchModel = new \common\models\VehicleSearch();

                    $searchModel->id = 0;

                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                    $user_id = Yii::$app->user->getId();

                    $Role = Yii::$app->authManager->getRolesByUser($user_id);

                    $all_vehicle = '';

                    $vehicle_location_LA = '';

                    $vehicle_location_GA = '';

                    $vehicle_location_NY = '';

                    $vehicle_location_TX = '';

                    $vehicle_location_BALTO = '';

                    $vehicle_location_NJ2 = '';

                    $vehicle_location_TEXAS = '';

                    $vehicle_location_NJ = '';

                    $all_vehicle_location_wise = [];

                    $all_export = '';

                    $location = '';

                    if (!isset($Role['customer'])) {

                        $invoices = \common\models\Invoice::allInvoiceCounts();

                    }

                    if (isset($Role['customer'])) {

                        $all_vehicle = \common\models\Vehicle::all_vehicle_report_customer($user_id);

                        $vehicle_location_LA = \common\models\Vehicle::all_vehicle_location_report_customer($location = '1', $user_id);

                        $vehicle_location_GA = \common\models\Vehicle::all_vehicle_location_report_customer($location = '2', $user_id);

                        $vehicle_location_NY = \common\models\Vehicle::all_vehicle_location_report_customer($location = '3', $user_id);

                        $vehicle_location_TX = \common\models\Vehicle::all_vehicle_location_report_customer($location = '4', $user_id);

                        $vehicle_location_BALTO = \common\models\Vehicle::all_vehicle_location_report_customer($location = '5', $user_id);

                        $vehicle_location_NJ2 = \common\models\Vehicle::all_vehicle_location_report_customer($location = '6', $user_id);

                        $vehicle_location_TEXAS= \common\models\Vehicle::all_vehicle_location_report_customer($location = '7', $user_id);
                            $vehicle_location_NJ= \common\models\Vehicle::all_vehicle_location_report_customer($location = '8', $user_id);

                        $locations = \common\models\Location::getLocationDropDrown(true);

                        $all_vehicle_location_wise = [];

                        foreach ($locations as $location_id => $location_name) {

                            $all_vehicle_location_wise[$location_name] = \common\models\Vehicle::all_vehicle_location_report_customer($location_id, $user_id);

                        }

                        $all_export = \common\models\VehicleExport::all_export($user_id);

                        $view = 'customer_index';

                        $invoices = \common\models\Invoice::allInvoiceCounts($user_id);

                    } elseif (isset($Role['admin_LA'])) {

                        $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '1');

                        $view = 'customer_admin';

                    } elseif (isset($Role['admin_GA'])) {

                        $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '2');

                        $view = 'customer_admin';

                    } elseif (isset($Role['admin_NY'])) {

                        $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '3');

                        $view = 'customer_admin';

                    } elseif (isset($Role['admin_TX'])) {

                        $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '4');

                        $view = 'customer_admin';

                    } elseif (isset($Role['admin_BALTO'])) {

                        $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '5');

                        $view = 'customer_admin';

                    } elseif (isset($Role['admin_NJ2'])) {

                        $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '6');

                        $view = 'customer_admin';

                    } elseif (isset($Role['admin_TEXAS'])) {

                        $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '7');

                        $view = 'customer_admin';

                    }

                     elseif (isset($Role['admin_NEWJ'])) {

                        $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '8');

                        $view = 'customer_admin';

                    } else {

                        $all_vehicle = \common\models\Vehicle::all_vehicle_report();

                        $vehicle_location_LA = \common\models\Vehicle::all_vehicle_location_report($location = '1');

                        $vehicle_location_GA = \common\models\Vehicle::all_vehicle_location_report($location = '2');

                        $vehicle_location_NY = \common\models\Vehicle::all_vehicle_location_report($location = '3');

                        $vehicle_location_TX = \common\models\Vehicle::all_vehicle_location_report($location = '4');

                        $vehicle_location_BALTO = \common\models\Vehicle::all_vehicle_location_report($location = '5');

                        $vehicle_location_NJ2 = \common\models\Vehicle::all_vehicle_location_report($location = '6');

                        $vehicle_location_TEXAS = \common\models\Vehicle::all_vehicle_location_report($location = '7');
                         $vehicle_location_NJ = \common\models\Vehicle::all_vehicle_location_report($location = '8');

                        $locations = \common\models\Location::getLocationDropDrown(true);

                        $all_vehicle_location_wise = [];

                        foreach ($locations as $location_id => $location_name) {

                            $all_vehicle_location_wise[$location_name] = \common\models\Vehicle::all_vehicle_location_report($location_id);

                        }

                        $view = 'index';

                    }

                   return $this->render($view, [

                             'model' => $model,

                                'searchModel' => $searchModel,

                                'dataProvider' => $dataProvider,

                                'all_vehicle' => $all_vehicle,

                                'all_export' => $all_export,

                                'location' => $location,

                                'vehicle_location_LA' => $vehicle_location_LA,

                                'vehicle_location_GA' => $vehicle_location_GA,

                                'vehicle_location_NY' => $vehicle_location_NY,

                                'vehicle_location_TX' => $vehicle_location_TX,

                                'vehicle_location_BALTO' => $vehicle_location_BALTO,

                                'vehicle_location_NJ2' => $vehicle_location_NJ2,

                                'vehicle_location_TEXAS' => $vehicle_location_TEXAS,
                                 'vehicle_location_NJ' => $vehicle_location_NJ,

                                'invoices' => $invoices,

                                'all_vehicle_location_wise' => $all_vehicle_location_wise

                    ]); 

                 } else {

                  return $this->goHome();

                 }



}

        if(Yii::$app->user->id !=null)

        {

                     return $this->render($view, [

                    'model' => $model,

                    'searchModel' => $searchModel,

                    'dataProvider' => $dataProvider,

                    'all_vehicle' => $all_vehicle,

                    'all_export' => $all_export,

                    'location' => $location,

                    'vehicle_location_LA' => $vehicle_location_LA,

                    'vehicle_location_GA' => $vehicle_location_GA,

                    'vehicle_location_NY' => $vehicle_location_NY,

                    'vehicle_location_TX' => $vehicle_location_TX,

                    'vehicle_location_BALTO' => $vehicle_location_BALTO,

                    'vehicle_location_NJ2' => $vehicle_location_NJ2,

                    'vehicle_location_TEXAS' => $vehicle_location_TEXAS,
                      'vehicle_location_NJ' => $vehicle_location_NJ,

                    'invoices' => $invoices,

                    'all_vehicle_location_wise' => $all_vehicle_location_wise

                    ]);

        }

        unset(Yii::$app->session['user_array']);



     //   $this->layout = "@backend/views/layouts/login";



        return $this->render('login', [

                    'model' => $model,

        ]);

    }

		public function actionBackup() {

			//var_dump(Yii::$app->db->dsn);

			if(Yii::$app->user->can('super_admin')){

				$dsn = explode(";dbname=",Yii::$app->db->dsn);

				if(isset($dsn[1])){

					$db = $dsn[1];

					$user = Yii::$app->db->username;

					$pass = Yii::$app->db->password;

					$filename = 'uploads/backup-file.bak';

					$backup = new \common\models\Backup('localhost',$user,$pass,$db,$filename);

					$backup->backup();

                    $this->redirect('/');

				}

			}

		}

		public function actionDownloadBackup(){

			if(Yii::$app->user->can('super_admin')){

				$filename = 'uploads/backup-file.bak';

				return Yii::$app->response->sendFile($filename);

			}

		}

		public function actionCustomer() {

			// $this->layout='AdminLayout';

			return $this->render('customer_admin');

		}



    /**

     * Login action.

     *

     * @return string

     */

    public function actionLogin() {

        if (!Yii::$app->user->isGuest) {

            return $this->goHome();

        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

          //  Yii::$app->session['first_login'] = true;



            return $this->goBack();

        } 

            return $this->render('login', [

                'model' => $model,

            ]);

    }



    public function actionAjaxcustomer() {

        $id = $_POST['id'];

        $status = $_POST['status'];

        $shipped_values = [];

        $user = $_POST['user'];

        $location = $_POST['location'];

        $title = $_POST['title_recieved'];



        if ($location) {

            $locationName = \common\models\Location::getLocationById($location);

        } else {

            $locationName = 'ALL';

        }

        $company_name = \common\models\Customer::findOne(['user_id' => $user]);



        $shipped_vehicles = \common\models\Vehicle::vehicleStatusList($id, $location, $status, $user, $title);



        // if(empty($id) && $status == 'All'){

        //   $status = 'Shipped';

        //   $id = '4';

        //    $shipped_values = \common\models\Vehicle::vehicleStatusList($id, $location, $status, $user);

        //            }

                   

        $model_vehicle = '';

        if ($shipped_vehicles) {

            $model_vehicle .= '

<table class="ia table table-striped table-bordered" width=100%>

   <tbody>

      <tr>

         <td width=20% align=center id=pipi><b>Inventory</b></td>

         <td width=30%><b>' . $company_name->company_name . '</b></td>

         <td width=12% align=right><b>Sort Type:</b></td>

         <td width=15%>' . $_POST['status'] . '</td>

         <td  align=center></td>

         <td width=15% align=center><b>Location<b></td>

         <td width=10%>' . $locationName . '</td>

      </tr>

   </tbody>

</table>

<table width=100% class="ia table-striped table-bordered" border=1>

   <tbody>

      <tr>

         <th>HAT NO</th>

         <th>DATE RECEIVED</th>

         <th>YEAR</th>

         <th>MAKE</th>

         <th>MODEL</th>

         <th>COLOR</th>

         <th>VIN</th>

         <th>TITLE</th>

         <th>TITLE TYPE</th>

         <th>KEYS</th>

         <th>AGE</th>

         <th>LOT</th>

         <th>STATUS</th>

         <th>NOTE</th>

      </tr>

      ';

            foreach ($shipped_vehicles as $shipped_vehicle) {

                if ($shipped_vehicle['title_type'] == '1') {

                    $title = 'YES';

                } else {

                    $title = 'NO';

                }

                if ($shipped_vehicle['keys'] == '1') {

                    $keys = 'YES';

                } else {

                    $keys = 'NO';

                }

                if ($shipped_vehicle['deliver_date']) {

                    $current_date = date('Y-m-d');

                    $datediff = strtotime($current_date) - strtotime($shipped_vehicle['deliver_date']);

                    //  $datediff = $current_date - $shipped_vehicle['deliver_date'];

                    $days = floor($datediff / (60 * 60 * 24));

                } else {

                    $days = '0';

                }

                if (isset($shipped_vehicle['title_type'])) {

                    $title_type = \common\models\Lookup::$title_type[$shipped_vehicle['title_type']];

                } else {

                    $title_type = 'EMPTY';

                }

                



                if($shipped_vehicle['export_date'] < date("Y-m-d") && $shipped_vehicle['eta'] > date("Y-m-d") && $id == 4){

                        $status = 'SHIPPED';

                } else if($shipped_vehicle['eta'] < date("Y-m-d")  && $id == 6){

                        $status = 'ARRIVED';

                } else {

                    $status = isset(\common\models\Lookup::$status_picked[$shipped_vehicle['status']]) ? \common\models\Lookup::$status_picked[$shipped_vehicle['status']] : 'EMPTY';

                }

                $date_rec = $shipped_vehicle['status'] == 3 ? $shipped_vehicle['towing_request_date'] : $shipped_vehicle['deliver_date'];

                $model_vehicle .=

                    '

      <tr>

         <td align=center>' . $shipped_vehicle['hat_number'] . '</td>

         <td align=center>' . $date_rec . '</td>

         <td align=center>' . $shipped_vehicle['year'] . '</td>

         <td align=center>' . $shipped_vehicle['make'] . '</td>

         <td align=center>' . $shipped_vehicle['model'] . '</td>

         <td align=center>' . $shipped_vehicle['color'] . '</td>

         <td align=center>' . $shipped_vehicle['vin'] . '</td>

         <td align=center>' . $title . '</td>

         <td align=center>' . $title_type . '</td>

         <td align=center>' . $keys . '</td>

         <td align=center>' . $days . '</td>

         <td align=center>' . $shipped_vehicle['lot_number'] . '</td>

         <td align=center>' . $status . '</td>

         <td align=center>' . $shipped_vehicle['note'] . '</td>

      </tr>

      ';

            }

      //       if(!empty($shipped_values)){

      //          foreach ($shipped_values as $shipped_vehicle) {



      //           if ($shipped_vehicle['title_type'] == '1') {

      //               $title = 'YES';

      //           } else {

      //               $title = 'NO';

      //           }

      //           if ($shipped_vehicle['keys'] == '1') {

      //               $keys = 'YES';

      //           } else {

      //               $keys = 'NO';

      //           }

      //           if ($shipped_vehicle['deliver_date']) {

      //               $current_date = date('Y-m-d');

      //               $datediff = strtotime($current_date) - strtotime($shipped_vehicle['deliver_date']);

      //               //  $datediff = $current_date - $shipped_vehicle['deliver_date'];

      //               $days = floor($datediff / (60 * 60 * 24));

      //           } else {

      //               $days = '0';

      //           }

      //           if (isset($shipped_vehicle['title_type'])) {

      //               $title_type = \common\models\Lookup::$title_type[$shipped_vehicle['title_type']];

      //           } else {

      //               $title_type = 'EMPTY';

      //           }

      //           $status = isset(\common\models\Lookup::$status_picked[$shipped_vehicle['status']]) ? \common\models\Lookup::$status_picked[$shipped_vehicle['status']] : 'EMPTY';

      //           $date_rec = $shipped_vehicle['status'] == 3 ? $shipped_vehicle['towing_request_date'] : $shipped_vehicle['deliver_date'];

      //           $model_vehicle .=

      //               '

      // <tr>

      //    <td align=center>' . $shipped_vehicle['hat_number'] . '</td>

      //    <td align=center>' . $date_rec . '</td>

      //    <td align=center>' . $shipped_vehicle['year'] . '</td>

      //    <td align=center>' . $shipped_vehicle['make'] . '</td>

      //    <td align=center>' . $shipped_vehicle['model'] . '</td>

      //    <td align=center>' . $shipped_vehicle['color'] . '</td>

      //    <td align=center>' . $shipped_vehicle['vin'] . '</td>

      //    <td align=center>' . $title . '</td>

      //    <td align=center>' . $title_type . '</td>

      //    <td align=center>' . $keys . '</td>

      //    <td align=center>' . $days . '</td>

      //    <td align=center>' . $shipped_vehicle['lot_number'] . '</td>

      //    <td align=center>' . $status . '</td>

      //    <td align=center>' . $shipped_vehicle['note'] . '</td>

      // </tr>

      // ';

      //       }

      //       }

            $model_vehicle .= '

   </tbody>

</table>

';



            return $model_vehicle;

        } else {

            $model_vehicle .= 'nop';



            return $model_vehicle;

        }

    }



    public function actionAjax() {

        $id = Yii::$app->request->post('id');

        $location = Yii::$app->request->post('location');

        $include = Yii::$app->request->post('include');

        $user = Yii::$app->request->post('user');

        $status = Yii::$app->request->post('status');

        $title = Yii::$app->request->post('title_recieved');

        $onhandonly = Yii::$app->request->post('onhandonly');

        if ($location) {

            $locationName = \common\models\Location::getLocationById($location);

        } else {

            $locationName = 'ALL';

        }

        if ($include == '1') {

            if ($onhandonly) {

                $include = false;

            }

            return \common\models\Vehicle::report_inventory($id, $location, $status, $user, $include);

        } else {

            $shipped_vehicle = \common\models\Vehicle::vehicleStatusList($id, $location, $status, $user, $title);

            return \common\models\Vehicle::report($shipped_vehicle, $status, $locationName);

        }

    }



    public function actionStatuspdfcustomer($id, $user, $location, $status, $mail = null, $include = null, $title = null) {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        $user_objcect = \common\models\User::findOne(['id' => $user]);

        $customerMail = $user_objcect->email;
        if ($location) {
            $locationName = \common\models\Location::getLocationById($location);
        } else {
            $locationName = 'ALL';
        }
        /*
        return $this->renderPartial('inventory_report', [
        'data' => \common\models\Vehicle::inventoryReport($id,$location,$status,$user,$include=NULL),
        'status' => $status,
        'location' => $location,
        ]);
         */

        $value = \common\models\Vehicle::inventoryReport($id, $location, $status, $user, $include = null, $title);

        // if(empty($id) && $status == 'All'){
        //   $status = 'Shipped';
        //   $id = 4;
        //   $value1 = \common\models\Vehicle::inventoryReport($id, $location, $status, $user, $include = null, $title = null);
        //   foreach ($value1 as $val) {
        //     array_push($value, $val);
        //   }
        // }
        
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            //'mode' => Pdf::MODE_CORE,
            'content' => $this->renderPartial('inventory_report', [
                'data' => $value,
                'status' => $status,
                'location' => $location,
            ]),
            'cssInline' => 'table {border-collapse: collapse;}',
            'options' => [
                'title' => 'Privacy Policy',
                'subject' => 'Generating PDF files',
                'loadCSS' => '/assets_b/css/print.css',
            ],
            'methods' => [
                'SetHeader' => ['Generated By: ASL SHIPPING||Generated On: ' . date('r')],
                'SetFooter' => ['|Page {PAGENO}|'],
            ],
        ]);
        if ($mail) {
            $content = $pdf->content;
            $filename = $pdf->filename;
            if ($customerMail) {
                $path = $pdf->Output($content, Yii::getAlias('@backend') . '/uploads/pdf/' . $filename . '.pdf', \Mpdf\Output\Destination::FILE);
                $sendemail = Yii::$app->mailer->compose()
                    ->attach(Yii::getAlias('@backend') . '/uploads/pdf/' . $filename . '.pdf')
                    ->setFrom([\Yii::$app->params['supportEmail']])
                    ->setTo($customerMail)
                    ->setSubject('CURRENT INVENTORY (' . $locationName . ')')
                    ->setHtmlBody('Dear valued customer please see the attached your current inventory. <br<br<br>Thanks,<br> ASL Shipping</b>')
                    ->send();
                unlink(Yii::getAlias('@backend') . '/uploads/pdf/' . $filename . '.pdf');
            } else {
                $sendemail = false;
            }

            if ($sendemail == true) {
                return $this->redirect(array('//customer/view',
                    'id' => $user,
                    'mailed' => $sendemail,
                ));
            } else {
                return 'email failed to ' . $sendemail;
            }
        } else {
            return $pdf->render();
        }
    }



    public function actionStatuspdfcustomerOld($id, $user, $location, $status = null, $mail = null, $include = null) {

        ini_set('memory_limit', '-1');

        if ($location) {

            $locationName = \common\models\Location::getLocationById($location);

        } else {

            $locationName = 'ALL';

        }

        $model = \common\models\Vehicle::vehicleStatusList($id, $location, $status, $user);

        $company_name = \common\models\Customer::findOne(['user_id' => $user]);



        $user_objcect = \common\models\User::findOne(['id' => $user]);



        $customerMail = $user_objcect->email;



        $pdf = new Pdf([

            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts

            'content' => $this->renderPartial('status_report', [

                'model' => $model,

                'company_name' => $company_name,

                'status' => $status,

                'location' => $location,

            ]),

            'options' => [

                'title' => 'Privacy Policy',

                'subject' => 'Generating PDF files',

            ],

            'methods' => [

                'SetHeader' => ['Generated By: ASL SHIPPING||Generated On: ' . date('r')],

                'SetFooter' => ['|Page {PAGENO}|'],

            ],

        ]);

        if ($mail) {

            $content = $pdf->content;

            $filename = $pdf->filename;

            if ($customerMail) {

                $path = $pdf->Output($content, Yii::getAlias('@backend') . '/uploads/pdf/' . $filename . '.pdf', \Mpdf\Output\Destination::FILE);

                $sendemail = Yii::$app->mailer->compose()

                    ->attach(Yii::getAlias('@backend') . '/uploads/pdf/' . $filename . '.pdf')

                    ->setFrom([\Yii::$app->params['supportEmail']])

                    ->setTo($customerMail)

                    ->setSubject('CURRENT INVENTORY (' . $locationName . ')')

                    ->setHtmlBody('Dear valued customer please see the attached your current inventory. <br<br<br>Thanks,<br> ASL Shipping</b>')

                    ->send();

                unlink(Yii::getAlias('@backend') . '/uploads/pdf/' . $filename . '.pdf');

            } else {

                $sendemail = false;

            }



            if ($sendemail == true) {

                return $this->redirect(array('//customer/view',

                    'id' => $user,

                    'mailed' => $sendemail,

                ));

            } else {

                return 'email failed to ' . $sendemail;

            }

        } else {

            return $pdf->render();

        }

    }



    public function actionStatusexel($id, $location, $status, $user = null, $title_recieved = null) {

        $models = \common\models\Vehicle::vehicleStatusList($id, $location, $status, $user, $title_recieved);

        $exelarray = array();

        $arr = [];

        foreach ($models as $model) {

            if (in_array($model['vin'],$arr)) {

                continue;

            }

            $arr[] = $model['vin'];

            //$vehicle_export = \common\models\VehicleExport::findOne(['vehicle_id'=>$model['id']]);

            if ($model['title_type'] == '1') {

                $title = 'YES';

            } else {

                $title = 'NO';

            }

            if ($model['keys'] == '1') {

                $keys = 'YES';

            } else {

                $keys = 'NO';

            }



            if (isset($model['title_type'])) {

                $title_type = \common\models\Lookup::$title_type[$model['title_type']];

            } else {

                $title_type = 'EMPTY';

            }

            $data = new \common\models\helpers\Excel();

            $data->location = \common\models\Location::getLocationById($model['location']);

            $data->hat_number = $model['hat_number'];

            $data->date_recived = $model['deliver_date'];

            $data->year = $model['year'];

            $data->make = $model['make'];

            $data->model = $model['model'];

            $data->color = $model['color'];

            $data->vin = $model['vin'];





            if($model['export_date'] < date("Y-m-d") && $model['eta'] > date("Y-m-d") && $id == 4){

                        $data->status = 'SHIPPED';

                } else if($model['eta'] < date("Y-m-d")  && $id == 6){

                        $data->status = 'ARRIVED';

                } else {

                   $data->status = isset(\common\models\Lookup::$status_picked[$model['status']]) ? \common\models\Lookup::$status_picked[$model['status']] : 'EMPTY';

                }



            $data->title = $title;

            $data->title_type = $title_type;

            $data->keys = $keys;

            $data->age = $model['agedays'];

            $data->notes = $model['note'];

            $data->customer_name = $model['customer_name'];

            $data->customer_id = $model['legacy_customer_id'];

            if($model['status'] == 2 || $model['status'] == 4 || $model['status'] == 6){

                        $data->container_number = $model['container_number'];

                        $data->booking_number = $model['booking_number'];

                        $data->ar_number = $model['ar_number'];

                        $data->export_date = $model['export_date'];

                        $data->eta = $model['eta'];

                      } else {

                         $data->container_number = '';

                        $data->booking_number = '';

                        $data->ar_number = '';

                        $data->export_date = '';

                        $data->eta = "";

                      }

            $exelarray[] = $data;

        }

        $timestamp = date('Y-m-d h:i:s');



        if (empty($location)) {

            $location = 'ALL';

            if (Yii::$app->request->get('include') == 1) {

                $fileName = 'Inventory Report -' . date('F jS, Y', strtotime($timestamp));

            } else {

                $fileName = $location . '-' . $status . '-' . date('F jS, Y', strtotime($timestamp));

            }

        } else {

            if (Yii::$app->request->get('include') == 1) {

                $status = 'Inventory Report';

            }

            $location = \common\models\Location::getLocationById($location);

            $fileName = $location . '-' . $status . '-' . date('F jS, Y', strtotime($timestamp));

        }



        require_once Yii::getAlias('@vendor/phpoffice/phpexcel/Classes/PHPExcel.php');

        \moonland\phpexcel\Excel::widget([

            'models' => $exelarray,

            'fileName' => $fileName,

            'mode' => 'export', //default value as 'export'

            //'columns' => ['status'], //without header working, because the header will be get label from attribute label.

            'headers' => ['status' => 'Header Column 1'],

        ]);

    }

    public function actionContainerReport() {

        $location = Yii::$app->request->post('location');

        $pdf = Yii::$app->request->get('pdf');

        $excel = Yii::$app->request->get('excel');

        $d = \common\models\Vehicle::containerReport($location);

        $data = $d->all();

        $html = "<table class='ia table table-striped table-bordered'>";

        $excelData = [];

        $html .= "<th>CustomerID</th><th>CUSTOMER Name</th><th>COMPANY Name</th><th>BOOKING NO</th><th>AR</th><th>CONTAINER NO</th><th>ETA</th>";

        foreach ($data as $container) {

            $excelTemp = new \common\models\helpers\ContainerExcel();

            $excelTemp->customer_id = $container['legacy_customer_id'];

            $excelTemp->customer_name = $container['customer_name'];

            $excelTemp->company_name = $container['company_name'];

            $excelTemp->booking_number = $container['booking_number'];

            $excelTemp->ar_number = $container['ar_number'];

            $excelTemp->container_number = $container['container_number'];

            $excelTemp->eta = $container['eta'];

            $excelData[] = $excelTemp;

            $html .= "<tr>";

            $html .= "<td>" . $container['legacy_customer_id'] . "</td>";

            $html .= "<td>" . $container['company_name'] . "</td>";

            $html .= "<td>" . $container['customer_name'] . "</td>";

            $html .= "<td>" . $container['booking_number'] . "</td>";

            $html .= "<td>" . $container['ar_number'] . "</td>";

            $html .= "<td>" . $container['container_number'] . "</td>";

            $html .= "<td style='width:100px;'>" . $container['eta'] . "</td>";

            $html .= "</tr>";

        }

        $html .= "</table>";

        if ($pdf) {

            $timestamp = date('Y-m-d h:i:s');

            $pdf = new Pdf([

                //'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts

                'mode' => Pdf::MODE_UTF8,

                'filename' => 'Container Report - ' . date('F jS, Y', strtotime($timestamp)),

                'content' => $html,

                'cssInline' => 'table {border-collapse: collapse;}',

                'options' => [

                    'title' => 'Privacy Policy',

                    'subject' => 'Generating PDF files',

                    'loadCSS' => '/assets_b/css/print.css',

                ],

                'methods' => [

                    'SetHeader' => ['Generated By: ASL SHIPPING||Generated On: ' . date('r')],

                    'SetFooter' => ['|Page {PAGENO}|'],

                ],

            ]);

            return $pdf->Output($pdf->content, $pdf->filename . '.pdf', \Mpdf\Output\Destination::INLINE);

        }

        if ($excel) {

            $timestamp = date('Y-m-d h:i:s');

            $fileName = 'Container Report - ' . date('F jS, Y', strtotime($timestamp));

            require_once Yii::getAlias('@vendor/phpoffice/phpexcel/Classes/PHPExcel.php');

            \moonland\phpexcel\Excel::widget([

                'models' => $excelData,

                'fileName' => $fileName,

                'mode' => 'export', //default value as 'export'

                //'columns' => ['status'], //without header working, because the header will be get label from attribute label.

                'headers' => ['status' => 'Header Column 1'],

            ]);

        }

        return $html;

    }

    public function actionInventoryReport($id, $location, $status, $include = null, $onhandonly = null) {

        ini_set('max_execution_time', 0);

        ini_set('memory_limit', '-1');

        $l = 'All';

        if (!Yii::$app->user->can('super_admin')) {

            if (Yii::$app->user->can('admin_LA')) {

                $location = 1;

                $l = 'LA';

            }

            if (Yii::$app->user->can('admin_GA')) {

                $location = 2;

                $l = 'GA';

            }

            if (Yii::$app->user->can('admin_NY')) {

                $location = 3;

                $l = 'NY';

            }

            if (Yii::$app->user->can('admin_TX')) {

                $location = 4;

                $l = 'TX';

            }

            if (Yii::$app->user->can('admin_BALTO')) {

                $location = 5;

                $l = 'NJ';

            }

            if (Yii::$app->user->can('admin_NJ2')) {

                $location = 6;

                $l = 'NJ2';

            }

            if (Yii::$app->user->can('admin_TEXAS')) {

                $location = 7;

                $l = 'TEXAS';

            }

               if (Yii::$app->user->can('admin_NEWJ')) {

                $location = 8;

                $l = 'NEWJ';

            }

        }

        if ($onhandonly) {

            $include = false;

        }

        $user = '';

        $status = Yii::$app->request->post('status');

        $title = Yii::$app->request->post('title_recieved');



        $data = \common\models\Vehicle::inventoryReport($id, $location, $status, null, $include, $title);

//        echo '<pre>';

//        print_r($data); die;

        $timestamp = date('Y-m-d h:i:s');



        $pdf = new Pdf([

            //'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts

            'mode' => Pdf::MODE_UTF8,

            'filename' => $l . ' - Inventory Report - ' . date('F jS, Y', strtotime($timestamp)),

            'content' => $this->renderPartial('inventory_report', [

                'data' => $data,

                'status' => $status,

                'location' => $location,

            ]),

            'cssInline' => 'table {border-collapse: collapse;}',

            'options' => [

                'title' => 'Privacy Policy',

                'subject' => 'Generating PDF files',

                'loadCSS' => '/assets_b/css/print.css',

            ],

            'methods' => [

                'SetHeader' => ['Generated By: ASL SHIPPING||Generated On: ' . date('r')],

                'SetFooter' => ['|Page {PAGENO}|'],

            ],

        ]);



        return $pdf->Output($pdf->content, $pdf->filename . '.pdf', \Mpdf\Output\Destination::INLINE);

        //$this->redirect('/uploads/pdf/'.Yii::getAlias('@backend').'/uploads/pdf/'.$pdf->filename.'.pdf');

        //exit();

        //$pdf->render();

    }

    public function actionInfo() {

        phpinfo();

        exit();

    }

    public function actionStatuspdf($id, $location, $status = null, $include = null, $title_recieved = null) {

        ini_set('memory_limit', '-1');

        ini_set('max_execution_time', 0);

        $timestamp = date('Y-m-d h:i:s');

        //ini_set('pcre.backtrack_limit', PHP_INT_MAX);

        $l = \common\models\Location::getLocationById($location);

        $title = $title_recieved;

        $user = '';

        $model = \common\models\Vehicle::vehicleStatusList($id, $location, $status, $user, $title);





         // $shipped_vehicle = \common\models\Vehicle::vehicleStatusList($id, $location, $status, $user, $title);

         //    return \common\models\Vehicle::report($shipped_vehicle, $status, $locationName);



        $pdf = new Pdf([

            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts

            'filename' => $l . ' - ' . $status . ' - ' . date('F jS, Y', strtotime($timestamp)),

            'content' => $this->renderPartial('status_report', [

                'model' => $model,

                'status' => $status,

                'location' => $location,

            ]),

            'options' => [

                'title' => 'Inventory',

                'subject' => 'Generating PDF files',

            ],

            'methods' => [

                'SetHeader' => ['Generated By: ASL SHIPPING||Generated On: ' . date('r')],

                'SetFooter' => ['|Page {PAGENO}|'],

            ],

        ]);



        return $pdf->render();

    }



    /**

     * Logout action.

     *

     * @return string

     */

    public function actionLogout() {

        Yii::$app->user->logout();



        return $this->goHome();

    }

    public function actionP() {

        phpinfo();

        exit();

    }



    public function actionForgotPassword(){



		//$this->layout = "login"; // set login layout

		if (!\Yii::$app->user->isGuest) {

			return $this->goHome();

		}



		$model = new PasswordResetRequestForm();



		// AJAX Validation

		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))

		{

			Yii::$app->response->format = Response::FORMAT_JSON;

			return ActiveForm::validate($model);

			Yii::$app->end();

		}



		if ($model->load(Yii::$app->request->post()) && $model->validate())

		{

			if ($model->sendEmail()) {

				Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

			} else {

				Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');

			}

			return $this->goHome();

		}

		else

		{

			return $this->render('forgot_password', [

				'model' => $model,

			]);

		}

    }

    

    /**

	 * Resets password.

	 *

	 * @param string $token

	 * @return mixed

	 * @throws BadRequestHttpException

	 */

	public function actionResetPassword($token)

	{

		try {

            $user = User::findByPasswordResetToken($token);

            if($user){

                $model = new ResetPasswordForm($token);

            }else{

                Yii::$app->session->setFlash('error', 'Wrong password reset token');



                return $this->goHome();    

            }

			

		} catch (InvalidParamException $e) {

			throw new BadRequestHttpException($e->getMessage());

		}

		

		if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {

			Yii::$app->session->setFlash('success', 'New password was saved.');



			return $this->goHome();

		}

        

		return $this->render('resetPassword', [

			'model' => $model,

		]);

	}

}

