  <?php

  use yii\helpers\Html;
  use yii\grid\GridView;
  use yii\widgets\Pjax;
  use yii\helpers\Url;
  use yii\bootstrap\Modal;

  /* @var $this yii\web\View */
  /* @var $searchModel common\models\VehicleSearch */
  /* @var $dataProvider yii\data\ActiveDataProvider */

  $this->title = 'AUTOS';
  $this->params['breadcrumbs'][] = $this->title;

  ?>
           <?php
      Modal::begin([
          'id' => 'modal-report',
          'size' => 'modal-lg',
      ]);

      echo '<div id="modalContentreport"></div>';

      Modal::end();
      ?>
  <div class="vehicle-index">
   <div class="white-box">
      <div class="">
  <div class="col-md-4">
          <h1><?= Html::encode($this->title); ?></h1>
		        <?php
        $user_id = Yii::$app->user->getId();
        $Role = Yii::$app->authManager->getRolesByUser($user_id);
       if (!isset($Role['customer'])) {
           ?>
          <?= Html::button(Yii::t('app', 'Create Vehicle'), ['value' => Url::to('@web/vehicle/create'), 'class' => 'btn btn-primary click_modal pull-left']); ?>

       <?php
       }?>
      </div>
       <?php Pjax::begin(); ?>
      <div class="col-md-8">
      <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
      </div>
      <?php
      Modal::begin([
        'options' => [
            'id' => 'modal',
            'tabindex' => false, // important for Select2 to work properly
        ],
          'size' => 'modal-lg',
      ]);

      echo '<div id="modalContent"></div>';

      Modal::end();
      if (isset($Role['customer'])) {
          ?>

          <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed'],
//for coulumn colors same like asl
              'rowOptions' => function ($model, $key, $index, $column) {
            if ($model->status == 1) {
                return ['style' => 'background-color:#DAF4F0']; //ON HAND
            } else if ($model->status == 2) {
                return ['style' => 'background-color:#FFFF66']; //LOADED
            } else if ($model->status == 3) {
                return ['style' => 'background-color:#DF9D9D']; //DISPATCHED
            } else if ($model->status == 4) {
                return ['style' => 'background-color:#66FF99']; //SHIPPED
            }
        },


            'filterModel' => $searchModel,
            'columns' => [
                
                [
                    'header' => 'PHOTOS',
                    'format' => 'raw',
                    'value' => function ($model) {
                            $image =  $model->images;
                            $x = $model->id;
                        if (isset($image[0]['thumbnail'])) {
                            return '<a id="'.$x.'"><img class="images_export" src="'.\yii\helpers\Url::to('@web/uploads/' . $image[0]->thumbnail,  ['class' => 'image_cont']).'"></a>';;
                        }
                    },
                ],
                [
                  'header' => 'TOW REQ DATE',
                  'attribute' => 'request_dat',
          'value' => 'towingRequest.towing_request_date',
          'headerOptions' => ['style' => 'width:90px;'],
        ],
         [
                'header' => 'DELIVER DATE',
                'attribute' => 'deliver_date',
                'value' => 'towingRequest.deliver_date',
                'headerOptions' => ['style' => 'width:90px;'],
            ],

                
                [
                    'attribute' => 'lot_number',
                    'headerOptions' => ['style' => 'width:90px;'],
                ],
                [
      'label' => 'YEAR/MAKE/MODEL/COLOR',
      'format' => 'raw',
      'value' => function ($model) {
          return $model->year.','.$model->make.','.$model->model;
      },
  ],
  [
                    'attribute' => 'color',
                    'headerOptions' => ['style' => 'width:90px;'],
                ],

  [
    'attribute' => 'vin',
    'format' => 'html',
    'value' => function ($model) {
        return Html::a($model->vin, Yii::$app->urlManager->createUrl('/vehicle/view?id='.$model->id));
    },
],

  [
    'label' => 'KEYS',
    'attribute' => 'keys',
    'format' => 'raw',
    'value' => function ($model) {
        if ($model->keys == 1) {
            return 'YES';
        } else {
            return 'NO';
        }
    },
    'filter' => [1 => 'YES', 0 => 'NO'],
],
				
// [
//                   'header' => 'Pick Up Date',
//                     'attribute' => 'towingRequest.pickup_date',
//                     'headerOptions' => ['style' => 'width:90px;min-width:80px;'],
//                 ],


                [
                    'label' => 'LOC',
                'attribute' => 'location',
                'format' => 'raw',
                'headerOptions' => ['style' => 'width:40px;'],
                'value' => function ($model) {
                    return  $model->location == 1 ? 'LA' :
                   ($model->location == 2 ? 'GA' :
                    ($model->location == 3 ? 'NY' :
                    ($model->location == 4 ? 'TX' :
                    ($model->location == 5 ? 'TX2' :
                    ($model->location == 6 ? 'NJ2' : $model->location)))));
                },
                'filter' => [1 => 'LA', 2 => 'GA', 3 => 'NY', 4 => 'TX'],
              ],
  
//'towingRequest.title_recieved:boolean',
[
	'header'=>'TITLE',
	'value'=>function($model){
		if($model->towingRequest->title_recieved==1){
			return 'YES';
		}else{
			return 'NO';
		}
	},
    'filter' => [1 => 'YES', 0 => 'NO'],
],


// [
//   'headerOptions' => ['style' => 'width:90px;min-width:90px;'],
//   'label' => 'TITLE TYPE',
//       'attribute' => 'towingRequest.title_type',
//       'value' => function ($model) {
//           return  isset(\common\models\Lookup::$title_type[$model->towingRequest->title_type]) ? (\common\models\Lookup::$title_type[$model->towingRequest->title_type]) : 'NO-TITLE';
//       },


      [
            'header'  => 'TITLE TYPE',
      'attribute' => 'title_type',
      'value' => function($model) {
            return isset(common\models\Lookup::$title_type_front[$model->towingRequest->title_type]) ? common\models\Lookup::$title_type_front[$model->towingRequest->title_type] : 'NO-TITLE';
      },
      'filter'        => common\models\Lookup::$title_type_front

    ],
// ],
  [
      'attribute' => 'towingRequest.title_recieved_date',
      'header' => 'TITLE REC',
      'headerOptions' => ['style' => 'width:90px;min-width:80px;'],
  ],

            [
             'label' => 'STATUS',
       'attribute' => 'status',
       'headerOptions' => ['style' => 'width:90px;min-width:90px;'],
       'format' => 'raw',
       'value' => function ($model) {
           $status = isset(\common\models\Lookup::$status[$model->status]) ? \common\models\Lookup::$status[$model->status] : $model->status;

           $vehicle_container = \common\models\VehicleExport::find()->where('vehicle_export_is_deleted!=1')->andWhere(['vehicle_id' => $model->id])->asArray()->one();
           if (isset($vehicle_container['export_id'])) {
               $export = \common\models\Export::find()->where(['id' => $vehicle_container['export_id']])->asArray()->one();
               if (!empty($export['eta']) && $model->status == 4 && $export['eta'] <= date('Y-m-d')) {
                   return 'ARRIVED';
               }
           }

           return  $status;
       },
        'filter' => [1 => 'ON HAND', 2 => 'LOADED', 3 => 'DISPATCHED', 4 => 'SHIPPED','' => 'No Status'],
    ],

    [
        'attribute'=>'container_number',
        'format'=>'html',
        'value'=>function($model){
            $vehicle_container = \common\models\VehicleExport::find()->where("vehicle_export_is_deleted!=1")->andWhere(['vehicle_id'=>$model->id])->asArray()->one();
            if(isset($vehicle_container['export_id'])){
                return "<a href='/export/view?id=".$vehicle_container['export_id']."'>".$model->container_number."</a>";
            }
        }
    ],
    // [
    //     'attribute'=>'booking_number',
    //     'format'=>'html',
    //     'value'=>function($model){
    //         $vehicle_container = \common\models\VehicleExport::find()->where("vehicle_export_is_deleted!=1")->andWhere(['vehicle_id'=>$model->id])->asArray()->one();
    //         if(isset($vehicle_container['export_id'])){
    //             return "<a href='/export/view?id=".$vehicle_container['export_id']."'>".$model->booking_number."</a>";
    //         }
    //     }
    // ],

    [
        'header' => 'ETA',
        'headerOptions' => ['style' => 'width:80px;min-width:80px;'],
        'value' => function ($model) {
            $vehicle_container = \common\models\VehicleExport::find()->where('vehicle_export_is_deleted!=1')->andWhere(['vehicle_id' => $model->id])->asArray()->one();
            if (isset($vehicle_container['export_id'])) {
                $export = \common\models\Export::find()->where(['id' => $vehicle_container['export_id']])->asArray()->one();
                if (isset($export['eta'])) {
                    return $export['eta'];
                }
            }
        },
    ],
           [
                'label' => 'NOTE',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->notes_status == '0' || $model->notes_status == '2') {
                        $notes = \common\models\Note::find()->where(['vehicle_id' => $model->id])->all();
                        if ($notes) {
                            $class = 'link_red';
                            $title = 'Open';
                        } else {
                            $class = 'link_blue';
                            $title = 'Notes';
                        }
                    } else {
                        $class = 'link_green';
                        $title = 'Closed';
                    }

                    return Html::a("$title", [''], [
                        'value' => Yii::$app->urlManager->createUrl('vehicle/notesmodal?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                        'class' => 'click_modal_report grid-action ' . $class . '',
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'bottom',
                        'title' => 'Update',
                    ]);
                },
            ],
            // ['class' => 'yii\grid\ActionColumn',
            //     'options' => ['class' => 'action-column'],
            //     'header' => 'PICTURE',
            //     'template' => '{view}',
            //     'headerOptions' => ['style' => 'width:40px;min-width:40px;'],
            //     'buttons' => [
            //         'view' => function ($url, $model, $key) {
            //             global $images;
            //             if (isset($images[0]['thumbnail'])) {
            //                 $b = '<img id=' . $key . ' class="img" src="' . \yii\helpers\Url::to('@web/uploads/' . $images[0]->thumbnail, ['class' => 'image_cont']) . '">';;
            //                 $btn = Html::a($b, [''], ['class' => 'click_modal_report', 'value' => Yii::$app->urlManager->createUrl('/vehicle/images?id=' . $images[0]['vehicle_id'])]);
            //                 return $btn;
            //             }
            //         },
            //     ],
            // ],
        ],
    ]);
} else {
    ?>
          <style>
          .glyphicon{
              padding: 2px;
            font-size: 1.3em;
          }
          </style>
      <?=GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed resulttable'],
        // 'rowOptions' => function ($model, $key, $index, $column) {
        //     if ($model->status == 1) {
        //         return ['style' => 'background-color:#DAF4F0']; //ON HAND
        //     } else if ($model->status == 2) {
        //         return ['style' => 'background-color:#FFFF66']; //LOADED
        //     } else if ($model->status == 3) {
        //         return ['style' => 'background-color:#DF9D9D']; //DISPATCHED
        //     } else if ($model->status == 4) {
        //         return ['style' => 'background-color:#66FF99']; //SHIPPED
        //     }
        // },
        'columns' => [
            ['class' => 'yii\grid\ActionColumn',
                'options' => ['class' => 'action-column'],
                'template' => '{LOADED}',
                'header' => 'PHOTOS',
                'buttons' => [
                    'LOADED' => function ($url, $model, $key) {
                        $icon = "/uploads/images/no-image.png";
                        $imageObj = \common\models\Images::find()->where(['=', 'vehicle_id', $key])->one();
                        if ($imageObj) {
                            $icon = \yii\helpers\Url::to('@web/uploads/' . $imageObj->thumbnail, true);
                        }
                        $btn = Html::a("<img style='max-width:50px;' src='" . $icon . "' />", [''], [
                            'value' => Yii::$app->urlManager->createUrl('/vehicle/images?id=' . $key), //<---- here is where you define the action that handles the ajax request
                            'class' => 'click_modal_report grid-action ',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'bottom',
                            'title' => 'Update',
                        ]);
                        return $btn;
                    },
                ],
            ],


     //  [
     //          'label'  => 'Total Photos',
     //        'attribute' => 'total_photos',
     //        'headerOptions' => array('style' => 'width:80px;'),
     //        'value' => function($model) {
     //          return count(\common\models\Images::find()->where(['=', 'vehicle_id', $model->id])->all());
     //        },
     //        'filter'        => common\models\Lookup::$title_type_front
     // ],

            // 'id',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'ADD',
                'template' => '{add}',
                'buttons' => [
                    'add' => function ($url, $model, $key) {
                        $btn = Html::a("<span class='glyphicon glyphicon-plus'></span>", [''], [
                            'value' => $model->vin, //<---- here is where you define the action that handles the ajax request
                            'class' => 'add_to_card',
                            'id' => 'add_to_card_' . $model->vin,
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'bottom',
                            'title' => 'Add',
                        ]);
                        if ($model->status == 1) {
                            return $btn;
                        } else {
                            return '-';
                        }
                    },
                ],
                'visibleButtons' => [
                    'delete' => Yii::$app->user->can('super_admin')||Yii::$app->user->can('sub_admin'),
                ],
            ],
              [
                  'attribute' => 'hat_number',
                  'headerOptions' => ['style' => 'width:50px;'],
              ],
              [
                  'header' => 'TOW REQ DATE',
                  'attribute' => 'request_dat',
                'value' => 'towingRequest.towing_request_date',
                'headerOptions' => ['style' => 'width:90px;'],
            ],
            [
                'header' => 'RECEIVED DATE',
                'attribute' => 'deliver_date',
                'value' => 'towingRequest.deliver_date',
                'headerOptions' => ['style' => 'width:90px;'],
            ],
            [
                'attribute' => 'year',
                'headerOptions' => ['style' => 'width:30px;'],
            ],
              //'year',
              'make',
              'model',
               'color',
               [
                   'attribute' => 'vin',
                   'format' => 'html',
                   'value' => function ($model) {
                       return Html::a($model->vin, Yii::$app->urlManager->createUrl('/vehicle/view?id='.$model->id));
                   },
               ],
                  [
                'attribute' => 'lot_number',
                'headerOptions' => ['style' => 'width:90px;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->lot_number, Yii::$app->urlManager->createUrl('/vehicle/view?id='.$model->id));
                },
            ],
     //        [
     //     'attribute' => 'title_recieved',
     //     //'format' => 'boolean',
     //     'value'=>function($model){
     //         if($model->towingRequest->title_recieved==1){
     //             return 'YES';
     //         }else{
     //             return 'NO';
     //         }
     //     },
     //     'filter' => [1 => 'YES', 0 => 'NO'],
     // ],
//      [


//                 'headerOptions' => ['style' => 'width:90px;'],
//                 'format' => 'raw',
// 'attribute' => 'towingRequest.title_type',


//       'value' => function ($model) {
//           return  isset(\common\models\Lookup::$title_type[$model->towingRequest->title_type]) ? (\common\models\Lookup::$title_type[$model->towingRequest->title_type]) : 'NO-TITLE';
//       },

//   ],


[
    'label'  => 'TITLE',
    'attribute' => 'title_type',
    'headerOptions' => array('style' => 'width:80px;'),
    'value' => function($model) {
      return isset(common\models\Lookup::$title_type_front[$model->towingRequest->title_type]) ? common\models\Lookup::$title_type_front[$model->towingRequest->title_type] : 'NO-TITLE';
    },
    'filter'        => common\models\Lookup::$title_type_front

     ],




   [
  'label' => 'BUYER ID',
      'attribute' => 'license_number',
      // 'value' => function ($model) {
      //     return  isset(\common\models\Lookup::$title_type[$model->towingRequest->title_type]) ? (\common\models\Lookup::$title_type[$model->towingRequest->title_type]) : 'NO-TITLE';
      // },
  ],



             [
    		'label' => 'KEYS',
    		'attribute' => 'keys',
    		'format' => 'raw',
    		'value' => function ($model) {
        	if ($model->keys == 1) {
            			return 'YES';
        		} else {
            			return 'NO';
        		}
    		},
    		'filter' => [1 => 'YES', 0 => 'NO'],
		],

            //'lot_number',
            [
                'label' => 'LOC',
            'attribute' => 'location',
            'format' => 'raw',
            'headerOptions' => ['style' => 'width:40px;'],
            'value' => function ($model) {
                $location = $model->location;
                if (isset(\common\models\Lookup::$location[$location])) {
                    return \common\models\Lookup::$location[$location];
                } else {
                    return $location;
                }
            },
            'filter' => [1 => 'LA', 2 => 'GA', 3 => 'NY', 4 => 'TX'],
          ],
//           [
//                 'header' => 'AGE',
//                 'value' => function ($model) {
//                     $delivered = time();
//                     if ($model->status == 1) {
//                         $p = $model->towingRequest->deliver_date;
//                     } else if ($model->status == 2) {
//                         // LOADED
//                         $vehicle_export = \common\models\VehicleExport::find()->joinWith(['export'])->where("vehicle_export_is_deleted!=1")->andWhere(['vehicle_id'=>$model->id])->asArray()->one();
//                         $p =  date('Y-m-d', strtotime($vehicle_export['export']['created_at']));
// //                        $p = $model->towingRequest->towing_request_date;
//                     } else if ($model->status == 3) {
//                         $p = $model->towingRequest->towing_request_date;
//                     } else if ($model->status == 4) {
//                         // Shipped
//                         $vehicle_export = \common\models\VehicleExport::find()->joinWith(['export'])->where("vehicle_export_is_deleted!=1")->andWhere(['vehicle_id'=>$model->id])->asArray()->one();
//                         $delivered = strtotime($vehicle_export['export']['export_date']);
//                         $p = $vehicle_export['export']['eta'];
//                     } else {
//                         return 0;
//                     }

//                     $pickedup = strtotime($p);
//                     $datediff = abs($delivered - $pickedup);
//                     return round($datediff / (60 * 60 * 24));
//                 },
//             ],
               /*
                  [
              'label' => 'CONDITION',
              'attribute' => 'condition',
              'value' => function($model) {
                  if(isset(\common\models\Lookup::$condition[$model->towingRequest->condition]))
                  return  \common\models\Lookup::$condition[$model->towingRequest->condition];
              },
              'filter'=>[0=>'NON-OP',1=>'OPERABLE']
          ],
          */
                             [
              'label' => 'STATUS',
        'attribute' => 'status',
        'headerOptions' => ['style' => 'width:90px;'],
        'format' => 'raw',
        'value' => function ($model) {
            $status = isset(\common\models\Lookup::$status[$model->status]) ? \common\models\Lookup::$status[$model->status] : $model->status;

            $vehicle_container = \common\models\VehicleExport::find()->where('vehicle_export_is_deleted!=1')->andWhere(['vehicle_id' => $model->id])->asArray()->one();
            if (isset($vehicle_container['export_id'])) {
                $export = \common\models\Export::find()->where(['id' => $vehicle_container['export_id']])->asArray()->one();
                if (!empty($export['eta']) && $model->status == 4 && $export['eta'] <= date('Y-m-d')) {
                    return 'ARRIVED';
                }
            }

            return  $status;
        },
         'filter' => [1 => 'ON HAND', 2 => 'MANIFEST', 3 => 'DISPATCHED', 4 => 'SHIPPED',5 => 'PICKED UP',6 => 'ARRIVED', '' => 'No Status'],
     ],
    [
        'label' => 'LOADED DATE',
        'attribute'=>'LOADED_date',
        'headerOptions' => ['style' => 'width:70px;'],
        'value'=>function($model){
            $vehicle_export = \common\models\VehicleExport::find()->joinWith(['export'])->where("vehicle_export_is_deleted!=1")->andWhere(['vehicle_id'=>$model->id])->asArray()->one();
            if(isset($vehicle_export['export']['created_at'])) {
                return date('Y-m-d', strtotime($vehicle_export['export']['created_at']));
            }
        }
    ],
     [

        'attribute'=>'container_number',
        'format'=>'html',
        'value'=>function($model){
            $vehicle_container = \common\models\VehicleExport::find()->where(['vehicle_id'=>$model->id])->asArray()->one();
            if(isset($vehicle_container['export_id'])){
                $export_detail = \common\models\Export::find()->where(['id' => $vehicle_container['export_id']])->one();
                $containerName = !empty($model->container_number) ? $model->container_number : $export_detail->container_number;
return Html::a($containerName, Yii::$app->urlManager->createUrl('/export/view?id='.$vehicle_container['export_id'].$containerName));

            }
        }
    ],
  //  [
  //     'label' => 'Created Date',
  //      'attribute' => 'created_at',
  //      'value' => function ($model) {
  //          return date('Y-m-d', strtotime($model->created_at));
  //      },
  // ],

    //      [
    //       'label' => 'Age',
    //     'attribute' => 'agedays',

    // ],
     //'towingRequest.title_recieved:boolean',
     //'towingRequest.towed:boolean',

    [
        'header' => 'ETA',
        'headerOptions' => ['style' => 'width:80px;min-width:80px;'],
        'value' => function ($model) {
            $vehicle_container = \common\models\VehicleExport::find()->where('vehicle_export_is_deleted!=1')->andWhere(['vehicle_id' => $model->id])->asArray()->one();
            if (isset($vehicle_container['export_id'])) {
                $export = \common\models\Export::find()->where(['id' => $vehicle_container['export_id']])->asArray()->one();
                if (isset($export['eta'])) {
                    return $export['eta'];
                }
            }
        },
    ],

                 [
                    'label' => 'NOTE',
                    'format' => 'raw',
                    'value' => function ($model) {
                        if ($model->notes_status == '0' || $model->notes_status == '2') {
                            $notes = \common\models\Note::find()->where(['vehicle_id' => $model->id])->count();
                            if ($notes > 0) {
                                $class = 'link_red';
                                $title = 'OPEN';
                            } else {
                                $class = 'link_blue';
                                $title = 'NOTES';
                            }
                        } else {
                            $class = 'link_green';
                            $title = 'CLOSED';
                        }

                        return  Html::a("$title", [''], [
                            'value' => Yii::$app->urlManager->createUrl('vehicle/notesmodal?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                            'class' => 'click_modal_report grid-action '.$class.'',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'bottom',
                            'title' => 'Update',
                        ]);
                    },
                ],

      ['class' => 'yii\grid\ActionColumn',
                'options' => ['class' => 'action-column'],
                'header' => 'EDIT',
                'contentOptions' => ['style' => 'width:100px;'],
                'template' => '{LOADED}{bl}{update}{docs}{view}{delete}',
                'buttons' => [
                    'LOADED' => function ($url, $model, $key) {
                        $export_id = 0;
                        $export = \common\models\VehicleExport::findOne(['vehicle_id' => $key]);
                        if ($export) {
                            $export_id = $export->export_id;
                        }
                        $btn = Html::a("<span class='glyphicon glyphicon-file'></span>", [''], [
                            'value' => Yii::$app->urlManager->createUrl('/export/LOADEDmodal?id=' . $export_id), //<---- here is where you define the action that handles the ajax request
                            'class' => 'click_modal_report grid-action ',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'bottom',
                            'title' => 'LOADED',
                        ]);
                        return $btn;
                    },
                    'bl' => function ($url, $model, $key) {
                        $vehicle_export = \common\models\VehicleExport::find()->where(['vehicle_id'=>$model->id])->asArray()->one();
                        $btn = '';
                        if(($model->status == 2 || $model->status == 4) && isset($vehicle_export['export_id'])) {
                            $btn = Html::button(Yii::t('app', 'BL'), ['value' => Yii::$app->urlManager->createUrl('export/ladingmodal?id=' . $vehicle_export['export_id']), 'class' => 'btn btn-xs btn-primary click_modal_report']);
                        }

                        return $btn;
                    },
                    'update' => function ($url, $model, $key) {
                        $btn = Html::a("<span class='glyphicon glyphicon-pencil'></span>", [''], [
                            'value' => Yii::$app->urlManager->createUrl('vehicle/update?id=' . $key), //<---- here is where you define the action that handles the ajax request
                            'class' => 'click_modal grid-action',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'bottom',
                            'title' => 'Update',
                        ]);
                        return $btn;
                    },
                    'docs' => function ($url, $model, $key) {
                        $btn = Html::a("<span class='glyphicon glyphicon-list-alt'></span>", [''], [
                            'value' => Yii::$app->urlManager->createUrl('vehicle/documents?id=' . $key), //<---- here is where you define the action that handles the ajax request
                            'class' => 'click_modal grid-action',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'bottom',
                            'title' => 'Documents',
                        ]);
                        return $btn;
                    },
                ],
                'visibleButtons' => [
                    'delete' => (Yii::$app->user->can('super_admin')||Yii::$app->user->can('sub_admin')),
                    'update' => !Yii::$app->user->can('admin_view_only'),
                ],
            ],

          //     ['class' => 'yii\grid\ActionColumn',
          //     'options' => ['class' => 'action-column'],
          //     'header' => 'EDIT',
          //     'template' => '{update}  {view} {delete}',
          //     'buttons' => [
          //         'update' => function ($url, $model, $key) {
          //             $btn = Html::a("<span class='glyphicon glyphicon-pencil'></span>", [''], [
          //                 'value' => Yii::$app->urlManager->createUrl('vehicle/update?id='.$key), //<---- here is where you define the action that handles the ajax request
          //                 'class' => 'click_modal grid-action',
          //                 'data-toggle' => 'tooltip',
          //                 'data-placement' => 'bottom',
          //                 'title' => 'Update',
          //             ]);

          //             return $btn;
          //         },
          //     ],
          //     'visibleButtons' => [
          //         'delete' => (Yii::$app->user->can('super_admin') || Yii::$app->user->can('admin_NY') || Yii::$app->user->can('admin_GA') || Yii::$app->user->can('admin_TX')),
          //      ],
          // ],
          ],
      ]);
      }
   ?>
      <?php Pjax::end(); ?>
  </div>
   </div>
      </div>
      <div class="modal fade" id="gallery" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Container Images</h4>
                </div>
                <div class="gallery-body">

                </div>
                <div class="gallery-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
  <div class="row" style="display: none">
      <form action="<?php echo Yii::$app->getUrlManager()->createUrl('vehicle/export-excel'); ?>" id="exportExcelForm" method="get" target="_blank">

      </form>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script>
      $(document).ready(function(){
          // export vehicle in excel
          $('#exportExcel').on('click', function (e) {
              e.preventDefault();
              ($('tr.filters').find(':input')).clone().appendTo($('#exportExcelForm'));
              $('#exportExcelForm').submit();
              $("#exportExcelForm").empty();
          });

          $("body").on("click", ".notes_vehicle", function () {

           var formData = new FormData($('#notes-form')[0]);

           $.ajax({
               type: "POST",
               data:  formData,
              // data: "id="+id+"status+"+status,
               url: "<?php echo Yii::$app->getUrlManager()->createUrl('vehicle/notes'); ?>",
               success: function (test) {
                   $('.modal-footer ul').prepend(test);
               },
               error: function (exception) {
                   alert(exception);
               },
                cache: false,
                contentType: false,
                processData: false
           });

       });
          $('body').delegate(".images_export","click",function(){

                                    var id = $(this).parent().attr('id');
                                   $.ajax({
                                       type : 'POST',
                                       data : {id:id},
                                       url :  "<?=Yii::$app->getUrlManager()->createUrl('vehicle-export/vehicle-images');?>",
                                       success: function(data){
                                         $("#gallery").modal();
                                         $('.gallery-body').html(data);
                                       },
                                       error: function (exception) {
                                        }
                                   })
                                })
      });


        $("body").on("click",".add_to_card",function(){
            var vin = $(this).attr('value');
            $.ajax({
                type: "POST",
                data:  {id:vin},
               // data: "id="+id+"status+"+status,
                url: "/vehicle/add-to-cart",
                success: function (data) {
                   if(data){
                    $('#add_to_card_'+vin).css('color','green');
                    $(".cart-count").html(data);
                   }else{
                     alert('Something went wrong! Please contact the administrator');
                   }
                },
                error: function (exception) {
                    alert(exception);
                }
            });
            debugger;
            return false;
        })
        $("body").on("click", ".close_conversatition", function () {

       var id =    $(this).attr('key');
       var open =    $(this).attr('data');

            $.ajax({
                type: "POST",
                data:  {id:id,open:open},
               // data: "id="+id+"status+"+status,
                url: "<?php echo Yii::$app->getUrlManager()->createUrl('vehicle/close-conversatition'); ?>",
                success: function (test) {
                   $('#modal-report').modal('hide');

                },
                error: function (exception) {
                    alert(exception);
                }
            });

        });
    </script>
    <script>
        $(document).ready(function(){
            $("body").on("click", ".notes_vehicle", function () {
                var formData = new FormData($('form')[0]);
                $.ajax({
                    type: "POST",
                    data:  formData,
                    // data: "id="+id+"status+"+status,
                    url: "<?php echo Yii::$app->getUrlManager()->createUrl('vehicle/notes'); ?>",
                    success: function (test) {
                        $('.modal-footer ul').prepend(test);
                        $("form").yiiActiveForm('resetForm');
                    },
                    error: function (exception) {
                        alert(exception);
                    },
                        cache: false,
                        contentType: false,
                        processData: false
                });
            });
            $('body').delegate(".images_export","click",function(){

                                    var id = $(this).parent().attr('id');
                                   $.ajax({
                                       type : 'POST',
                                       data : {id:id},
                                       url :  "<?= Yii::$app->getUrlManager()->createUrl('vehicle-export/vehicle-images'); ?>",
                                       success: function(data){
                                         $("#gallery").modal();
                                         $('.gallery-body').html(data);
                                       },
                                       error: function (exception) {
                                        }
                                   })
                                });
        });

        $("body").on("click",".add_to_card",function(){
        var vin = $(this).attr('value');
        $.ajax({
            type: "POST",
            data:  {id:vin},
           // data: "id="+id+"status+"+status,
            url: "/vehicle/add-to-cart",
            success: function (data) {
               if(data){
                $('#add_to_card_'+vin).css('color','green');
                $(".cart-count").html(data);
               }else{
                 alert('Something went wrong! Please contact the administrator');
               }
            },
            error: function (exception) {
                alert(exception);
            }
        });
        //debugger;
        return false;
        });
        $("body").on("click", ".close_conversatition", function () {

    var id =    $(this).attr('key');
    var open =    $(this).attr('data');

    $.ajax({
        type: "POST",
        data:  {id:id,open:open},
       // data: "id="+id+"status+"+status,
        url: "<?php echo Yii::$app->getUrlManager()->createUrl('vehicle/close-conversatition'); ?>",
        success: function (test) {
           $('#modal-report').modal('hide');

        },
        error: function (exception) {
            alert(exception);
        }
    });

    });
    </script>