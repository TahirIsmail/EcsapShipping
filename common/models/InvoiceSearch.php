<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * InvoiceSearch represents the model behind the search form of `common\models\Invoice`.
 */
class InvoiceSearch extends Invoice
{
    public $container_numbers;
    public $customer_name;
    public $invoice_global_search;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'export_id', 'customer_user_id', 'updated_by', 'created_by'], 'integer'],
            [['total_amount', 'paid_amount'], 'number'],
            [['note', 'is_deleted', 'currency', 'updated_at', 'invoice_global_search', 'created_at', 'container_numbers', 'customer_name'], 'safe'],
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
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchCustomerInvoice($params)
    {
        $query = Invoice::find()->select('invoice.customer_user_id,sum(total_amount) as total_amount,sum(paid_amount) as paid_amount,sum(adjustment_storage) as adjustment_storage,sum(adjustment_damaged) as adjustment_damaged,sum(adjustment_discount) as adjustment_discount,sum(adjustment_other) as adjustment_other');
        $query->joinWith(['customerUser as cu', 'export as ex']);
        $query->groupBy('invoice.customer_user_id');
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $user_id = Yii::$app->user->getId();
        $Role = Yii::$app->authManager->getRolesByUser($user_id);
        //$query->where("1=1");
        $query->orFilterWhere(['like', 'invoice.id', $this->invoice_global_search])
            ->orFilterWhere(['like', 'cu.legacy_customer_id', $this->invoice_global_search])
            ->orFilterWhere(['like', 'cu.customer_name', $this->invoice_global_search])
            ->orFilterWhere(['like', 'ex.container_number', $this->invoice_global_search])
            ->orFilterWhere(['like', 'ex.ar_number', $this->invoice_global_search])
            ->orFilterWhere(['like', 'total_amount', $this->invoice_global_search])
            ->orFilterWhere(['like', 'paid_amount', $this->invoice_global_search])
            ->andFilterWhere(['like', 'currency', $this->currency]);
        // ->andFilterWhere(['=', 'invoice.customer_user_id', $user_id]);
        if (isset($Role['customer'])) {
            $query->andWhere(['=', 'invoice.customer_user_id', $user_id]);
        }
        if (isset($_GET['InvoiceSearch']['customer_user_id'])) {
            $query->andWhere(['=', 'invoice.customer_user_id', $_GET['InvoiceSearch']['customer_user_id']]);
        }

        return $dataProvider;
    }

    public function search($params)
    {
        $query = Invoice::find();
        $query->joinWith(['customerUser as cu', 'export as ex']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');

            return $dataProvider;
        }
        $user_id = Yii::$app->user->getId();

        $Role = Yii::$app->authManager->getRolesByUser($user_id);

        $query->orFilterWhere(['like', 'invoice.id', $this->invoice_global_search])
            ->orFilterWhere(['like', 'cu.legacy_customer_id', $this->invoice_global_search])
            ->orFilterWhere(['like', 'cu.customer_name', $this->invoice_global_search])
            ->orFilterWhere(['like', 'ex.container_number', $this->invoice_global_search])
            ->orFilterWhere(['like', 'ex.ar_number', $this->invoice_global_search])
            ->orFilterWhere(['like', 'total_amount', $this->invoice_global_search])
            ->orFilterWhere(['like', 'paid_amount', $this->invoice_global_search])
            ->andFilterWhere(['like', 'currency', $this->currency]);
        // ->andFilterWhere(['=', 'invoice.customer_user_id', $user_id]);
        if (isset($Role['customer'])) {
            $query->andWhere(['=', 'invoice.customer_user_id', $user_id]);
        }
        if (isset($_GET['InvoiceSearch']['customer_user_id'])) {
            $query->andWhere(['=', 'invoice.customer_user_id', $_GET['InvoiceSearch']['customer_user_id']]);
        }

        return $dataProvider;
    }
}
