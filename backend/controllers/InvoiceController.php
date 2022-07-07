<?php

namespace backend\controllers;

use Yii;
$session = Yii::$app->session;
$session->open();

if(!isset($_SESSION)) { 
     echo Yii::$app->urlManager->baseUrl;
     }
use common\models\Invoice;
use common\models\InvoicePaymentSearch;
use common\models\InvoiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
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
     * Lists all Invoice models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InvoiceSearch();

        $user_id = Yii::$app->user->getId();

        $Role = Yii::$app->authManager->getRolesByUser($user_id);
        if (isset($Role['customer'])) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->andFilterWhere(['=', 'invoice.customer_user_id', $user_id]);

            return $this->render('list', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            $dataProvider = $searchModel->searchCustomerInvoice(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionPayments()
    {
        // add conditions that should always apply here
        $searchModel = new InvoicePaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('payments', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPaid()
    {
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $user_id = Yii::$app->user->getId();
        $Role = Yii::$app->authManager->getRolesByUser($user_id);
        $dataProvider->query->where("paid_amount is not null and paid_amount!=0 and paid_amount != '' ");
        $dataProvider->query->andWhere('total_amount <= (paid_amount+adjustment_damaged+adjustment_storage+adjustment_discount+adjustment_other)');
        if (isset($_GET['InvoiceSearch']['customer_user_id'])) {
            $user_id = $_GET['InvoiceSearch']['customer_user_id'];
            $dataProvider->query->andWhere(['=', 'invoice.customer_user_id', $user_id]);
        }
        if (isset($Role['customer'])) {
            $dataProvider->query->andWhere(['=', 'invoice.customer_user_id', $user_id]);
        }

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPartialPaid()
    {
        $searchModel = new InvoiceSearch();

        $totalamount = $searchModel->total_amount;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $user_id = Yii::$app->user->getId();
        $Role = Yii::$app->authManager->getRolesByUser($user_id);
        $dataProvider->query->where("paid_amount is not null and paid_amount!=0 and paid_amount != '' ");
        // $dataProvider->query->andWhere(['!=','paid_amougnt',$totalamount]);

        $dataProvider->query->andWhere('total_amount>(paid_amount+adjustment_damaged+adjustment_storage+adjustment_discount+adjustment_other)');
        if (isset($_GET['InvoiceSearch']['customer_user_id'])) {
            $user_id = $_GET['InvoiceSearch']['customer_user_id'];
            $dataProvider->query->andWhere(['=', 'invoice.customer_user_id', $user_id]);
        }
        if (isset($Role['customer'])) {
            $dataProvider->query->andWhere(['=', 'invoice.customer_user_id', $user_id]);
        }

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUnpaid()
    {
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where("paid_amount is null or paid_amount = 0 or paid_amount = ''");
        //     $dataProvider->query->andFilterWhere(['or',
        //     ['paid_amount' => null],
        //     ['<','paid_amlount' ,'1'],
        // ]);
        if (isset($_GET['InvoiceSearch']['customer_user_id'])) {
            $user_id = $_GET['InvoiceSearch']['customer_user_id'];
            $dataProvider->query->andWhere(['=', 'invoice.customer_user_id', $user_id]);
        }
        if (isset($Role['customer'])) {
            $dataProvider->query->andWhere(['=', 'invoice.customer_user_id', $user_id]);
        }

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invoice model.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionList($id)
    {
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['=', 'invoice.customer_user_id', $id]);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCustomerinvoice($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invoice();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->payment_amount) {
                $model->paid_amount = $model->payment_amount;
            } else {
                $model->paid_amount = 0;
            }
            $invoice = UploadedFile::getInstance($model, 'upload_invoice');
            if ($invoice !== null) {
                $model->upload_invoice = $invoice->name;
                $array = explode('.', $invoice->name);
                $ext = end($array);
                $model->upload_invoice = Yii::$app->security->generateRandomString().".{$ext}";
                $path = Yii::getAlias('@app').'/../uploads/'.$model->upload_invoice;
                $invoice->saveAs($path);
            }
            if ($model->save()) {
                return $this->redirect(['/invoice']);
            }
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
            'model' => $model,
        ]);
        } else {
            return $this->render('create', [
            'model' => $model,
        ]);
        }
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $loaded = $model->load(Yii::$app->request->post());
        $remaining = $model->payment_amount;
        if ($model->paid_amount) {
            if (!$loaded) {
                $model->payment_amount = $model->total_amount - $model->paid_amount;
                $model->remaining_amount = $model->payment_amount;
            }
        } else {
            $model->payment_amount = $model->total_amount;
        }
        $old_images = $model->upload_invoice;
        if ($loaded) {
            if ($model->payment_amount) {
                $model->paid_amount = $model->payment_amount + $model->paid_amount;
            }
            $invoice = UploadedFile::getInstance($model, 'upload_invoice');
            if ($invoice) {
                if ($model->upload_invoice) {
                    unlink(Yii::getAlias('@app').'/../uploads/'.$model->upload_invoice);
                }
                $model->upload_invoice = $invoice->name;
                $array = explode('.', $invoice->name);
                $ext = end($array);
                $model->upload_invoice = Yii::$app->security->generateRandomString().".{$ext}";
                $path = Yii::getAlias('@app').'/../uploads/'.$model->upload_invoice;
                $invoice->saveAs($path);
            } else {
                $model->upload_invoice = $old_images;
            }
            if ($model->save()) {
            }

            return $this->redirect(['/invoice']);
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('update', [
            'model' => $model,
        ]);
        } else {
            return $this->render('update', [
            'model' => $model,
        ]);
        }
    }

    /**
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Invoice the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
