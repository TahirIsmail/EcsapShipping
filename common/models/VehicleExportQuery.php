<?php 
namespace common\models;

use yii\db\ActiveQuery;

class VehicleExportQuery extends ActiveQuery
{
    // conditions appended by default (can be skipped)
    public function init()
    {
        $this->andOnCondition(['vehicle_export_is_deleted' => false]);
        parent::init();
    }
  

    // ... add customized query methods here ...

  
}