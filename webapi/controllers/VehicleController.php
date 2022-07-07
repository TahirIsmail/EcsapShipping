<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\Response;
use app\models\VehicleData;
use app\components\WebApiController;
use common\models\Vehicle;
use yii\helpers\Url;


/**
 * Site controller
 */
class VehicleController extends WebApiController
{
    public $modelClass = 'app\models\VehicleData';

    public function actionIndex()
    {
        if (!$this->user['id']) {
            return $this->missingParam();
        }
        $location = Yii::$app->request->get('location');
        $status = Yii::$app->request->get('status');
        $search_str = Yii::$app->request->get('search_str');
        $title = Yii::$app->request->get('title');

        if ($title === 'all') {
            $title = ['1', '2', '3', '4', '5'];
        }

        $vehicleList = Vehicle::find()
            ->select(['vehicle.*', 'ex.eta', 've.export_id'])
            ->leftJoin('vehicle_export as ve', 've.vehicle_id = vehicle.id')
            ->leftJoin('export as ex', 'ex.id = ve.export_id')
            ->joinWith(['images']);

        if ($title) {
            if (!is_array($title)) {
                $title = [$title];
            }

            $vehicleList->joinWith('towingRequest');
            $vehicleList->where(['in', 'title_recieved', $title]);
            $status = 1;
        }

            $vehicleList->andWhere(['vehicle.customer_user_id' => $this->user['id']])
                ->andWhere(['!=', 'vehicle.vehicle_is_deleted', 1]);

        if ($location) {
            $vehicleList->andWhere(['vehicle.location' => $location]);
        }
        if ($status) {
            $vehicleList->andWhere(['vehicle.status' => $status]);
        }

        if ($search_str) {
            $vehicleList->andFilterWhere(['OR',
                ['like', 'make', $search_str],
                ['like', 'model', $search_str],
                ['like', 'lot_number', $search_str],
                ['like', 'vin', $search_str],
                ['like', 'container_number', $search_str],
            ]);
        }

        $vehicleList = $vehicleList->groupBy('vehicle.id')->orderBy(['vehicle.id' => SORT_DESC])->offset($this->offset)->limit($this->limit)->asArray()->all();

        foreach($vehicleList as $key => $vehicleItem) {
            if (isset($vehicleItem['export_id'])) {
                if (!empty($vehicleItem['eta']) && $vehicleItem['status'] == 4 && $vehicleItem['eta'] <= date('Y-m-d')) {
                    $vehicleList[$key]['status'] = 6;
                }
            }
        }

        $vehicleList = ['vehicleList' => $vehicleList];
        $vehicleList['other'] = ['vehicle_image' => str_replace(['backend/', 'backend', 'webapi/', 'webapi'], '', \yii\helpers\Url::to(['@web'], TRUE)) . 'uploads/'];
        $vehicleList['other']['page'] = $this->page;

        return $vehicleList;
    }

    public function actionView()
    {
        $id = Yii::$app->request->get('id');

        if (!$this->user['id'] || !$id) {
            return $this->missingParam();
        }
        $vehicle = Vehicle::find()
//        ->joinWith('country')
//        ->joinWith('state')
//        ->joinWith('city')
            ->joinWith('towingRequest')
            ->joinWith('customerUser')
            ->joinWith('images')
            ->joinWith(['vehicleConditions' => function (\yii\db\Query $query) {
                $query->joinWith('condition');
            }])
            ->joinWith(['vehicleExport' => function (\yii\db\Query $query) {
//                $query->joinWith(['export' => function (\yii\db\Query $query) {
//                    $query->joinWith('invoice');
//                }]);
                $query->joinWith(['export']);
            }])
//            ->joinWith('invoice')
            ->where([Vehicle::tableName() . '.customer_user_id' => $this->user['id'], Vehicle::tableName() . '.id' => $id])
            ->asArray()
            ->one();
        $vehicle = ['vehicle' => $vehicle];
        $vehicle['other'] = [
            'vehicle_image' => str_replace(['backend/', 'backend', 'webapi/', 'webapi'], '', \yii\helpers\Url::to(['@web'], TRUE)) . 'uploads/',
            'export_image' => str_replace(['backend/', 'backend', 'webapi/', 'webapi'], '', \yii\helpers\Url::to(['@web'], TRUE)) . 'uploads/'

        ];
        return $vehicle;

    }

