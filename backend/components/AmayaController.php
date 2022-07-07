<?php

namespace backend\components;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\UnauthorizedHttpException;

/**
 * Amaya Common Controller for backend
 * @author Mehul Jethloja
 *
 */
class AmayaController extends Controller
{
	/**
     * @inheritdoc
     */
	public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [

                    [
                        'actions' => ['login', 'error', 'inventory-report', 'p','forgot-password','reset-password'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout','backup','download-backup', 'container-report', 'index', 'customer', 'ajax', 'statuspdf', 'statuspdfcustomer', 'ajaxcustomer', 'statusexel'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                  //  'logout' => ['post'],
                  'delete' => ['POST'],
                ],
            ],
        ];
    }

	/**
	 * Common actions accross across backend
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
	 * Before action event
	 */
	// public function beforeAction($action)
	// {
 //        if(!Yii::$app->user->isGuest){
 //            if(Yii::$app->session->get('amaya_auth_key') != Yii::$app->user->identity->auth_key){
 //                Yii::$app->user->logout();
 //                return $this->goHome();
 //            }
 //        }
	// 	return parent::beforeAction($action);
	// }

}