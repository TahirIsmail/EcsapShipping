<?php 
namespace common\models;

use yii\db\ActiveQuery;

class ConsigneeQuery extends ActiveQuery
{
    // conditions appended by default (can be skipped)
    public function init()
    {
        $this->andOnCondition(['!=','consignee_is_deleted', 1]);
        parent::init();
    }
  

    // ... add customized query methods here ...

  
}