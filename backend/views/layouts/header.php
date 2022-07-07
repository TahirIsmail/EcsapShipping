<?php
use backend\assets_b\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\helpers\BaseUrl;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
$user_id = Yii::$app->user->getId();
$Role =   Yii::$app->authManager->getRolesByUser($user_id);?>

<?php
if(isset($Role['super_admin'])){
    NavBar::begin([
        'brandLabel' => 'ADMIN',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    }else{
        NavBar::begin([
            'brandLabel' => 'ECSAP Global ADMIN',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]); 
    }
    ?>

  <?php
   if (!Yii::$app->user->isGuest) {

 if(isset($Role['super_admin'])){
    $menuItems = [
         ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'Customer', 'url' => ['/customer/index']],
        ['label' => 'Consignee', 'url' => ['/consignee/index']],
        ['label' => 'Vehicle', 'url' => ['/vehicle/index']],
        ['label' => 'Container', 'url' => ['/vehicle-export/index']],
        ['label' => 'Export', 'url' => ['/export/index']],
       // ['label' => 'Invoice', 'url' => ['/invoice/index']],
        ['label' => 'Invoices',  'items' => [
            ['label' => 'All Invoices', 'url' => ['/invoice/index']],
            ['label' => 'Paid Invoices', 'url' => ['/invoice/paid']],
            ['label' => 'Partial Paid Invoices', 'url' => ['/invoice/partial-paid']],
            ['label' => 'Unpaid Invoices', 'url' => ['/invoice/unpaid']],
            ],
        ],
       // ['label' => 'Roles', 'url' => ['/admin']],
     ['label' => 'Prices', 'url' => ['/pricing/index']],
        ['label' => 'Notification', 'url' => ['/notification/']],
    ];
} else if(isset($Role['customer'])){
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
      // ['label' => 'Customer', 'url' => ['/customer/index']],
      // ['label' => 'Consignee', 'url' => ['/consignee/index']],
       ['label' => 'Autos', 'url' => ['/vehicle/index']],
      // ['label' => 'Container', 'url' => ['/export/index']],
       ['label' => 'Containers', 'url' => ['/vehicle-export/index']],
       //['label' => 'Invoice', 'url' => ['/invoice/index']],
     //  ['label' => 'Roles', 'url' => ['/admin']],
     ['label' => 'Tatti', 'url' => ['/pricing/index']],
     ['label' => 'Invoices',  'items' => [
        ['label' => 'All Invoices', 'url' => ['/invoice/index']],
        ['label' => 'Paid Invoices', 'url' => ['/invoice/paid']],
        ['label' => 'Partial Paid Invoices', 'url' => ['/invoice/partial-paid']],
        
        ['label' => 'Unpaid Invoices', 'url' => ['/invoice/unpaid']],
        ],
    ],
    ['label' => 'Notification', 'url' => ['/notification/']]
   ]; 
}
else {
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
      // ['label' => 'Customer', 'url' => ['/customer/index']],
      // ['label' => 'Consignee', 'url' => ['/consignee/index']],
       ['label' => 'Vehicle', 'url' => ['/vehicle/index']],
       ['label' => 'Export', 'url' => ['/export/index']],
      // ['label' => 'Auto Container', 'url' => ['/vehicle-export/index']],
    //    ['label' => 'Invoice', 'url' => ['/invoice/index']],
     //  ['label' => 'Roles', 'url' => ['/admin']],
     ['label' => 'Notifications', 'url' => ['/notification/index']],
     
   ]; 
}
   }
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => ' btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);?>
    <?php if (!Yii::$app->user->isGuest) {?>
    <div class="page-topbar">
                <li class="notify-toggle-wrapper page-topbar">
                            <a href="#" data-toggle="dropdown" class="toggle icon-img">
                               <img src="<?= \yii\helpers\Url::to('@web/uploads/notifications.png', true) ?>">
                                <span class="badge badge-orange"><?= $note = common\models\Notification::find()->where(['>','expire_date',Date('Y-m-d')])->count();?></span>
                            </a>
                            <ul class="dropdown-menu notifications animated fadeIn">
                                <li class="total">
                                    <span class="small">
                                        You have <strong><?= $note; ?></strong> new notifications.
                                        <a href="javascript:;" class="pull-right">From ECSAP Global Admin</a>
                                    </span>
                                </li>
                                <li class="list">

                                    <ul class="dropdown-menu-list list-unstyled ps-active-y">
                                    <?php $all_notifications =  common\models\Notification::find()->where(['>','expire_date',Date('Y-m-d')])->all();
                                    foreach($all_notifications as $all_notification){
                                    ?>
                                        <li class="unread available"> <!-- available: success, warning, info, error -->
                                            <a href="<?php echo Yii::$app->request->baseUrl;?>/notification/view?id=<?= $all_notification->id ?>">
                                                <div class="notice-icon">
                                                    <i class="fa fa-check"></i>
                                                </div>
                                                <div>
                                                    <span class="name">
                                                        <strong><?= $all_notification->subject;  ?></strong>
                                                        <span class="time small">Date <?= $all_notification->created_at;  ?></span>
                                                    </span>
                                                </div>
                                            </a>
                                        </li>
                                    <?php } ?>
                                   </ul>

                                </li>

                                <li class="external">
                                    <a href="javascript:;">
                                        <span>Read All Notifications</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
    
    </div>
    <?php }?>
    <?php
    NavBar::end();
    ?>