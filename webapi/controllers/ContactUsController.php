<?php
namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\Response;
use common\models\LoginForm;
use common\models\User;
use app\components\WebApiController;
use common\models\ContactUs;

/**
 * Site controller
 */
class ContactUsController extends WebApiController
{
    public $modelClass = 'common\models\User';
    
    public function actionIndex()
    {
        return [];
    }
    
    /**
     * @return string
     */
    public function actionCreate()
    {
        $contact_us = new ContactUs();
        $contact_us->customer_id = $this->user['id'];
        $contact_us->name = Yii::$app->request->post('name');
        $contact_us->email = Yii::$app->request->post('email');
        $contact_us->phone = Yii::$app->request->post('phone');
        $contact_us->message = Yii::$app->request->post('message');
        $contact_us->status = 1;
        $contact_us->created_at = time();
        $contact_us->updated_at = time();
       
        if($contact_us->validate() &&  $contact_us->save())
        {
            return 1;       
        }
        else
        {
            $this->message =  $contact_us->getErrors();
            $this->code = 0;
            $this->status = 0;
        }
    }
}
