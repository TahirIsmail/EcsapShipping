<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Customer;

/**
 * CustomerSearch represents the model behind the search form of `common\models\Customer`.
 */
class CustomerSearch extends Customer
{
    public $global_search;
    public $email;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_by', 'updated_by'], 'integer'],
            [['company_name','legacy_customer_id','customer_name','phone','address_line_1', 'address_line_2','global_search', 'city', 'state', 'country', 'zip_code', 'tax_id', 'created_at', 'updated_at', 'email'], 'safe'],
            [['is_deleted'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
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
    public function search($params, $limitPerPage = 20)
    {
        $query = Customer::find()->alias('cu')->joinWith(['user']);
        $query->orderBy('user_id desc');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => $limitPerPage]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        $user_id = Yii::$app->user->getId();
        $Role =   Yii::$app->authManager->getRolesByUser($user_id);
        if(isset($Role['customer'])){
            $query->andFilterWhere(['=', 'user_id', $user_id]);   
        }else{
            $query->andFilterWhere([
                'user_id' => $this->user_id,
            ]);
        }
        $query->andFilterWhere(['like', 'company_name', $this->company_name])
        ->andFilterWhere(['like', 'cu.customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'legacy_customer_id', $this->legacy_customer_id])
            ->andFilterWhere(['like', 'address_line_1', $this->address_line_1])
            ->andFilterWhere(['like', 'address_line_2', $this->address_line_2])
            ->andFilterWhere(['like', 'cu.city', $this->city])
            ->andFilterWhere(['like', 'cu.state', $this->state])
            ->andFilterWhere(['like', 'country', $this->country])
            //->andFilterWhere(['like', 'us.email', $this->email])
            ->andFilterWhere(['like', 'cu.phone', $this->phone])
//            ->orFilterWhere(['like', 'cu.is_deleted', FALSE])
            
            ->orFilterWhere(['like', 'country', $this->global_search])
            ->orFilterWhere(['like', 'company_name', $this->global_search])
            ->orFilterWhere(['like', 'cu.customer_name', $this->global_search])
            ->orFilterWhere(['like', 'cu.city', $this->global_search])
            ->orFilterWhere(['like', 'user.email', $this->global_search])
            ->orFilterWhere(['like', 'cu.state', $this->global_search])
            ->orFilterWhere(['like', 'tax_id', $this->global_search])
//            ->andFilterWhere(['like', 'zip_code', $this->zip_code])
//            ->andFilterWhere(['like', 'tax_id', $this->tax_id])
            ->orFilterWhere(['=', 'cu.phone_two', $this->global_search]);

//        echo $query->createCommand()->getRawSql(); die;

        return $dataProvider;
    }
}
