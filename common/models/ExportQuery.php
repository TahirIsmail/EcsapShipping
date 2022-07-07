<?php 
namespace common\models;

use yii\db\ActiveQuery;

class ExportQuery extends ActiveQuery
{
    // conditions appended by default (can be skipped)
    public function init()
    {
        $this->andOnCondition(['export_is_deleted' => false]);
        
        parent::init();
    }
  

    // ... add customized query methods here ...

  
}