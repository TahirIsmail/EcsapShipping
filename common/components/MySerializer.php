<?php

namespace common\components;
use yii\rest\Serializer;
use Yii;
class MySerializer extends Serializer 
{
    public function serialize($data) 
    {
        $d = parent::serialize($data);
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        $m['baseUrl'] = $actual_link.'/uploads/';
        if (is_array($d)){
            return array_merge($d, $m);
        }else{
            return  $d;
        }
    }
}