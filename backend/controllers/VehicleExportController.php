<?php

namespace backend\controllers;

use Yii;
$session = Yii::$app->session;
$session->open();

if(!isset($_SESSION)) { 
     echo Yii::$app->urlManager->baseUrl;
     }
use common\models\VehicleExport;
use common\models\VehicleExportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VehicleExportController implements the CRUD actions for VehicleExport model.
 */
class VehicleExportController extends Controller
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
     * Lists all VehicleExport models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VehicleExportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VehicleExport model.
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
     * Creates a new VehicleExport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VehicleExport();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
 
    /**
     * Updates an existing VehicleExport model.
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

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing VehicleExport model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionContainerImages(){
        
         $id = Yii::$app->request->post('id');
         $allImages = \common\models\ExportImages::find()->where(['export_id'=>$id])->all();
         return $this->renderAjax('gallery', [
            'allImages' => $allImages,
        ]);
     }
     public function actionVehicleImages(){
        
         $id = Yii::$app->request->post('id');
         $allImages = \common\models\Images::find()->where(['vehicle_id'=>$id])->all();
         return $this->renderAjax('gallery', [
            'allImages' => $allImages,
        ]);
     }
    /**
     * Finds the VehicleExport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VehicleExport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VehicleExport::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
