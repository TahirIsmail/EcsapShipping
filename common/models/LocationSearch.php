<?php

namespace common\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Location;

/**
 * LocationSearch represents the model behind the search form of `app\models\Location`.
 */
class LocationSearch extends Location
{
    public $global_search;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['location_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['location_name', 'created_at', 'updated_at', 'global_search'], 'safe'],
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
    public function search($params,$type = FALSE)
    {
        $query = Location::find();

        $limit = isset($params['per_page']) ? $params['per_page'] : \Yii::$app->params['default_page'];
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        	'pagination' => ['pageSize' =>$limit,'defaultPageSize' =>$limit],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'location_name', $this->location_name])
            ->orFilterWhere(['like', 'location_name', $this->global_search])
            ->andFilterWhere(['=', 'status', $this->status])
            ;
       if($type!='' && $type)
       {
           $query->andWhere(['type'=>$type]);
       }
        return $dataProvider;
    }
}
