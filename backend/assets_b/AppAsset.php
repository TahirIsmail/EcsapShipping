<?php

namespace backend\assets_b;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/assets_b';
    public $css = [
        'css/site.css',
        'js/css/theme.css',
        'js/css/jsgrid.css',
        '/assets_b/css/font-awesome.min.css',
        
       
    ];
    public $js = [  
      
        //'js/raphael-min.js',
        //'js/morris.js',
       // 'js/jquery.sparkline.min.js',
      //  'js/dashboard1.js',
        'js/src/jsgrid.core.js',
        'js/src/jsgrid.load-indicator.js',
        'js/src/jsgrid.load-strategies.js',
        'js/src/jsgrid.sort-strategies.js',
        'js/src/jsgrid.validation.js',
        'js/src/jsgrid.field.js',
        'js/src/fields/jsgrid.field.text.js',
        'js/src/fields/jsgrid.field.number.js',
        'js/src/fields/jsgrid.field.select.js',
        'js/src/fields/jsgrid.field.checkbox.js',
        'js/src/fields/jsgrid.field.control.js',
        'js/db_invoices.js',
        'js/db_export_vehicle.js',
        'js/custom.js',
    ];
    public $depends = [
      
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );
 
}
