<?php

namespace common\models; 

use Yii; 
use yii\base\Model; 
use yii\data\ActiveDataProvider; 
use common\models\InvoicePayment; 

/** 
 * InvoicePaymentSearch represents the model behind the search form of `common\models\InvoicePayment`. 
 */ 
class InvoicePaymentSearch extends InvoicePayment 
{
    public $invoice_global_search;
    /** 
     * {@inheritdoc} 
     */ 
    public function rules() 
    { 
        return [ 
            [['id', 'invoice_id', 'export_id', 'customer_id', 'updated_by', 'created_by'], 'integer'],
            [['paid_amount', 'remaining_amount'], 'number'],
            [['updated_at', 'created_at', 'note', 'added_by_role','invoice_global_search'], 'safe'], 
        ]; 
    } 

    /** 
     * {@inheritdoc} 
     */ 
    public function scenarios() 
    { 
        // bypass scenarios() implementation in the parent class 
        return Model::scenarios(); 
    } 

    /** 
     * Creates data provider instance with search query applied 
     * 
     * @param array $params 
     * 
     * @return ActiveDataProvider 
     */ 
    public function search($params) 
    { 
        $query = InvoicePayment::find(); 
        $query->joinWith(['customerUser as cu']);
        $query->joinWith(['paymentInvoice as pi']);
        // add conditions that should always apply here 
        $query->orderBy('created_at desc');
        $dataProvider = new ActiveDataProvider([ 
            'query' => $query, 
        ]); 

        $this->load($params); 
        $user_id = Yii::$app->user->getId();
        $Role = Yii::$app->authManager->getRolesByUser($user_id);
        if(isset($Role['customer'])){
            $query->andFilterWhere(['=','customer_id',$user_id]);
        }
        $query->orFilterWhere(['like', 'invoice_id', $this->invoice_global_search])
            ->orFilterWhere(['like', 'cu.legacy_customer_id', $this->invoice_global_search]);
        if (!$this->validate()) { 
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1'); 
            return $dataProvider; 
        } 

        // grid filtering conditions 
        $query->andFilterWhere([
            'id' => $this->id,
            'invoice_id' => $this->invoice_id,
            'export_id' => $this->export_id,
            'customer_id' => $this->customer_id,
            'paid_amount' => $this->paid_amount,
            'remaining_amount' => $this->remaining_amount,
            'updated_by' => $this->updated_by,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider; 
    } 
} 