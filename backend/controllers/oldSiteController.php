<?php

namespace backend\controllers;

use common\models\LoginForm;
use kartik\mpdf\Pdf;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Site controller.
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'inventory-report'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','backup','download-backup', 'customer', 'ajax', 'statuspdf', 'statuspdfcustomer', 'ajaxcustomer', 'statusexel'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
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
        $vehicle_location_TX2 = '';
        $vehicle_location_NJ2 = '';
        $vehicle_location_CA = '';
        $all_export = '';
        $location = '';
        if (isset($Role['customer'])) {
            $all_vehicle = \common\models\Vehicle::all_vehicle_report_customer($user_id);
            $vehicle_location_LA = \common\models\Vehicle::all_vehicle_location_report_customer($location = '1', $user_id);
            $vehicle_location_GA = \common\models\Vehicle::all_vehicle_location_report_customer($location = '2', $user_id);
            $vehicle_location_NY = \common\models\Vehicle::all_vehicle_location_report_customer($location = '3', $user_id);
            $vehicle_location_TX = \common\models\Vehicle::all_vehicle_location_report_customer($location = '4', $user_id);
            $vehicle_location_TX2 = \common\models\Vehicle::all_vehicle_location_report_customer($location = '5', $user_id);
            $vehicle_location_NJ2 = \common\models\Vehicle::all_vehicle_location_report_customer($location = '6', $user_id);
            $vehicle_location_CA = \common\models\Vehicle::all_vehicle_location_report_customer($location = '7', $user_id);
            $all_export = \common\models\VehicleExport::all_export($user_id);
            $view = 'customer_index';
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
        } elseif (isset($Role['admin_TX2'])) {
            $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '5');
            $view = 'customer_admin';
        } elseif (isset($Role['admin_NJ2'])) {
            $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '6');
            $view = 'customer_admin';
        } elseif (isset($Role['admin_CA'])) {
            $all_vehicle = \common\models\Vehicle::all_vehicle_location_report($location = '7');
            $view = 'customer_admin';
        } else {
            $all_vehicle = \common\models\Vehicle::all_vehicle_report();
            $vehicle_location_LA = \common\models\Vehicle::all_vehicle_location_report($location = '1');
            $vehicle_location_GA = \common\models\Vehicle::all_vehicle_location_report($location = '2');
            $vehicle_location_NY = \common\models\Vehicle::all_vehicle_location_report($location = '3');
            $vehicle_location_TX = \common\models\Vehicle::all_vehicle_location_report($location = '4');
            $vehicle_location_TX2 = \common\models\Vehicle::all_vehicle_location_report($location = '5');
            $vehicle_location_NJ2 = \common\models\Vehicle::all_vehicle_location_report($location = '6');
            $vehicle_location_CA = \common\models\Vehicle::all_vehicle_location_report($location = '7');
            $view = 'index';
        }
        if (Yii::$app->user->can('super_admin')) {
            $view = 'index';
        }

        return $this->render($view, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'all_vehicle' => $all_vehicle,
            'all_export' => $all_export,
            'location' => $location,
            'vehicle_location_LA' => $vehicle_location_LA,
            'vehicle_location_GA' => $vehicle_location_GA,
            'vehicle_location_NY' => $vehicle_location_NY,
            'vehicle_location_TX' => $vehicle_location_TX,
            'vehicle_location_TX2' => $vehicle_location_TX2,
            'vehicle_location_NJ2' => $vehicle_location_NJ2,
            'vehicle_location_CA' => $vehicle_location_CA,
        ]);
    }

    public function actionCustomer()
    {
        // $this->layout='AdminLayout';
        return $this->render('customer_admin');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session['first_login'] = true;

            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
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
    public function actionAjaxcustomer()
    {
        $id = $_POST['id'];
        $status = $_POST['status'];

        $user = $_POST['user'];
        $location = $_POST['location'];

        if ($location) {
            $locationName = \common\models\Lookup::$location[$location];
        } else {
            $locationName = 'ALL';
        }
        $company_name = \common\models\Customer::findOne(['user_id' => $user]);
        $shipped_vehicles = \common\models\Vehicle::vehicleStatusList($id, $location, $status, $user);
        $model_vehicle = '';
        if ($shipped_vehicles) {
            $model_vehicle .= '
<table class="ia table table-striped table-bordered" width=100%>
   <tbody>
      <tr>
         <td width=20% align=center id=pipi><b>Inventory</b></td>
         <td width=30%><b>'.$company_name->company_name.'</b></td>
         <td width=12% align=right><b>Sort Type:</b></td>
         <td width=15%>'.$status.'</td>
         <td  align=center></td>
         <td width=15% align=center><b>Location<b></td>
         <td width=10%>'.$locationName.'</td>
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
                if ($shipped_vehicle['title_recieved'] == '1') {
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
                $status = isset(\common\models\Lookup::$status_picked[$shipped_vehicle['status']]) ? \common\models\Lookup::$status_picked[$shipped_vehicle['status']] : 'EMPTY';
                $date_rec = $shipped_vehicle['status'] == 3 ? $shipped_vehicle['towing_request_date'] : $shipped_vehicle['deliver_date'];
                $model_vehicle .=
                    '
      <tr>
         <td align=center>'.$shipped_vehicle['hat_number'].'</td>
         <td align=center>'.$date_rec.'</td>
         <td align=center>'.$shipped_vehicle['year'].'</td>
         <td align=center>'.$shipped_vehicle['make'].'</td>
         <td align=center>'.$shipped_vehicle['model'].'</td>
         <td align=center>'.$shipped_vehicle['color'].'</td>
         <td align=center>'.$shipped_vehicle['vin'].'</td>
         <td align=center>'.$title.'</td>
         <td align=center>'.$title_type.'</td>
         <td align=center>'.$keys.'</td>
         <td align=center>'.$days.'</td>
         <td align=center>'.$shipped_vehicle['lot_number'].'</td>
         <td align=center>'.$status.'</td>
         <td align=center>'.$shipped_vehicle['note'].'</td>
      </tr>
      ';
            }
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

    public function actionAjax()
    {
        $id = Yii::$app->request->post('id');
        $status = Yii::$app->request->post('status');
        $location = Yii::$app->request->post('location');
        $include = Yii::$app->request->post('include');
        $user = Yii::$app->request->post('user');
        if ($location) {
            $locationName = \common\models\Lookup::$location[$location];
        } else {
            $locationName = 'ALL';
        }
        if (strtolower($status) == 'on hand') {
            return \common\models\Vehicle::report_inventory($id, $location, $status, $user, $include);
        } else {
            $shipped_vehicle = \common\models\Vehicle::vehicleStatusList($id, $location, $status, $user);

            return \common\models\Vehicle::report($shipped_vehicle, $status, $locationName);
        }
    }

    public function actionStatuspdfcustomer($id, $user, $location, $status, $mail = null, $include = null)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        $user_objcect = \common\models\User::findOne(['id' => $user]);

        $customerMail = $user_objcect->email;
        if ($location) {
            $locationName = \common\models\Lookup::$location[$location];
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
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            //'mode' => Pdf::MODE_CORE,
            'content' => $this->renderPartial('inventory_report', [
                'data' => \common\models\Vehicle::inventoryReport($id, $location, $status, $user, $include = null),
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
                'SetHeader' => ['Generated By: AFG WorldWide||Generated On: '.date('r')],
                'SetFooter' => ['|Page {PAGENO}|'],
            ],
        ]);
        if ($mail) {
            $content = $pdf->content;
            $filename = $pdf->filename;
            if ($customerMail) {
                $path = $pdf->Output($content, Yii::getAlias('@backend').'/uploads/pdf/'.$filename.'.pdf', \Mpdf\Output\Destination::FILE);
                $sendemail = Yii::$app->mailer->compose()
                    ->attach(Yii::getAlias('@backend').'/uploads/pdf/'.$filename.'.pdf')
                    ->setFrom([\Yii::$app->params['supportEmail']])
                    ->setTo($customerMail)
                    ->setSubject('CURRENT INVENTORY ('.$locationName.')')
                    ->setHtmlBody('Dear valued customer please see the attached your current inventory. <br<br<br>Thanks,<br> AFG Shipping</b>')
                    ->send();
                unlink(Yii::getAlias('@backend').'/uploads/pdf/'.$filename.'.pdf');
            } else {
                $sendemail = false;
            }

            if ($sendemail == true) {
                return $this->redirect(array('//customer/view',
                'id' => $user,
                'mailed' => $sendemail,
                ));
            } else {
                return 'email failed to '.$sendemail;
            }
        } else {
            return $pdf->render();
        }
    }

    public function actionStatuspdfcustomerOld($id, $user, $location, $status, $mail = null, $include = null)
    {
        ini_set('memory_limit', '-1');
        if ($location) {
            $locationName = \common\models\Lookup::$location[$location];
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
                'SetHeader' => ['Generated By: AFG WorldWide||Generated On: '.date('r')],
                'SetFooter' => ['|Page {PAGENO}|'],
            ],
        ]);
        if ($mail) {
            $content = $pdf->content;
            $filename = $pdf->filename;
            if ($customerMail) {
                $path = $pdf->Output($content, Yii::getAlias('@backend').'/uploads/pdf/'.$filename.'.pdf', \Mpdf\Output\Destination::FILE);
                $sendemail = Yii::$app->mailer->compose()
                    ->attach(Yii::getAlias('@backend').'/uploads/pdf/'.$filename.'.pdf')
                    ->setFrom([\Yii::$app->params['supportEmail']])
                    ->setTo($customerMail)
                    ->setSubject('CURRENT INVENTORY ('.$locationName.')')
                    ->setHtmlBody('Dear valued customer please see the attached your current inventory. <br<br<br>Thanks,<br> AFG Shipping</b>')
                    ->send();
                unlink(Yii::getAlias('@backend').'/uploads/pdf/'.$filename.'.pdf');
            } else {
                $sendemail = false;
            }

            if ($sendemail == true) {
                return $this->redirect(array('//customer/view',
                'id' => $user,
                'mailed' => $sendemail,
                ));
            } else {
                return 'email failed to '.$sendemail;
            }
        } else {
            return $pdf->render();
        }
    }

    public function actionStatusexel($id, $location, $status, $user = null)
    {
        $models = \common\models\Vehicle::vehicleStatusList($id, $location, $status, $user);
        $exelarray = array();
        foreach ($models as $model) {
            if ($model['title_recieved'] == '1') {
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
            $data->hat_number = $model['hat_number'];
            $data->date_recived = $model['deliver_date'];
            $data->year = $model['year'];
            $data->make = $model['make'];
            $data->model = $model['model'];
            $data->color = $model['color'];
            $data->vin = $model['vin'];
            $data->title = $title;
            $data->title_type = $title_type;
            $data->keys = $keys;
            $data->age = $model['agedays'];
            $data->notes = $model['note'];
            $data->customer_name = $model['customer_name'];
            $data->customer_id = $model['legacy_customer_id'];
            $exelarray[] = $data;
        }
        \moonland\phpexcel\Excel::widget([
            'models' => $exelarray,
            'mode' => 'export', //default value as 'export'
            //'columns' => ['status'], //without header working, because the header will be get label from attribute label.
            'headers' => ['status' => 'Header Column 1'],
        ]);
    }

    public function actionInventoryReport($id, $location, $status, $include = null)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        if (!Yii::$app->user->can('super_admin')) {
            if (Yii::$app->user->can('admin_LA')) {
                $location = 1;
            }
            if (Yii::$app->user->can('admin_GA')) {
                $location = 2;
            }
            if (Yii::$app->user->can('admin_NY')) {
                $location = 3;
            }
            if (Yii::$app->user->can('admin_TX')) {
                $location = 4;
            }
            if (Yii::$app->user->can('admin_TX2')) {
                $location = 5;
            }
            if (Yii::$app->user->can('admin_NJ2')) {
                $location = 6;
            }
            if (Yii::$app->user->can('admin_CA')) {
                $location = 7;
            }
        }
        $pdf = new Pdf([
            //'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            'mode' => Pdf::MODE_CORE,
            'content' => $this->renderPartial('inventory_report', [
                'data' => \common\models\Vehicle::inventoryReport($id, $location, $status, $include = null),
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
                'SetHeader' => ['Generated By: AFG WorldWide||Generated On: '.date('r')],
                'SetFooter' => ['|Page {PAGENO}|'],
            ],
        ]);
        $pdf->render();
    }

    public function actionStatuspdf($id, $location, $status, $include = null)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);
        ini_set('pcre.backtrack_limit', '5000000');
        //ini_set('pcre.backtrack_limit', PHP_INT_MAX);
        
        if (strtolower($status) == 'on hand') {
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                'content' => \common\models\Vehicle::report_inventory($id, $location, $status, null, $include),
                'cssInline' => 'table {border-collapse: collapse;}',
                'options' => [
                    'title' => 'Privacy Policy',
                    'subject' => 'Generating PDF files',
                    'loadCSS' => '/assets_b/css/print.css',
                ],
                'methods' => [
                    'SetHeader' => ['Generated By: AFG WorldWide||Generated On: '.date('r')],
                    'SetFooter' => ['|Page {PAGENO}|'],
                ],
            ]);
        } else {
			$model = \common\models\Vehicle::vehicleStatusList($id, $location, $status);
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                'content' => $this->renderPartial('status_report', [
                    'model' => $model,
                    'status' => $status,
                    'location' => $location,
                ]),
                'options' => [
                    'title' => 'Privacy Policy',
                    'subject' => 'Generating PDF files',
                ],
                'methods' => [
                    'SetHeader' => ['Generated By: AFG WorldWide||Generated On: '.date('r')],
                    'SetFooter' => ['|Page {PAGENO}|'],
                ],
            ]);
        }

        return $pdf->render();
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
