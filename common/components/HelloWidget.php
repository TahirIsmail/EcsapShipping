<?php
namespace common\components;

use yii\base\Widget;
use yii\helpers\Html;
use yii\base\Event;
use Yii;

class HelloWidget extends Widget
{
    public $message;

    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = 'Hello World';
        }
    }

    public function run()
    {
     
        $this->view->params['searchModel'] = new \common\models\CustomerSearch();
      
        $this->view->params['dataProvider']  =  $this->view->params['searchModel']->search(Yii::$app->request->queryParams);

         return $this->render('hello');
    }
}