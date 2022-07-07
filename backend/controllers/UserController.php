<?php

namespace backend\controllers;

use Yii;
$session = Yii::$app->session;
$session->open();

if(!isset($_SESSION)) { 
     echo Yii::$app->urlManager->baseUrl;
     }
use common\models\User;
use common\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
        public function actionSearch()
    {
 
        $elastic = new User();
        $result  = $elastic->Searches(Yii::$app->request->queryParams);
        $query = Yii::$app->request->queryParams;
        return $this->render('search', [
            'searchModel'  => $elastic,
            'dataProvider' => $result,
            'query'        => $query['search'],
        ]);
 
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        if($model->load(Yii::$app->request->post())){
            $model->auth_key = '';
            $user_form = Yii::$app->request->post('User');
            if(isset($user_form['password'])){
                $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($user_form['password']);
            }else{
                $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash('admin10123');
            }
            if($model->save()){
                $role = 'admin_LA';
                if($model->role =='1'){
                    $role = 'admin_LA';
                }
                if($model->role =='2'){
                    $role = 'admin_GA';
                }
                if($model->role =='3'){
                    $role = 'admin_NY';
                }
                if($model->role =='4'){
                    $role = 'admin_TX';
                }
                if($model->role =='5'){
                    $role = 'admin_TX2';
                }
                if($model->role =='6'){
                    $role = 'admin_NJ2';
                }
                if($model->role =='7'){
                    $role = 'admin_CA';
                }
                $r=new yii\rbac\DbManager;
                $r->getRole($role);
                $r->assign(Yii::$app->authManager->getRole($role),$model->id);
                return $this->redirect(['view', 'id' => $model->id]);
            }
           
        }
        

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $loading = $model->load(Yii::$app->request->post());
        if($loading){
            $user_form = Yii::$app->request->post('User');
            if(isset($user_form['password'])){
                $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($user_form['password']);
            }else{
                $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash('admin10123');
            }
        }
        if ($loading && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
//            \common\models\Customer::findOne(['user_id' => $id])->delete();
            $this->findModel($id)->delete();
        } catch (\Exception $e) {
            echo $e->getMessage(); die;
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
