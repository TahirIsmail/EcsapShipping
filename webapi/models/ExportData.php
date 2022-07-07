<?php
namespace app\models;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use common\models\Export;

class ExportData extends Export
{

	
    public $export_global_search = NULL;
    public $customer_name = NULL;
    public function rules()
    {
        return array(array(array("id", "created_by", "updated_by"), "integer"), array(array("export_date", "customer_user_id", "legacy_customer_id", "customer_name", "loading_date", "export_global_search", "broker_name", "booking_number", "eta", "ar_number", "xtn_number", "seal_number", "container_number", "cutt_off", "vessel", "voyage", "terminal", "streamship_line", "destination", "itn", "contact_details", "special_instruction", "container_type", "port_of_loading", "port_of_discharge", "bol_note", "created_at", "updated_at"), "safe"), array(array("export_is_deleted"), "boolean"));
    }
	
	public function scenarios()
	{
		return yii\base\Model::scenarios();
	}

	//get export list
	public function exportList($customerId)
	{
		
		$query = Export::find()->alias("ex");
	    $query->leftJoin("vehicle_export as vx", "vx.export_id = ex.id");
        $query->leftJoin("vehicle as v", "v.id = vx.vehicle_id");
        $query->leftJoin("customer as c", "c.user_id = ex.customer_user_id");
        $dataProvider = new \yii\data\ActiveDataProvider(array("query" => $query, "sort" => array("defaultOrder" => array("id" => SORT_DESC)), "pagination" => array("pageSize" => 20)));
		
        $user_id =$customerId;
     	$Role = \Yii::$app->authManager->getRolesByUser($user_id);
		
        $query->andFilterWhere(array("like", "broker_name", $this->broker_name))->andFilterWhere(array("like", "booking_number", $this->booking_number))->andFilterWhere(array("like", "c.legacy_customer_id", $this->legacy_customer_id))->andFilterWhere(array("like", "c.company_name", $this->customer_name))->andFilterWhere(array("like", "ex.eta", $this->eta))->andFilterWhere(array("like", "ar_number", $this->ar_number))->andFilterWhere(array("like", "xtn_number", $this->xtn_number))->andFilterWhere(array("like", "seal_number", $this->seal_number))->andFilterWhere(array("like", "ex.container_number", $this->container_number))->andFilterWhere(array("like", "cutt_off", $this->cutt_off))->andFilterWhere(array("like", "vessel", $this->vessel))->andFilterWhere(array("like", "voyage", $this->voyage))->andFilterWhere(array("like", "terminal", $this->terminal))->andFilterWhere(array("like", "streamship_line", $this->streamship_line))->andFilterWhere(array("like", "destination", $this->destination))->andFilterWhere(array("like", "itn", $this->itn))->andFilterWhere(array("like", "contact_details", $this->contact_details))->andFilterWhere(array("like", "special_instruction", $this->special_instruction))->andFilterWhere(array("like", "container_type", $this->container_type))->andFilterWhere(array("like", "port_of_loading", $this->port_of_loading))->andFilterWhere(array("like", "port_of_discharge", $this->port_of_discharge))->orFilterWhere(array("like", "booking_number", $this->export_global_search))->orFilterWhere(array("like", "ex.container_number", $this->export_global_search))->orFilterWhere(array("like", "ex.eta", $this->export_global_search))->orFilterWhere(array("like", "xtn_number", $this->export_global_search))->orFilterWhere(array("like", "ar_number", $this->export_global_search))->orFilterWhere(array("like", "broker_name", $this->export_global_search))->orFilterWhere(array("like", "destination", $this->export_global_search))->orFilterWhere(array("like", "c.company_name", $this->export_global_search))->orFilterWhere(array("like", "c.customer_name", $this->export_global_search))->orFilterWhere(array("like", "c.legacy_customer_id", $this->export_global_search))->andFilterWhere(array("like", "bol_note", $this->bol_note));
        if (isset($Role["admin_LA"]) || isset($Role["admin_GA"]) || isset($Role["admin_NY"]) || isset($Role["admin_TX"])) {
        }
        if (isset($Role["admin_LA"])) {
            $query->andFilterWhere(array("=", "v.location", "1"));
            $query->andWhere("v.location is null or v.location = 1");
        } else {
            if (isset($Role["admin_GA"])) {
                $query->andWhere("v.location is null or v.location = 2");
            } else {
                if (isset($Role["admin_NY"])) {
                    $query->andWhere("v.location is null or v.location = 3");
                } else {
                    if (isset($Role["admin_TX"])) {
                        $query->andWhere("v.location is null or v.location = 4");
                    } else {
                        if (isset($Role["admin_TX2"])) {
                            $query->andWhere("v.location is null or v.location = 5");
                        } else {
                            if (isset($Role["admin_NJ2"])) {
                                $query->andWhere("v.location is null or v.location = 6");
                            }
                        }
                    }
                }
            }
        }
        
        //if (isset($_GET["ExportSearch"]["customer_user_id"])) {
            $query->andFilterWhere(array("=", "ex.customer_user_id", $customerId));
		//}
	
		$q2 = $query;
		$dataProvider->setTotalCount($q2->groupBy('v.id')->count());
        
		$provider = new ArrayDataProvider([
			'allModels' => $query->all(),
			
			'pagination' => [
				'pageSize' => 10,
			],
		]);
		// get the posts in the current page
		$result = $provider->getModels();
	
		
		return $result;
	}

	//get export details
	public function exportDetails($id){
		if (($model = \common\models\Export::findOne($id)) !== null) {
            return $model;
        }
        
	}

	
}


?>
