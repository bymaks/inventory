<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

class UserSearch extends User
{
    public function rules(){
        return [
            [['id', 'status', 'gender'], 'integer'],
            [['first_name', 'name'], 'match', 'pattern'=>'/^\S*$/', 'message'=>'Строка должна быть без пробелов'],
            [['phone'],  'match', 'pattern'=>'/^[0-9]*$/', 'message'=>'Только цифры'],
            [['name', 'second_name', 'last_name', 'phone', 'email',], 'string'],
            ['birthday','safe'],
        ];
    }

    public function scenarios(){
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Users::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'gender' => $this->gender
        ]);

        if(isset($this->birthday) && !empty($this->birthday)){
            $age = $this->birthday;
            $birthyear_begin = date('Y-m-d 00:00:00',strtotime('-'.($this->birthday + 1).' years'));
            $birthyear_end = date('Y-m-d 23:59:59',strtotime('-'.($this->birthday).' years'));
            $query->andFilterWhere(['>=', 'birthday', $birthyear_begin]);
            $query->andFilterWhere(['<=', 'birthday', $birthyear_end]);
        }

//        if(isset($params['UserSearch']['first_name']) && !empty($params['UserSearch']['first_name'])){
//
//        }
//        var_dump($params);die();

        $query->andFilterWhere(['like', 'name', $this->name])
            ->orFilterWhere(['like', 'first_name', $this->first_name])
            ->orFilterWhere(['like', 'second_name', $this->first_name])
            ->orFilterWhere(['like', 'last_name', $this->first_name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }


}
