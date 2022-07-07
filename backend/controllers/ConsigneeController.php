<?php

namespace backend\controllers;

use Yii;

$session = Yii::$app->session;
$session->open();

if(!isset($_SESSION)) { 
     echo Yii::$app->urlManager->baseUrl;
     }
use common\models\Consignee;
use common\models\ConsigneeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ConsigneeController implements the CRUD actions for Consignee model.
 */
class ConsigneeController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Consignee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConsigneeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Consignee model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Consignee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Consignee();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        if(Yii::$app->request->isAjax){
        return $this->renderAjax('create', [
            'model' => $model,
        ]);
        }else{
            return $this->render('create', [
                'model' => $model,
            ]);

        }
    }

    /**
     * Updates an existing Consignee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                ]);
    
            }
    }

    /**
     * Deletes an existing Consignee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public  function actionGetuserconsignee($id){
       
        $data= \common\models\Consignee::find()->where(['=','customer_user_id',$id])->all();
        if ($data) {
            echo "<option ></option>";
    
            for ($i = 0; $i < count($data); $i++) {
                echo "<option value='" . $data[$i]['id'] . "'>" . $data[$i]['consignee_name']. "</option>";
            }
       }
  
     
  }
       public function actionCustomerConsignee() {
           $q = Yii::$app->request->get('q');
         //  $id = Yii::$app->request->get('id');
           $type = Yii::$app->request->get('type');
          
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
              $query = new \yii\db\Query();
                $query->select('id as id, consignee_name AS text')
                        ->from('consignee')
                        ->andFilterWhere(['like', 'consignee_name', $q]);
                        //->andWhere(['customer_user_id'=>null]);
                      //  ->andWhere(['like','customer_user_id',$customer_id])
                      if($type){
                        $query->andWhere(['=', 'customer_user_id', $type]);
                      }
                $query->andWhere(['!=','consignee_is_deleted',1]);
//                $query->andWhere('customer_user_id is null and consignee_is_deleted !=1');
                      
                $query->limit(20);
                
                $command = $query->createCommand();
                $data = $command->queryAll();
                // if($data){
                $out['results'] = array_values($data);
        return $out;
    }
    /**
     * Finds the Consignee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Consignee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Consignee::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
