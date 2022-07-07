<?php

namespace app\components;

 use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\filters\auth\HttpBasicAuth;
use common\models\User;
use yii\filters\auth\QueryParamAuth;

/**
 * 
 * @author DELL
 *
 */
class WebApiController extends ActiveController
{
    public $enableCsrfValidation = false;
    public $guiest = ['search','Search','SEARCH','user','User','USER','galaxy-car','GALAXY-CAR','device'];
    
    public $user    = NULL;
    
    public $name    = 'Service';
    public $message = 'Success';
    public $code    = 1;
    public $status  = 200;
    
    /// custom function for pagination
    public $limit  = 10;
    public $page  = 0;
    public $offset  = 0;
    
    /**
     * @inheritdoc
     */
	public function behaviors()
	{
	    Yii::$app->user->enableSession = false;
// 	    return parent::behaviors();
	    $behaviors = parent::behaviors();
	    $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        
	    $auth_key = Yii::$app->request->headers->get('authKey');
	    $this->user = User::find()->where(['auth_key' => $auth_key])->asArray()->one();
	    
	    if(!$this->user && !in_array(Yii::$app->controller->id, $this->guiest))
	    {
	        $this->unauthorize();	        
	        echo json_encode($this->afterAction('', []));
	        exit();
	    }
	    
	    return $behaviors;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function verbs()
	{
	    $verbs = parent::verbs();
	    $verbs['index'] = ['GET', 'HEAD'];
	    $verbs['view']  = ['GET', 'HEAD'];
	    return $verbs;
	}
	
	
	/**
	 * Common actions accross across webapi
	 */
	public function actions()
	{
		return [];
	}

	/**
	 * Before action event
	 */
	public function beforeAction($action)
	{
	    $this->limit  = Yii::$app->request->get('page_limit') ? Yii::$app->request->get('page_limit') : $this->limit;
	    $this->limit = Yii::$app->request->post('page_limit') ? Yii::$app->request->post('page_limit') : $this->limit;
	    
	    $this->page  = Yii::$app->request->get('page') ? Yii::$app->request->get('page') : 1;
	    $this->page = Yii::$app->request->post('page') ? Yii::$app->request->post('page') : $this->page;
	    
	    $this->offset  = (($this->page - 1) * $this->limit);
		return parent::beforeAction($action);
	}
	
	/**
	 * Before action event
	 */
	public function afterAction($action, $result)
	{
	    if((!$result || empty($result)) && $this->status==1){
	        $this->message = 'data not Found';
	    }
	    return [
	        'name' => $this->name,
	        'message' => $this->message,
	        'code' => $this->code,
	        'status' => $this->status,
	        'data' => ($result) ? $result : [],
	    ];
	}
	
	/**
	 * action missing param
	 */
	protected function missingParam($param=null)
	{
	    $param = ($param && is_array($param)) ? $param  : [];
	    
	    $this->name    = $this->name;
	    $this->message = 'Missing Param '.implode(',', $param);
	    $this->code    = 0;
	    $this->status  = 0;
	}
	
	/**
	 * action missing param
	 */
	protected function unauthorize()
	{
	    $this->name    = $this->name;
	    $this->message = 'Unauthorize Please Contact Admin';
	    $this->code    = 0;
	    $this->status  = 0;
	}
	
	/**
	 * action missing param
	 */
	protected function notfound()
	{
	    $this->name    = $this->name;
	    $this->message = 'Some issue with fatching api or invalid url please try after some time';
	    $this->code    = 0;
	    $this->status  = 0;
	}
	
	/**
	 * action missing param
	 */
	protected function invalidParam()
	{
	    $this->name    = $this->name;
	    $this->message = 'Iteam Not Found, Invalid Request Param';
	    $this->code    = 0;
	    $this->status  = 0;
	}
	
	/**
	 * action Empty data
	 */
	protected function noResults()
	{
	    $this->name    = $this->name;
	    $this->message = 'No results found. ';
	    $this->code    = 0;
	    $this->status  = 0;
	}
}
