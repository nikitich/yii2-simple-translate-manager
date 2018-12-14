<?php

namespace nikitich\simpletranslatemanager\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * StmTranslationsSearch represents the model behind the search form of `nikitich\simpletranslatemanager\models\StmTranslations`.
 */
class StmTranslationsSearch extends StmTranslations
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category', 'alias', 'language', 'translation', 'date_created', 'date_updated'], 'safe'],
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
        $query = StmTranslations::find();

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
            'date_created' => $this->date_created,
            'date_updated' => $this->date_updated,
        ]);

        $query->andFilterWhere(['ilike', 'category', $this->category])
            ->andFilterWhere(['ilike', 'alias', $this->alias])
            ->andFilterWhere(['ilike', 'language', $this->language])
            ->andFilterWhere(['ilike', 'translation', $this->translation]);

        return $dataProvider;
    }
}
