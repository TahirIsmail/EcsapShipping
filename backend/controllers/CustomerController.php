<?php

namespace backend\controllers;

use yii\helpers\Html;
use Yii;
$session = Yii::$app->session;
$session->open();

if(!isset($_SESSION)) { 
     echo Yii::$app->urlManager->baseUrl;
     }
use common\models\Customer;
use common\models\CustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\web\UploadedFile;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Customer models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $user_id = Yii::$app->user->getId();
        $Role = Yii::$app->authManager->getRolesByUser($user_id);
        if (!isset($Role['super_admin'])) {
            $dataProvider->query->join('LEFT JOIN', 'auth_assignment', 'auth_assignment.user_id = cu.user_id')
        ->andFilterWhere(['auth_assignment.item_name' => 'customer']);
        }

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionInsert()
    {
        $model = \common\models\Customer::find()->asArray()->all();
        foreach ($model as $m) {
            Yii::$app->db->createCommand()->batchInsert('auth_assignment', ['item_name', 'user_id', 'created_at'], [
    ['customer', $m['user_id'], '1516197344'],
])->execute();
        }
    }

    /**
     * Displays a single Customer model.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        if (\common\models\Lookup::isAdmin() || $id == Yii::$app->user->getId()) {
            $all_vehicle = \common\models\Vehicle::all_vehicle_report_customer($id);
            $vehicle_location_LA = \common\models\Vehicle::all_vehicle_location_report_customer($location = '1', $id);
            $vehicle_location_GA = \common\models\Vehicle::all_vehicle_location_report_customer($location = '2', $id);
            $vehicle_location_NY = \common\models\Vehicle::all_vehicle_location_report_customer($location = '3', $id);
            $vehicle_location_TX = \common\models\Vehicle::all_vehicle_location_report_customer($location = '4', $id);
            $vehicle_location_TX2 = \common\models\Vehicle::all_vehicle_location_report_customer($location = '5', $id);
            $vehicle_location_NJ2 = \common\models\Vehicle::all_vehicle_location_report_customer($location = '6', $id);
            $vehicle_location_CA = \common\models\Vehicle::all_vehicle_location_report_customer($location = '7', $id);

            return $this->render('view', [
                        'model' => $this->findModel($id),
                        'all_vehicle' => $all_vehicle,
                        'vehicle_location_LA' => $vehicle_location_LA,
                        'vehicle_location_GA' => $vehicle_location_GA,
                        'vehicle_location_NY' => $vehicle_location_NY,
                        'vehicle_location_TX' => $vehicle_location_TX,
                        'vehicle_location_TX2' => $vehicle_location_TX2,
                        'vehicle_location_NJ2' => $vehicle_location_NJ2,
                        'vehicle_location_CA' => $vehicle_location_CA,
            ]);
        }
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $all_images = '';
        $all_images_preview = '';
        $model = new Customer();
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $user_create = \common\models\User::customeruser($model);
                $model->user_id = $user_create->id;
                $auth = \Yii::$app->authManager;
                $role = $auth->getRole('customer');
                $auth->assign($role, $model->user_id);

                if (!$model->save()) {
                    throw new \Exception(implode('<br />', \yii\helpers\ArrayHelper::getColumn($model->errors, 0, false)));
                }

                $photo = UploadedFile::getInstances($model, 'uploads');
                if ($photo !== null) {
                    $save_images = \common\models\CustomerDocuments::save_document($model->user_id, $photo);
                }
                $consigneeCreate = \common\models\Consignee::createConsignee($model);

                $transaction->commit();

                return $this->redirect(['view', 'id' => $model->user_id]);
            } catch (\Exception $ex) {
                Yii::$app->session->setFlash('error', $ex->getMessage());
                $transaction->rollBack();
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                        'model' => $model,
                        'all_images' => $all_images,
                        'all_images_preview' => $all_images_preview,
                    ]);
        }

        return $this->render('create', [
                    'model' => $model,
                    'all_images' => $all_images,
                    'all_images_preview' => $all_images_preview,
                ]);
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $not_duplicate_email = true;
        $user_detail = \common\models\User::find()->where(['id' => $id])->one();
        $customer_submitted = Yii::$app->request->post('Customer');
        if (isset($customer_submitted['email'])) {
            if ($user_detail->email != $customer_submitted['email']) {
                //check duplicate and return;
                if (\common\models\User::findOne(['email' => $customer_submitted['email']])) {
                    $not_duplicate_email = false;
                }
            }
        }
        $images_old = \common\models\CustomerDocuments::find()->where(['=', 'customer_user_id', $id])->all();
        $all_images_preview = [];
        if ($images_old) {
            foreach ($images_old as $image) {
                $baseurl = \Yii::$app->request->BaseUrl;
                $image_url = $baseurl.'/uploads/'.$image->file;
                $all_images[] = Html::img("$image_url", ['class' => 'file-preview-image']);
                $obj = (object) array('caption' => '', 'url' => $baseurl.'/customer/delete-image', 'key' => $image->id);
                $all_images_preview[] = $obj;
            }
        } else {
            $all_images = '';
        }

        $model->username = $user_detail->username;
        $model->email = $user_detail->email;
        if ($user_detail->status == '10') {
            $model->status = true;
        }

        if ($model->load(Yii::$app->request->post()) && $not_duplicate_email) {
            $update_user = \common\models\User::update_customer($model);
            $model->save(false);
            $photo = UploadedFile::getInstances($model, 'uploads');
            if ($photo) {
                $save_images = \common\models\CustomerDocuments::save_document($model->user_id, $photo);
            }

            return $this->redirect(['view', 'id' => $model->user_id]);
        }
        if ($not_duplicate_email == false) {
            $model->addError('email', 'Duplicate Email');
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('update', [
                        'model' => $model,
                        'all_images' => $all_images,
                        'all_images_preview' => $all_images_preview,
            ]);
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'all_images' => $all_images,
                        'all_images_preview' => $all_images_preview,
            ]);
        }
    }

    public function actionDeleteImage()
    {
        $id = Yii::$app->request->post('key');
        $command = Yii::$app->db->createCommand()
                ->delete('customer_documents', 'id = '.$id)
                ->execute();

        return 1;
    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionGetcustomer($id)
    {
        $user_detail = \common\models\Customer::find()->where(['user_id' => $id])->asArray()->one();
        if ($user_detail) {
            return json_encode($user_detail);
        }
    }

    public function actionGetcontainercustomer($id)
    {
        $data = (new Query())
                ->select(['customer_user_id'])
                ->from('vehicle_export')
                ->groupBy(['customer_user_id'])
                ->where(['=', 'export_id', $id])
                ->all();
        if ($data) {
            echo '<option ></option>';

            for ($i = 0; $i < count($data); ++$i) {
                $customer_name = \common\models\Customer::find()->where(['user_id' => $data[$i]['customer_user_id']])->one();
                echo "<option value='".$data[$i]['customer_user_id']."'>".$customer_name->customer_name.'</option>';
            }
        }
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        try {
            $user = \common\models\User::findOne(['id' => Yii::$app->user->id]);
            $message = $user->username.' has deleted CUSTOMER with ID '.$model->legacy_customer_id;
            \Yii::$app->getDb()->createCommand('INSERT INTO `audit` (`user_id`, `datetime`, `logs`) VALUES ('.Yii::$app->user->id.", CURRENT_TIMESTAMP, '$message');")->query();
        } catch (\Exception $e) {
        }
        $model->delete();

        return $this->redirect(['index']);
    }

    public function actionAllcustomer($q = null, $id = null, $withadmins = false)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new \yii\db\Query();
            $query->select('user_id as id, customer_name AS text,legacy_customer_id,company_name,customer_name,phone')
                        ->from('customer')
                       ->where(['or',
                       ['like', 'company_name', $q],
                       ['like', 'customer_name', $q],
                       ['like', 'legacy_customer_id', $q],
                       ])
                       ->andWhere(['!=', 'is_deleted', 1]);
            if (!$withadmins) {
                $query->andWhere(['not in', 'legacy_customer_id', ['LAADMIN0001', 'GAOFFICE20018', 'NJOFFICE20018', 'TXOFFICE20018']]);
            }
            $query->limit(20);

            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Customer::find($id)->id];
        }

        return $out;
    }

    public function actionSelectedcustomer($type)
    {
        // $q = Yii::$app->request->get('q');
        //  $id = Yii::$app->request->get('id');
        // $customer_id = Yii::$app->request->get('type');
        if (empty($type)) {
            return [];
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
//            if (!is_null($q)) {
        $query = new \yii\db\Query();
        $query->select('user_id as id, company_name AS text')
                      ->from('customer')
                      ->where(['=', 'customer_user_id', $type])
                    //  ->andWhere(['like','customer_user_id',$customer_id])
                     ->limit(20);
        $command = $query->createCommand();
        $data = $command->queryAll();
        if ($data) {
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['user_id' => $id, 'text' => Customer::find($id)->company_name];
        }

        return $out;
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Customer the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
