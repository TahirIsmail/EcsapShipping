<?php
namespace api\modules\v1;
use Yii;
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'api\modules\v1\controllers';

  public function init()
{
    parent::init();
    \Yii::$app->user->enableSession = false;
        $headers = Yii::$app->request->headers;
		$accept = $headers->get('Accept-language');

if ($accept=='ar') { 
\Yii::$app->language = 'ar';
    
    }


}
}
