<?php 
namespace common\models;

use yii\db\ActiveQuery;

class DeleteQuery extends ActiveQuery
{
    // conditions appended by default (can be skipped)
    public function init()
    {
        $this->andOnCondition(['is_deleted' => false]);
        parent::init();
    }
  

    // ... add customized query methods here ...

  
}