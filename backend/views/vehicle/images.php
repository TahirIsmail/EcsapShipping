<style>
    img{float:left;width:50%;}
    #modalContentreport{overflow:hidden;}
    .modal-dialog{
        position: absolute;
        right: 500%;
    }
</style>
<div id="fancy-images">
<?php
foreach ($images as $gallery) {
        ?>
    <a data-fancybox="images" href="<?=\yii\helpers\Url::to('@web/../uploads/'.$gallery->name, true); ?>">
        <img style="width:120px;height:120px;" class="img-fluid" src="<?= \yii\helpers\Url::to('@web/../uploads/'.$gallery->thumbnail, true); ?>">
    </a>
       <?php
      $saj[] = [
        'url' => \yii\helpers\Url::to('@web/../uploads/'.$gallery->name, true),
        'src' => \yii\helpers\Url::to('@web/../uploads/'.$gallery->thumbnail, true),
        'options' => array('title' => ''),
      ];
    }
 ?>
 </div>
<div id="photo"></div>

<link rel="stylesheet" href="/assets_b/css/jquery.fancybox.css" />
<link rel="stylesheet" href="/assets_b/css/jquery.jqzoom.css" />
<script src="/assets_b/js/jquery.fancybox.js"></script>
<script src="/assets_b/js/jquery.jqzoom-core.js"></script>
<script>

    $('[data-fancybox="images"]').fancybox({
    // Options will go here
    thumbs : {
    autoStart   : true,
    hideOnClose : true
  },
  afterShow: function(){
      $('#modal-report').modal('hide');
   },
  onComplete: function() {
                        $('.fancybox-image').jqzoom({
                                zoomType: 'innerzoom',
                                title: false,
                                lens: true,
                                showEffect: 'fadein',
                                hideEffect: 'fadeout'
                        })
        },
  afterClose: function(){
      
   }
});
$('document').ready(function(){
     $("#fancy-images a:first").trigger('click'); 
})
</script>