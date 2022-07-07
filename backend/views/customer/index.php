<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Customers');
$this->params['breadcrumbs'][] = $this->title;
/* echo '<pre>';
print_r(Helper::checkRoute('delete'));
exit() */;
?>
<div class="customer-index">
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
                <h1><?= Html::encode($this->title) ?></h1>
                <p>
<?= Html::button(Yii::t('app', 'Create Customer'), ['value' => Url::to('@web/customer/create'), 'class' => 'btn btn-primary click_modal']) ?>
<?= Html::button('Export Excel',
                            ['class' => 'btn btn-success', 'id' => 'exportExcel', 'onclick' => 'click()', 'style' => 'margin-left:6%']) ?>
                </p>
            </div>
                    <?php Pjax::begin(); ?>

            <div class="col-md-6">
                
<?php echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
      
      <?php
        if(\Yii::$app->user->can('super_admin')){
            $template = "{summary}\n{items}\n{pager}";
        }else{
            $template = "{items}";
        }
      ?>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
           // 'filterModel' => $searchModel,
           'layout'=> $template,
           'tableOptions'=>['class'=>'table table-striped table-bordered table-condensed'],
            'columns' => [
             
              //'user_id',
              'legacy_customer_id',
                [
                    'header'=>'CUSTOMER NAME',
                    'format'=>'html',
                    'value'=>function($model){
                        return "<a href='".Yii::$app->urlManager->createUrl('/customer/view?id=' . $model->user_id)."'>".$model->customer_name."<a>";
                    }
                ],
                'company_name',
               // 'address_line_1',
               'user.email',
                 'phone_two',
                'city',
           
                ['class' => 'yii\grid\ActionColumn',
                    'options' => ['class' => 'action-column'],
                    'template' => '{update} {view} {delete}',
                    'buttons' => [
                        'update' => function($url, $model, $key) {
                            
                            $btn = Html::a("<span class='glyphicon glyphicon-pencil'></span>", [''], [
                                            'value' => Yii::$app->urlManager->createUrl('customer/update?id=' . $key), //<---- here is where you define the action that handles the ajax request
                                            'class' => 'click_modal grid-action',
                                            'data-toggle' => 'tooltip',
                                            'data-placement' => 'bottom',
                                            'title' => 'Update'
                            ]);
                            return $btn;
                           
                        }
                    ],
                    'visibleButtons' => [
                                'delete' => Helper::checkRoute('delete'),
                                'update' => Helper::checkRoute('update')
                            ]
                        ],
                    ],
                ]);
                ?>
            </div>
        <?php Pjax::end(); ?>

</div>
      </div>

      <div class="row" style="display: none">
    <form action="<?php echo Yii::$app->getUrlManager()->createUrl('customer/export-excel'); ?>" id="exportExcelForm"
          method="get" target="_blank">
    </form>
</div>

<script>
    $(document).ready(function () {
        // export report in excel
        $('#exportExcel').on('click', function (e) {
            e.preventDefault();
            ($('#w1-filters').find(':input')).clone().appendTo($('#exportExcelForm'));
            $('#exportExcelForm').submit();
            $("#exportExcelForm").empty();
        });
    });
</script>
