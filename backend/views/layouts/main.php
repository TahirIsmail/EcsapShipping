<?php
/* @var $this \yii\web\View */
/* @var $content string */
use backend\assets_b\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <!-- <meta name="viewport" content="width=1024"> -->
    <?= Html::csrfMetaTags() ?>
    <title>Ecsap Shipping</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody();
if(Yii::$app->user->isGuest){
    $wrapper = 'wrappers';
   } else{
    $wrapper = 'wrapper';
   }
?>
<div id="<?= $wrapper; ?>" class="wrap">

  <?php $this->beginContent('@app/views/layouts/admin_sidebar.php'); ?>
    <?php $this->endContent(); ?>    

    <div class="container-fluid">
        <?php // Breadcrumbs::widget([
           // 'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        //]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>
<?php
if(!Yii::$app->user->isGuest){?>
<footer class="footer">
    <div class="container-fluid">
        <p class="pull-left">&copy; Ecsap Shipping <?= date('Y') ?></p>

        <p class="pull-right"></p>
    </div>
</footer>
<?php } ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<script>
$(document).mousemove(function (e) {
       //$("body").on("mousemove", function(mouse_pointer) {
       //console.log(mouse_pointer.pageX - $(window).scrollLeft());
       //mouse_position = mouse_pointer.pageX - $(window).scrollLeft();
        
       mouse_position = e.clientX;
       if(mouse_position<5){
            $( '#wrapper' ).addClass('toggled');
            localStorage.setItem("toggled", true);
       }
       if(mouse_position>300){
            $( '#wrapper' ).removeClass('toggled');
            localStorage.setItem("toggled", false);
       }
});
</script>
<style>
.form-group button[type=submit]{
    float: right !important;
    margin: 10px;
    margin-right: 17%;
}
</style>