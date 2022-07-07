<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Invoices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-index">

    <div class="white-box">
        <div class="">
            <?php
Modal::begin([
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo '<div id="modalContent"></div>';
Modal::end();
?>
            <div class="col-md-6">
                <div class="col-md-6">
                    <h1><?=Html::encode($this->title); ?></h1>
                    <?php
$user_id = Yii::$app->user->getId();
$Role = Yii::$app->authManager->getRolesByUser($user_id);
if (isset($Role['customer'])) {
} else {
    ?>
                        <p>
                        <?=Html::button(Yii::t('app', 'Create Invoice'), ['value' => Url::to('@web/invoice/create'), 'class' => 'btn btn-primary click_modal']); ?>
                        </p>
                    <?php
}?>
                </div>
                <div class="col-md-6">
                    <?php $customerName = '';
                        if (!isset($Role['customer']) && isset($_GET['InvoiceSearch']['customer_user_id'])) {
                            $customer = \common\models\Customer::findOne(['user_id' => $_GET['InvoiceSearch']['customer_user_id']]);
                            $customerName = $customer->company_name;
                            echo '<h1>Customer:</h1>'.'<b>'.$customerName.'</b>';
                        } ?>
                </div>
            </div>
            <?php //Pjax::begin();?>
            <div class="col-md-6">
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
           <?php if (isset($Role['customer'])) {
                            echo Yii::$app->controller->renderPartial('_grid_customer', ['dataProvider' => $dataProvider]);
                        } else {
                            echo Yii::$app->controller->renderPartial('_grid_admin', ['dataProvider' => $dataProvider]);
                        }
            ?>
        <?php //Pjax::end();?>
        </div>
    </div>
</div>

