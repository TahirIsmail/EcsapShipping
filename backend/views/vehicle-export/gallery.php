<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii2assets\printthis\PrintThis;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $model common\models\Vehicle */
?>
    <div class="row">
    <div class="col-md-12" style="text-align: center;">
    <h4>Container Images</h4>
    <?php

   if($allImages){
       
     $items = array();
     $saj =array();
    foreach($allImages as $gallery){
      ?>
      <a class="fancyboximages" data-fancybox="images" href="<?=\yii\helpers\Url::to('@web/../uploads/'.$gallery->name, true)?>">
        <img style="width:120px;height:120px;" class="img-fluid" src="<?= \yii\helpers\Url::to('@web/../uploads/'.$gallery->thumbnail, true) ?>">
    </a>
       <?php
      $saj[] = [
        'url' => \yii\helpers\Url::to('@web/uploads/'.$gallery->name, true),
        'src' => \yii\helpers\Url::to('@web/uploads/'.$gallery->thumbnail, true),
        'options' => array('title' => 'Container Images')
      ];
 
  } 
  // var_dump($saj);  
  $items = $saj; 
 

?>
<div id="photo">
    
<?php // dosamigos\gallery\Gallery::widget(['items' => $items]);?>
</div>
<?php
}else{?>
    <h3>No Container Images</h3>
    <?php
}
?>
</div>
    </div>
    <link rel="stylesheet" href="/assets_b/css/jquery.fancybox.css" />
<link rel="stylesheet" href="/assets_b/css/jquery.jqzoom.css" />
<script src="/assets_b/js/jquery.fancybox.js"></script>
<script src="/assets_b/js/jquery.jqzoom-core.js"></script>
<script>
  $('.fancyboximages')[0].click();
  $('.fancybox-button--close').click(function(){
    $('.close').click();
  })
    $('[data-fancybox="images"]').fancybox({
    // Options will go here
    thumbs : {
    autoStart   : true,
    hideOnClose : false
  },
  onComplete: function() {
                        $('.fancybox-image').jqzoom({
                                zoomType: 'innerzoom',
                                title: false,
                                lens: true,
                                showEffect: 'fadein',
                                hideEffect: 'fadeout'
                        })
        }
});
$('.fancybox-button--thumbs').click();
</script>