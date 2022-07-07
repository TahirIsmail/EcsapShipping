<?php

namespace backend\controllers;
use Yii;
$session = Yii::$app->session;
$session->open();

if(!isset($_SESSION)) { 
     echo Yii::$app->urlManager->baseUrl;
     }
use common\models\Export;
use common\models\ExportSearch;
use kartik\mpdf\Pdf;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use ZipArchive;

/**
 * ExportController implements the CRUD actions for Export model.
 */
class ExportController extends Controller
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
     * Lists all Export models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \Exception
     */
    public function actionDownloadImages($id)
    {
        $allimages = \common\models\ExportImages::find()->where(['=', 'export_id', $id])->all();
      
        $e = \common\models\Export::findOne(['id' => $id]);
        if (empty($allimages)) {
            return 'No-Images';
        }

        $file = $e->container_number.'.zip';
        if (file_exists('uploads/'.$file)) {
            unlink('uploads/'.$file);
        }

        $zip = new \ZipArchive();
        if ($zip->open('uploads/'.$file, ZipArchive::CREATE|ZipArchive::OVERWRITE) !== true) {
            throw new \Exception('Cannot create a zip file');
        }

        foreach ($allimages as $files) {
            $url = \yii\helpers\Url::to('@web/uploads/'.$files->name, true);
            $download_file = file_get_contents($url);
            //print_r($url); echo "<br>";
            //add it to the zip
            if($download_file){
                $zip->addFromString(basename($url), $download_file);
            }
            
        }
      
        $zip->close();
        header('Content-disposition: attachment; filename="'.$file.'"');
        //header('Content-type: application/zip');
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Type: application/force-download');
        header('Content-Transfer-Encoding: binary');
        header('Connection: close');

        readfile(\yii\helpers\Url::to('@web/uploads/'.$file, true));
        unlink($tmp_file);
        unlink($file);
    }

    /**
     * Export report in Excel
     *
     */
    public function actionExportExcel()
    {
        try {
            $searchModel = new ExportSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 50000);
            $models = $dataProvider->getModels();
            $excelArray = array();
            foreach ($models as $model) {
                $data = new \common\models\helpers\ExportExcel();
                $data->total_photos = count(\common\models\ExportImages::find()->where(['=', 'export_id', $model->id])->all());
                $data->loading_date = $model->loading_date;
                $data->export_date = $model->export_date;
                $data->eta = $model->eta;
                $vx = \common\models\VehicleExport::find()->joinWith(['vehicle'])->where(['export_id' => $model->id])->andWhere('vehicle_export_is_deleted != 1')->one();
                $status = '';
                if(!empty($vx['vehicle']['status']) && ($vx['vehicle']['status'] == 2 || $vx['vehicle']['status'] == 4)) {
                    $status = \common\models\Lookup::$status[$vx['vehicle']['status']];
                }
                $data->status = $status;
                $data->booking_number = $model['booking_number'];
                $data->container_number = $model['container_number'];
                $data->ar_number = $model['ar_number'];
                $data->created_at = date('Y-m-d', strtotime($model->created_at));
                $data->port_of_loading = $model->port_of_loading;
                $data->port_of_discharge = $model->port_of_discharge;
                $c =  \common\models\Customer::findOne(['user_id'=>$model->customer_user_id]);
                $data->customer_name = $c ? $c->company_name : '';
                $data->legacy_customer_id = $c ? $c->legacy_customer_id : '';
                $data->terminal = $model['terminal'];
                $data->vessel = $model['vessel'];
                $data->container_type = isset(\common\models\Lookup::$container_type[$model->container_type]) ? \common\models\Lookup::$container_type[$model->container_type] : '';
                $excelArray[] = $data;
            }

            \moonland\phpexcel\Excel::widget([
                'models' => $excelArray,
                'mode' => 'export',
                'headers' => ['year' => 'YEAR'],
            ]);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function actionIf()
    {
        phpinfo();
        exit();
    }

    /**
     * Displays a single Export model.
     *
     * @param int $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $vehicle_export = \common\models\VehicleExport::find()->where(['export_id' => $id])->one();
        $exit = true;
        if ($vehicle_export) {
            $vehicle = \common\models\Vehicle::findOne(['id' => $vehicle_export->vehicle_id]);
            if (Yii::$app->user->can('customer')) {
                if ($vehicle->customer_user_id == Yii::$app->user->id) {
                    $exit = false;
                }
            }
            if (!Yii::$app->user->can('super_admin') && !Yii::$app->user->can('sub_admin')) {
                if ($vehicle->location == '1' && (!Yii::$app->user->can('admin_LA') && $exit)) {
                    exit();
                }
                if ($vehicle->location == '2' && (!Yii::$app->user->can('admin_GA') && $exit)) {
                    exit();
                }
                if ($vehicle->location == '3' && (!Yii::$app->user->can('admin_NY') && $exit)) {
                    exit();
                }
                if ($vehicle->location == '4' && (!Yii::$app->user->can('admin_TX') && $exit)) {
                    exit();
                }
                if ($vehicle->location == '5' && (!Yii::$app->user->can('admin_TX2') && $exit)) {
                    exit();
                }
                if ($vehicle->location == '6' && (!Yii::$app->user->can('admin_NJ2') && $exit)) {
                    exit();
                }
                if ($vehicle->location == '7' && (!Yii::$app->user->can('admin_CA') && $exit)) {
                    exit();
                }
            }
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionTermsconditions()
    {
        //return $this->redirect(['index']);
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            'filename' => 'Terms.pdf',
            'content' => $this->renderPartial('termscond_pdf'),
            'options' => [
                'title' => 'Privacy Policy',
                'subject' => 'AFG Global Terms and Conditions',
            ],
            'methods' => [
                'SetHeader' => ['Generated By: AFG Global||Generated On: ' . date('r')],
                'SetFooter' => ['|Page {PAGENO}|'],
            ],
        ]);

        return $pdf->render();
        //return $this->renderAjax('termscond_pdf');
    }

    public function actionDockmodal($id)
    {
        return $this->renderAjax('dock_model', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionImages($id)
    {
        $images = \common\models\ExportImages::find()->where(['=', 'export_id', $id])->all();
        return $this->renderAjax('images', ['images' => $images]);
    }

    public function actionHustomcoverlettermodal($id)
    {
        return $this->renderAjax('hustom_cover_letter_modal', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCustomcoverlettermodal($id)
    {
        return $this->renderAjax('custom_cover_letter_modal', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionManifestmodal($id)
    {
        return $this->renderAjax('manifest_modal', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionNotesmodal($id)
    {
        return $this->renderAjax('notes_model', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionLadingmodal($id)
    {
        return $this->renderAjax('landing_modal', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionNonhazmodal($id)
    {
        return $this->renderAjax('nonhaz_modal', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionNotes()
    {
        $note_export = \common\models\Note::note($_POST);
        $user_id = Yii::$app->user->identity->id;
        if ($user_id != 1) {
            $created_by = \common\models\Customer::findOne(['user_id' => $user_id]);
            if ($created_by) {
                $created_by = $created_by->customer_name;
                $color = '#23c6c8';
            } else {
                $created_by = 'Admin';
                $color = '#9C27B0';
            }
        } else {
            $created_by = 'Super Admin';
            $color = '#9C27B0';
        }
        $single_note = '';
        $single_note .= '<li> <div class="rotate-1 lazur-bg" style="background-color: ' . $color . '"><p>' . $created_by . '</p><p>' . date('Y-m-d H:i:s') . '</p><p>' . $note_export->description . '</p>';
        if ($note_export->imageurl) {
            $single_note .= '<span class="image_show_note"><a target="_blank" href="' . $note_export->imageurl . '">View Attachment</a></span>';
        }
        $single_note .= '</div></li>';

        return $single_note;
    }

    public function actionUploadNotes()
    {
        $model = new Export();

        $imageFile = UploadedFile::getInstance($model, 'imageFile');

        $directory = Yii::getAlias('@backend/uploads') . DIRECTORY_SEPARATOR . Yii::$app->session->id . DIRECTORY_SEPARATOR;
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }

        if ($imageFile) {
            $uid = uniqid(time(), true);
            $fileName = $uid . '.' . $imageFile->extension;
            $filePath = $directory . $fileName;
            if ($imageFile->saveAs($filePath)) {
                $path = 'uploads/' . Yii::$app->session->id . DIRECTORY_SEPARATOR . $fileName;

                return Json::encode([
                    'files' => [
                        [
                            'name' => $fileName,
                            'size' => $imageFile->size,
                            'url' => $path,
                            'thumbnailUrl' => $path,
                            'deleteUrl' => 'export/image-delete?name=' . $fileName,
                            'deleteType' => 'POST',
                        ],
                    ],
                ]);
            }
        }

        return '';
    }

    public function actionImageDelete($name)
    {
        $directory = Yii::getAlias('@backend/uploads') . DIRECTORY_SEPARATOR . Yii::$app->session->id;
        if (is_file($directory . DIRECTORY_SEPARATOR . $name)) {
            unlink($directory . DIRECTORY_SEPARATOR . $name);
        }

        $files = FileHelper::findFiles($directory);
        $output = [];
        foreach ($files as $file) {
            $fileName = basename($file);
            $path = 'uploads/' . Yii::$app->session->id . DIRECTORY_SEPARATOR . $fileName;
            $output['files'][] = [
                'name' => $fileName,
                'size' => filesize($file),
                'url' => $path,
                'thumbnailUrl' => $path,
                'deleteUrl' => 'image-delete?name=' . $fileName,
                'deleteType' => 'POST',
            ];
        }

        return Json::encode($output);
    }

    /**
     * Creates a new Export model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function actionCreate()
    {
        ini_set('max_execution_time', 1200);
        $model = new Export();
        $dockrecipt = new \common\models\DockReceipt();
        $coverletter = new \common\models\HoustanCustomCoverLetter();
        $container_images = new \common\models\ExportImages();
        $blankcontainer_images = new \common\models\ExportImages();
        $all_images = '';
        $noerror = true;
        if ($model->load(Yii::$app->request->post()) && $dockrecipt->load(Yii::$app->request->post()) && $coverletter->load(Yii::$app->request->post()) && $container_images->load(Yii::$app->request->post()) && $blankcontainer_images->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $invoice = UploadedFile::getInstance($model, 'export_invoice');
                if ($invoice !== null) {
                    $model->export_invoice = $invoice->name;
                    $arr = explode('.', $invoice->name);
                    $ext = end($arr);
                    $model->export_invoice = Yii::$app->security->generateRandomString() . ".{$ext}";
                    $path = Yii::getAlias('@app') . '/../uploads/' . $model->export_invoice;
                    $invoice->saveAs($path);
                }

                if ($model->save()) {
                    Yii::$app->session['cart'] = [];
                    $vehicle_export = \common\models\VehicleExport::vehcile_export_data($model);
                    $dockrecipt->export_id = $model->id;
                    $dockrecipt->save();
                    $coverletter->export_id = $model->id;
                    $coverletter->save();
                    $photo = UploadedFile::getInstances($container_images, 'name');
                    if ($photo !== null) {
                        $save_container_images = \common\models\ExportImages::save_container_images($model->id, $photo);
                    }

                    // $photo1 = UploadedFile::getInstances($blankcontainer_images, 'name');
                    // if ($photo1 !== null) {
                    //     $save_blank_container_images = \common\models\ExportImages::save_blank_container_images($model->id, $photo1);
                    // }

                } else {
                    $noerror = false;
                }
                $transaction->commit();
                if (isset($model->id) && !empty($model->id) && $noerror) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
        //$all_images_preview = $all_images;
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                'model' => $model,
                'dockrecipt' => $dockrecipt,
                'coverletter' => $coverletter,
                'container_images' => $container_images,
                'all_images' => $all_images,
                'all_images_preview' => [],
                'blankcontainer_images' => $blankcontainer_images,
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'dockrecipt' => $dockrecipt,
                'coverletter' => $coverletter,
                'container_images' => $container_images,
                'all_images' => $all_images,
                'all_images_preview' => [],
                'blankcontainer_images' => $blankcontainer_images,
            ]);
        }
    }

    /**
     * Updates an existing Export model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function actionUpdate($id)
    {
        ini_set('max_execution_time', 1200);
        $model = $this->findModel($id);
        $noerror = true;
        $session_data = \common\models\Customer::find()->where(['user_id' => $model->customer_user_id])->one();

        $dockrecipt = \common\models\DockReceipt::find()->where(['=', 'export_id', $model->id])->one();
        $coverletter = \common\models\HoustanCustomCoverLetter::find()->where(['=', 'export_id', $model->id])->one();
        $container_old_images = \common\models\ExportImages::find()->where(['=', 'export_id', $model->id])->all();
        $container_images = new \common\models\ExportImages();
        $all_images_preview = [];
        $old_images = $model->export_invoice;
        if ($container_old_images) {
            foreach ($container_old_images as $image) {
                $baseurl = \Yii::$app->request->BaseUrl;
                $image_url = $baseurl . '/uploads/' . $image->thumbnail;
                $all_images[] = Html::img("$image_url", ['class' => 'file-preview-image']);
                $obj = (object)array('caption' => '', 'url' => 'delete-image', 'key' => $image->id);
                $all_images_preview[] = $obj;
            }
        } else {
            $all_images = '';
        }

        if ($model->load(Yii::$app->request->post()) && $dockrecipt->load(Yii::$app->request->post()) && $coverletter->load(Yii::$app->request->post()) && $container_images->load(Yii::$app->request->post())) {
            $invoice = UploadedFile::getInstance($model, 'export_invoice');
            if ($invoice) {
                if ($model->export_invoice) {
                    unlink(Yii::getAlias('@app') . '/../uploads/' . $model->export_invoice);
                }
                $model->export_invoice = $invoice->name;

                $arr = explode('.', $invoice->name);
                $ext = end($arr);
                $model->export_invoice = Yii::$app->security->generateRandomString() . ".{$ext}";
                $path = Yii::getAlias('@app') . '/../uploads/' . $model->export_invoice;
                $invoice->saveAs($path);
                //$model->save();
            } else {
                $model->export_invoice = $old_images;
                //$model->save();
            }

            if ($model->save()) {
            } else {
                $noerror = false;
            }
            $invoice = \common\models\Invoice::findOne(['export_id' => $model->id]);
            if (!$invoice) {
                $string_q = '';
                $all_vehicles_export_edited = Yii::$app->db->createCommand("
                select vehicle_id from vehicle_export where `export_id` = $model->id;")
                    ->queryAll();
                foreach ($all_vehicles_export_edited as $e_key => $a_v_e) {
                    if ($e_key > 0) {
                        $string_q .= ',' . $a_v_e['vehicle_id'];
                    } else {
                        $string_q .= $a_v_e['vehicle_id'];
                    }
                }
                if ($string_q) {
                    Yii::$app->db->createCommand()
                        ->update('vehicle', [
                            'is_export' => 0,
                            'status' => '1',
                            'updated_at' => date('Y-m-d h:i:s'),
                        ], 'id in (' . $string_q . ')')
                        ->execute();
                }

                $command = Yii::$app->db->createCommand()
                    ->delete('vehicle_export', 'export_id = ' . $model->id)
                    ->execute();
                $vehicle_export = \common\models\VehicleExport::vehcile_export_data($model);
            }
            $dockrecipt->save();
            $coverletter->save();
            $photo = UploadedFile::getInstances($container_images, 'name');
            if ($photo) {
                $save_container_images = \common\models\ExportImages::save_container_images($model->id, $photo);
            }
            if ($model->id && $noerror) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
            }
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('update', [
                'model' => $model,
                'dockrecipt' => $dockrecipt,
                'coverletter' => $coverletter,
                'container_images' => $container_images,
                'all_images' => $all_images,
                'session_data' => $session_data,
                'all_images_preview' => $all_images_preview,
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'dockrecipt' => $dockrecipt,
                'coverletter' => $coverletter,
                'container_images' => $container_images,
                'all_images' => $all_images,
                'session_data' => $session_data,
                'all_images_preview' => $all_images_preview,
            ]);
        }
    }

    public function actionDeleteExportInvoice()
    {
        $id = Yii::$app->request->post('key');
        $export = \common\models\Export::findOne(['id' => $id]);
        try {
            unlink(Yii::$app->request->baseUrl . '/uploads/' . $export->export_invoice);
        } catch (\Exception $e) {
        }
        $export->export_invoice = '';
        $export->save();

        return 1;
    }

    public function actionDeleteImage()
    {
        $id = Yii::$app->request->post('key');
        $command = Yii::$app->db->createCommand()
            ->delete('export_images', 'id = ' . $id)
            ->execute();

        return 1;
    }

    public function actionDockpdf($id)
    {
        $exportDetail = $this->findModel($id);
        $customerDetail = \common\models\Customer::findOne(['user_id' => $exportDetail->customer_user_id]);
        $customer_name = $customerDetail->customer_name;
        $company_name = $customerDetail->company_name;
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            'filename' => 'Dock_' . $exportDetail->booking_number . '_' . $customer_name . '_' . $company_name . '.pdf',
            'content' => $this->renderPartial('dock_pdf', [
                'model' => $this->findModel($id),
            ]),
            'options' => [
                'title' => 'Privacy Policy',
                'subject' => 'Doc Receipt AFG Global',
            ],
            'methods' => [
                'SetHeader' => ['Generated By: AFG Global||Generated On: ' . date('r')],
                'SetFooter' => ['|Page {PAGENO}|'],
            ],
        ]);

        return $pdf->render();
    }

    public function actionManifestpdf($id, $mail = null)
    {
        $exportDetail = $this->findModel($id);
        $customerDetail = \common\models\Customer::findOne(['user_id' => $exportDetail->customer_user_id]);
        $customerMail = \common\models\User::findOne(['id' => $customerDetail->user_id]);
        $customerMail = $customerMail->email;

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            'filename' => stripslashes('Manifest_' . $exportDetail->booking_number),
            'content' => $this->renderPartial('manifest_pdf', [
                'model' => $this->findModel($id),
            ]),
            'options' => [
                'title' => 'Privacy Policy',
                'subject' => 'Generating PDF via AFG Global Shipping',
            ],
            'methods' => [
                'SetHeader' => ['Generated By: AFG Global||Generated On: ' . date('r')],
                'SetFooter' => ['|Page {PAGENO}|'],
            ],
        ]);
        if ($mail) {
            $content = $pdf->content;
            $filename = $pdf->filename;
            //  $mpdf = $pdf->getApi();
            //  $mpdf->WriteHtml($content);

            if ($customerMail) {
                $path = $pdf->Output($content, Yii::getAlias('@backend') . '/uploads/pdf/' . $filename . '.pdf',
                    \Mpdf\Output\Destination::FILE);
                $sendemail = Yii::$app->mailer->compose()
                    ->attach(Yii::getAlias('@backend') . '/uploads/pdf/' . $filename . '.pdf')
                    ->setFrom([\Yii::$app->params['supportEmail'] => 'AFG Global Shipping'])
                    ->setTo($customerMail)
                    //->setSubject('MANIFEST') //commented on 22122020
                    ->setSubject('Container Manifest Report / '.$exportDetail->container_number.'')
                    ->setHtmlBody('Dear Customer, <br><br>
                                   Please find the attached Manifest report for your container. <br>
                                   Thank you for becoming a customer of AFG Global Shipping.<br>
                                   We appreciate your business.
                                   <br><br>
                                   Regards, <br>
                                   AFG Global') //22122020
                    ->send();

                unlink(Yii::getAlias('@backend') . '/uploads/pdf/' . $filename . '.pdf');
            } else {
                $sendemail = false;
            }

            if ($sendemail) {
                $mailed = true;
            } else {
                $mailed = false;
            }

            return $this->redirect(array(
                'view',
                'model' => $this->findModel($id),
                'id' => $id,
                'mailed' => $mailed,
            ));
        } else {
            return $pdf->render();
        }
    }

    public function actionTermspdf($id, $mail = null)
    {
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            'filename' => 'TEST.pdf',
            'content' => $this->renderPartial('landing', [
                'model' => $this->findModel($id),
            ]),
            'options' => [
                'title' => 'AFG Global World Wide',
                'subject' => 'Bill of Loading || AFG Global',
            ],
            'methods' => [
                'SetHeader' => ['Generated By: AFG Global||Generated On: ' . date('r')],
                'SetFooter' => ['|Page {PAGENO}|'],
            ],
        ]);
        return $pdf->render();
    }

    public function actionLandingpdf($id, $mail = null)
    {
        $exportDetail = $this->findModel($id);
        $customerDetail = \common\models\Customer::findOne(['user_id' => $exportDetail->customer_user_id]);
        $customerMail = \common\models\User::findOne(['id' => $customerDetail->user_id]);
        $customerMail = $customerMail->email;
        $customer_name = str_replace('/', '', $customerDetail->customer_name);
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            'filename' => 'H_BL_' . $customer_name . '_' . $exportDetail->booking_number . '.pdf',
            'content' => $this->renderPartial('landing', [
                'model' => $this->findModel($id),
            ]),
            'options' => [
                'title' => 'AFG Global World Wide',
                'subject' => 'Bill of Loading || AFG Global',
            ],
            'methods' => [
                'SetHeader' => ['Generated By: AFG Global||Generated On: ' . date('r')],
                'SetFooter' => ['|Page {PAGENO}|'],
            ],
        ]);
        if ($mail) {
            $content = $pdf->content;
            $filename = $pdf->filename;
            //  $mpdf = $pdf->getApi();
            //  $mpdf->WriteHtml($content);

            if ($customerMail) {
                $path = $pdf->Output($content, Yii::getAlias('@backend') . '/uploads/pdf/' . $filename,
                    \Mpdf\Output\Destination::FILE);
                $sendemail = Yii::$app->mailer->compose()
                    ->attach(Yii::getAlias('@backend') . '/uploads/pdf/' . $filename)
                    ->setFrom([\Yii::$app->params['supportEmail'] => 'AFG Global Shipping'])
                    ->setTo($customerMail)
                    //->setSubject('B/L') //commented on 22122020
                    ->setSubject('Container Bill of Lading / '.$exportDetail->container_number.'')
                    ->setHtmlBody('Dear Customer, <br><br>
                                   Please find the attached Bill of Lading for your container. <br>
                                   Thank you for becoming a customer of AFG Global Shipping.<br>
                                   We appreciate your business.
                                   <br><br>
                                   Regards, <br>
                                   AFG Global') //22122020
                    ->send();

                unlink(Yii::getAlias('@backend') . '/uploads/pdf/' . $filename);
            } else {
                $sendemail = '';
            }

            if ($sendemail) {
                $mailed = true;
            } else {
                $mailed = false;
            }

            return $this->redirect(array(
                'view',
                'model' => $this->findModel($id),
                'id' => $id,
                'mailed' => $mailed,
            ));
        } else {
            return $pdf->render();
        }
    }

    public function actionCloseConversatition()
    {
        $id = Yii::$app->request->post('id');
        $open = Yii::$app->request->post('open');

        $update_exported_vehicle = Yii::$app->db->createCommand()
            ->update('export', [
                'notes_status' => $open,
            ], 'id ="' . $id . '"')
            ->execute();
        if ($open == '2') {
            return 1;
        }

        return $open;
    }

    /**
     * Deletes an existing Export model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        try {
            $user = \common\models\User::findOne(['id' => Yii::$app->user->id]);
            $message = $user->username . ' has deleted CONTAINER with AR NUMBER ' . $model->ar_number;
            \Yii::$app->getDb()->createCommand('INSERT INTO `audit` (`user_id`, `datetime`, `logs`) VALUES (' . Yii::$app->user->id . ", CURRENT_TIMESTAMP, '$message');")->query();
        } catch (\Exception $e) {
        }
        $model->delete();

        $export_vehicle = \common\models\VehicleExport::find()->where(['export_id' => $id])->all();
        $invoice = \common\models\Invoice::find()->where(['export_id' => $id])->all();
        foreach ($invoice as $in) {
            $in->softDelete();
        }
        foreach ($export_vehicle as $ev) {
            $vehicle = \common\models\Vehicle::findOne($ev->vehicle_id);
            $vehicle->is_export = 0;
            $vehicle->status = 1;
            $vehicle->container_number = '';
            $vehicle->save();
            $ev->softDelete();
        }

        return $this->redirect(['index']);
    }

    public function actionAllexport($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new \yii\db\Query();
            $query->select('id as id, ar_number AS text')
                ->from('export')
                ->orFilterWhere(['like', 'container_number', $q])
                ->orFilterWhere(['like', 'ar_number', $q])
                // ->orWhere(['like', 'container_number', $q])
                ->limit(20);

            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Export::find($id)->ar_number];
        }

        return $out;
    }

    /**
     * Finds the Export model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Export the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Export::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUploadinvoice($id)
    {
        $model = new \common\models\ExportInvoice();
        if (Yii::$app->request->isAjax) {
            $model->isNewRecord = true;
            $model->id = null;

            $photo = UploadedFile::getInstance($model, 'file');

            $invoice_name = $_FILES['file']['name'];
            $ext = explode('.', $invoice_name);
            $file_extension = end($ext);
            $model->name = Yii::$app->security->generateRandomString() . ".{$file_extension}";
            $model->name = $id . $model->name;
            $path = Yii::getAlias('@app') . '/../uploads/' . $model->name;
            $photo->saveAs($path);
            $model->export_id = $id;

            $model->save();
        }
    }
}
