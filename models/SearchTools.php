<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tools;

/**
 * SearchTools represents the model behind the search form of `app\models\Tools`.
 */
class SearchTools extends Tools
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'store_id', 'created_by_user', 'update_by_user', 'status'], 'integer'],
            [['code', 'name', 'comments', 'date_create', 'date_update'], 'safe'],
            [['price'], 'number'],
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
    public function search($params)
    {
        $query = Tools::find();

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
            'price' => $this->price,
            'store_id' => $this->store_id,
            'date_create' => $this->date_create,
            'date_update' => $this->date_update,
            'created_by_user' => $this->created_by_user,
            'update_by_user' => $this->update_by_user,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'comments', $this->comments]);

        return $dataProvider;
    }

    public function searchForReport($params)
    {
//        SELECT tools.id, tools.name, count(tools_inventory.id)
//        FROM `tools`
//        LEft join tools_inventory on tools_inventory.tool_id = tools.id AND tools_inventory.date_inventory BETWEEN '2018-01-01 00:00:00' and NOW()
//        WHERE tools.status=1
//        GROUP by tools.id
//        HAVING count(tools_inventory.id)=0
        $query = Tools::find()
            ->select('tools.*')
            ->leftJoin('tools_inventory', 'tools_inventory.tool_id = tools.id AND tools_inventory.date_inventory BETWEEN "'.Date('Y-m-d 00:00:00', strtotime('-21 day', time())).'" and NOW()')
            ->where(['tools.status'=>1])
            ->groupBy(['tools.id'])
            ->having(['count(tools_inventory.id)'=>0]);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                // количество пунктов на странице
                'pageSize' => 50,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'tools.price' => $this->price,
            'tools.price' => $this->price,
            'tools.store_id' => $this->store_id,
        ]);

        $query->andFilterWhere(['like', 'tools.code', $this->code])
            ->andFilterWhere(['like', 'tools.name', $this->name])
            ->andFilterWhere(['like', 'tools.comments', $this->comments]);


        //var_dump($query->createCommand()->getRawSql());die();
        return $dataProvider;
    }
}
