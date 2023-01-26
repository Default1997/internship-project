<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\QuotaUtilization;

/**
 * QuotaUtilizationSearch represents the model behind the search form of `app\models\QuotaUtilization`.
 */
class QuotaUtilizationSearch extends QuotaUtilization
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['date', 'request_method', 'api_method', 'params'], 'safe'],
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
        $query = QuotaUtilization::find()->where(['user_id' => \Yii::$app->user->identity->id])->orderBy(['date' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'request_method', $this->request_method])
            ->andFilterWhere(['like', 'api_method', $this->api_method])
            ->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'params', $this->params]);

        return $dataProvider;
    }
}
