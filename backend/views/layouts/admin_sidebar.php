<?php

$user_id = Yii::$app->user->getId();
$Role = Yii::$app->authManager->getRolesByUser($user_id); ?>
 <?php if (!Yii::$app->user->isGuest) {
    ?>
<div id="sidebar-wrapper">
      <ul class="sidebar-nav">
      <li class="sidebar-brand">
          <a href="<?=Yii::$app->homeUrl; ?>site">
          <?php
if (isset($Role['super_admin'])) {
        echo 'ECSAP Global';
    } else {
        echo 'ECSAP Global';
    } ?>
          </a>
        </li>
      <div class="user-panel">
          <div class="pull-left image">
          <?php
if (isset($Role['super_admin'])) {
        ?>
            <img src="<?=\yii\helpers\Url::to('@web/uploads/images/admin.jpg', true); ?>" class="rounded-circle" alt="User Image">
          <?php
    } else {
        ?>
            <img src="<?=\yii\helpers\Url::to('@web/uploads/images/customer.jpg', true); ?>" class="rounded-circle" alt="User Image">
        <?php
    } ?>
          </div>
          <div class="pull-left info">
            <p><?=Yii::$app->user->identity->username; ?></p>

          </div>
        </div>
        <?php
if (isset($Role['super_admin'])) {
        ?>
       <li>
          <a href="<?=Yii::$app->homeUrl; ?>site">HOME</a>
        </li>
        <li>
          <a href="<?=Yii::$app->homeUrl; ?>customer">CUSTOMER</a>
        </li>

        <li>
          <a href="<?=Yii::$app->homeUrl; ?>consignee">CONSIGNEE</a>
        </li>
        <li>
          <a href="<?=Yii::$app->homeUrl; ?>vehicle">VEHICLE</a>
        </li>
        <li>
          <a href="<?=Yii::$app->homeUrl; ?>vehicle-export">CONTAINER</a>
        </li>
        <li>
          <a href="<?=Yii::$app->homeUrl; ?>export">EXPORT</a>
        </li>

        <!--zee-->
        <?php if (Yii::$app->user->can('super_admin')) { ?>
        <li>
        <a href="#demo4" class="" data-toggle="collapse" data-parent="#MainMenu">INVOICES <i class="fa fa-caret-down"></i></a>
          <ul class="collapse" id="demo4">
              <li class="">
                <a href="<?=Yii::$app->homeUrl; ?>invoice">All INVOICES</a>
              </li>
              <li class="">
                <a href="<?=Yii::$app->homeUrl; ?>invoice/paid">PAID INVOICES</a>
              </li>
              <li class="">
                <a href="<?=Yii::$app->homeUrl; ?>invoice/partial-paid">PARTIAL PAID INVOICES</a>
              </li>
              <li class="">
                <a href="<?=Yii::$app->homeUrl; ?>invoice/unpaid">UN PAID INVOICES</a>
              </li>
          </ul>
        </li>
        <?php
        } ?>
        <?php if (!Yii::$app->user->can('restrict-pricing')){ ?>
        <li>
          <a href="<?=Yii::$app->homeUrl; ?>pricing">RATES</a> 
        </li>
        <?php } ?>
        <li>
          <a href="<?=Yii::$app->homeUrl; ?>notification">NOTIFICATION</a>
        </li>
        <?php
    } elseif (isset($Role['customer'])) {
        ?>

        <li>
          <a href="<?=Yii::$app->homeUrl; ?>site">HOME</a>
        </li>

        <li>
          <a href="<?=Yii::$app->homeUrl; ?>vehicle">VEHICLE</a>
        </li>
        <li>
          <a href="<?=Yii::$app->homeUrl; ?>vehicle-export">CONTAINER</a>
        </li>
        <!--zee-->
        <li>
        <a href="#demo4" class="" data-toggle="collapse" data-parent="#MainMenu">INVOICES <i class="fa fa-caret-down"></i></a>
          <ul class="collapse" id="demo4">
          <li class="">
                <a href="<?=Yii::$app->homeUrl; ?>invoice">All INVOICES</a>
              </li>
        <li class="">
                <a href="<?=Yii::$app->homeUrl; ?>invoice/paid">PAID INVOICES</a>
              </li>
              <li class="">
                <a href="<?=Yii::$app->homeUrl; ?>invoice/partial-paid">PARTIAL PAID INVOICES</a>
              </li>
              <li class="">
                <a href="<?=Yii::$app->homeUrl; ?>invoice/unpaid">UN PAID INVOICES</a>
              </li>
          </ul>
        </li>
        <?php if (!Yii::$app->user->can('restrict-pricing')){ ?>
        <li>
          <a href="<?=Yii::$app->homeUrl; ?>pricing">RATES</a>
        </li>
        <?php } ?>
        <li>
          <a href="<?=Yii::$app->homeUrl; ?>notification">NOTIFICATION</a>
        </li>
         <?php
    } else {
        ?>
          <li>
          <a href="<?=Yii::$app->homeUrl; ?>site">HOME</a>
        </li>
        <li>
          <a href="<?=Yii::$app->homeUrl; ?>customer">CUSTOMER</a>
        </li>
        <li>
          <a href="<?=Yii::$app->homeUrl; ?>consignee">CONSIGNEE</a>
        </li>
        <li>
          <a href="<?=Yii::$app->homeUrl; ?>vehicle">VEHICLE</a>
        </li>
        <li>
          <a href="<?=Yii::$app->homeUrl; ?>vehicle-export">CONTAINER</a>
        </li>
        <li>
          <a href="<?=Yii::$app->homeUrl; ?>export">EXPORT</a>
        </li>
        <!--zee-->
        <?php if (Yii::$app->user->can('super_admin') || Yii::$app->user->can('show_invoices')) { ?>
        <li>
        <a href="#demo4" class="" data-toggle="collapse" data-parent="#MainMenu">INVOICES <i class="fa fa-caret-down"></i></a>
          <ul class="collapse" id="demo4">
          <li class="">
                <a href="<?=Yii::$app->homeUrl; ?>invoice">All INVOICES</a>
          </li>
        <li class="">
                <a href="<?=Yii::$app->homeUrl; ?>invoice/paid">PAID INVOICES</a>
              </li>
              <li class="">
                <a href="<?=Yii::$app->homeUrl; ?>invoice/partial-paid">PARTIAL PAID INVOICES</a>
              </li>
              <li class="">
                <a href="<?=Yii::$app->homeUrl; ?>invoice/unpaid">UN PAID INVOICES</a>
              </li>
          </ul>
        </li>
        <?php } ?>
        <?php if (!Yii::$app->user->can('restrict-pricing')){ ?>
        <li>
          <a href="<?=Yii::$app->homeUrl; ?>pricing">PRICES</a>
        </li>
        <?php } ?>
        <li>
          <a href="<?=Yii::$app->homeUrl; ?>notification">NOTIFICATION</a>
        </li>
         <?php
    } ?>
      </ul>
    </div>
    <div class="container-fluid">
      <div class="col-md-8">
    <button aria-controls="bs-navbar" id="menu-toggle" aria-expanded="false" class="collapsed navbar-toggle" data-target="#bs-navbar"
      data-toggle="collapse" type="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="toggle-icon"></span>
      <span class="toggle-icon"></span>
      <span class="toggle-icon"></span>
    </button>
    <img class="logo-img" src="<?=Yii::$app->homeUrl; ?>uploads/logo.png" alt="logo image">
  </div>
    <div class="col-md-4 icon-bar">
        <div class="top-icons pull-right">


          <ul class="navbar-top-links navbar-right">

          <?php if (!Yii::$app->user->isGuest) {
        ?>
                <?php if (!isset($Role['customer'])) {
            ?>
                <li>
          <!--       <a class="top-icons-style" href='/export/create?cart=1'>
                  
          
              

  <i> <img src="uploads/afra11.png"></i>

                <span class="badge badge-orange cart-count"><?=isset(Yii::$app->session['cart']) ? count(Yii::$app->session['cart']) : 0; ?></span>
                </a> -->
                <a class="top-icons-style" href='/export/create?cart=1'>
                <i class="fa fa-shopping-cart"></i>
                <span class="badge badge-orange cart-count"><?=isset(Yii::$app->session['cart']) ? count(Yii::$app->session['cart']) : 0; ?></span>
                </a>
                </li>
                <?php
        } ?>
                <li class="navbar-top-links notify-toggle-wrapper page-topbar">
                          <a href="#" data-toggle="dropdown" class="toggle horn-icon top-icons-style">
                            <i class="fa fa-bullhorn"></i>
                                <span class="badge badge-orange"><?=$note = common\models\Notification::find()->where(['>', 'expire_date', date('Y-m-d')])->count(); ?></span>
                            </a>
                            <ul class="dropdown-menu notifications animated fadeIn">
                                <li class="total">
                                    <span class="small">
                                        You have <strong><?=$note; ?></strong> new notifications.
                                        <a href="javascript:;" class="">From ECSAP Global Admin</a>
                                    </span>
                                </li>
                                <li class="list">

                                    <ul class="dropdown-menu-list list-unstyled ps-active-y">
                                    <?php $all_notifications = common\models\Notification::find()->where(['>', 'expire_date', date('Y-m-d')])->all();
        foreach ($all_notifications as $all_notification) {
            ?>
                                        <li class="unread available"> <!-- available: success, warning, info, error -->
                                            <a href="<?php echo Yii::$app->request->baseUrl; ?>/notification/view?id=<?=$all_notification->id; ?>">
                                                <div class="notice-icon">
                                                    <i class="fa fa-check"></i>
                                                </div>
                                                <div>
                                                    <span class="name">
                                                        <strong><?=$all_notification->subject; ?></strong>
                                                        <span class="time small">Date <?=$all_notification->created_at; ?></span>
                                                    </span>
                                                </div>
                                            </a>
                                        </li>
                                    <?php
        } ?>
                                   </ul>

                                </li>

                                <li class="external">
                                    <a href="javascript:;">
                                        <span>Read All Notifications</span>
                                    </a>
                                </li>
                            </ul>
                        </li>


    <?php
    } ?>

          <li class="dropdown">
         <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user" style="padding: 10px; margin-top: 17px;">
        <?php if (Yii::$app->user->isGuest) {
        ?>
                      <li><a data-method="POST" href="<?=Yii::$app->request->baseUrl; ?>/site/login"><?=Yii::t('app', 'Login'); ?></a></li>
                      <?php
    } else {
        ?>
            </li>
            <li class="divider"></li>
            
            <li>User ID: <?= Yii::$app->user->getId(); ?></li>
            <li><a data-method="post"  href="<?=Yii::$app->request->baseUrl; ?>/site/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
            </li>
            
                      <?php
    } ?>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    </ul>
        </div>
      </div>

  </div>
  <?php
if (isset(Yii::$app->session['first_login'])) {
        Yii::$app->session->destroy();
        if (!isset($Role['super_admin']) && $all_notifications) {
            ?>
 <div class="modal fade" id="myModalfront" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Notifications</h4>
         </div>
         <div class="modal-body">
           <?php
foreach ($all_notifications as $all_notification) {
                ?>
   <h3><strong><?=$all_notification->subject; ?></strong></h3>
   <p><?=$all_notification->message; ?></p>
   <hr>
            <?php
            } ?>
            </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>

      <?php
        }
    } ?>

                      <?php
}?>
    <script>
    $("#menu-toggle").click(function (e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
    <?php if (Yii::$app->user->can('customer')) {
        ?>
      $("#myModalfront").modal();
    <?php
    }?>
  </script>