    /**
     * get vehicles list from customer id.
     *
     * @return string
     */
    public function actionVehiclelist()
    {
        $searchModel = new VehicleData();
        $customerId = Yii::$app->request->get('customerId');
        $location_id = Yii::$app->request->get('location');

        if (trim($customerId) == '') {
            return ['name' => 'Params Required Error',
                'message' => "Customer Id is required",
                'code' => '0',
                'status' => '404',
                'data' => []];
        }
        $data = $searchModel->vehicleList($customerId, $location_id);
        if ($data) {
            return ['name' => 'Vehicle List Details',
                'message' => 'Success',
                'code' => '1',
                'status' => '200',
                'data' => ['vehicle_details' => $data]];
        } else {
            return ['name' => 'Details Not Found',
                'message' => "Vehicle Details Not Found'",
                'code' => '0',
                'status' => '404',
                'data' => []];
        }
    }


    /**
     * get vehicles details form vehicle id
     *
     * @return string
     */
    public function actionVehicleDetails()
    {
        $searchModel = new VehicleData();
        $vehicleId = Yii::$app->request->get('vehicleId');
        if (trim($vehicleId) == '') {
            return ['name' => 'Params Required Error',
                'message' => "Vehicle Id is required",
                'code' => '0',
                'status' => '404',
                'data' => []];
        }
        $data = $searchModel->vehicleDetails($vehicleId);
        if ($data) {
            return ['name' => 'Vehicle List Details',
                'message' => 'Success',
                'code' => '1',
                'status' => '200',
                'data' => ['vehicle_details' => $data]];
        } else {
            return ['name' => 'Details Not Found',
                'message' => "Vehicle Details Not Found'",
                'code' => '0',
                'status' => '404',
                'data' => []];
        }
    }


    /**
     * get vehicles shipping  details form lot number or vin number
     *
     * @return string
     */
    public function actionVehicleShippingDetails()
    {
        $searchModel = new VehicleData();
        $vin = Yii::$app->request->post('vin');
        $lot = Yii::$app->request->post('lot');
        if (trim($vin) == '' && trim($lot) == '') {
            return ['name' => 'Params Required Error',
                'message' => "VIN or LOT number is required",
                'code' => '0',
                'status' => '404',
                'data' => []];
        }

        $data = $searchModel->vehicleShippingDetails($vin, $lot);
        if ($data) {
            return ['name' => 'Vehicle Shipping Details',
                'message' => 'Success',
                'code' => '1',
                'status' => '200',
                'data' => ['vehicle_details' => $data]];
        } else {
            return ['name' => 'Details Not Found',
                'message' => "Vehicle Shipping Details Not Found'",
                'code' => '0',
                'status' => '404',
                'data' => []];
        }
    }

    public function actionGetVehicleCounter()
    {
        $all_vehicle = "";
        if ($this->user['id']) {
            $all_vehicle = \common\models\Vehicle::get_vehicle_report(null, $this->user['id']);
        } else {
            $this->missingParam();
        }
        return $all_vehicle;
    }

    public function actionDashboardReport()
    {
        $data = [];
        $user_id = $this->user['id'];
        if ($user_id) {
            $data['all'] = \common\models\Vehicle::all_vehicle_report_customer($user_id);
            $data['LA'] = \common\models\Vehicle::all_vehicle_location_report_customer($location = '1', $user_id);
            $data['GA'] = \common\models\Vehicle::all_vehicle_location_report_customer($location = '2', $user_id);
            $data['NY'] = \common\models\Vehicle::all_vehicle_location_report_customer($location = '3', $user_id);
            $data['TX'] = \common\models\Vehicle::all_vehicle_location_report_customer($location = '4', $user_id);
            $data['TX2'] = \common\models\Vehicle::all_vehicle_location_report_customer($location = '5', $user_id);
            $data['NJ2'] = \common\models\Vehicle::all_vehicle_location_report_customer($location = '6', $user_id);
            $data['CA'] = \common\models\Vehicle::all_vehicle_location_report_customer($location = '7', $user_id);
//            $all_export = \common\models\VehicleExport::all_export($user_id);
        } else {
            $this->missingParam();
        }

        return $data;
    }
}
