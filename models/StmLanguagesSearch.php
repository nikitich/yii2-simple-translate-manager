<?php

namespace nikitich\simpletranslatemanager\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * StmLanguagesSearch represents the model behind the search form of `nikitich\simpletranslatemanager\models\StmLanguages`.
 */
class StmLanguagesSearch extends StmLanguages
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['language_id', 'language', 'country', 'name', 'name_ascii'], 'safe'],
            [['status'], 'integer'],
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
        $query = StmLanguages::find();

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
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['ilike', 'language_id', $this->language_id])
            ->andFilterWhere(['ilike', 'language', $this->language])
            ->andFilterWhere(['ilike', 'country', $this->country])
            ->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'name_ascii', $this->name_ascii]);

        return $dataProvider;
    }
}
