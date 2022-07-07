 <?php
 use yii\helpers\Html;
 use yii\helpers\Url;
?>
  <div class="header-top">
        <div class="container">
            <div class="col-lg-6"> 

            
                </div>
              <div class="col-lg-6"> 
                  
                  <ul class="menu-header-top">
                      <?php  if (Yii::$app->user->isGuest) {?>
                    
                      <li><a data-method="POST" href="<?= Yii::$app->request->baseUrl;?>/login/login">Login</a></li>
                      <?php }else{?>
                       
                      <li><a data-method="post"  href="<?= Yii::$app->request->baseUrl;?>/site/logout">Logout(<?php echo Yii::$app->user->identity->username ?>)</a></li>
                      <li><a> 
       </a></li>
                          <?php }?>
                      
                  </ul>
                 
              </div>
        </div>
    </div>