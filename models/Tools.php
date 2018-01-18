<?php

namespace app\models;

use Yii;

class Tools extends \yii\db\ActiveRecord
{

    public static function tableName(){
        return 'tools';
    }

    public function rules(){
        return [
            [['code', 'name', 'price'], 'required'],
            [['price'], 'number'],
            [['store_id', 'created_by_user', 'update_by_user', 'status'], 'integer'],
            [['comments'], 'string'],
            [['date_create', 'date_update'], 'safe'],
            [['code'], 'string', 'max' => 8],
            [['name'], 'string', 'max' => 128],

            ['date_create', 'default', 'value'=>($this->isNewRecord?Date('Y-m-d H:i:s'):$this->date_create)],
            ['created_by_user', 'default', 'value'=>($this->isNewRecord?Yii::$app->user->id:$this->created_by_user)],
            ['update_by_user', 'default', 'value'=>($this->isNewRecord?NULL:Yii::$app->user->id)],

            [['created_by_user'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by_user' => 'id']],
            [['update_by_user'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['update_by_user' => 'id']],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => ToolsStores::className(), 'targetAttribute' => ['store_id' => 'id']],
        ];
    }

    public function attributeLabels(){
        return [
            'id' => 'ID',
            'code' => 'Инвент. номер',
            'name' => 'Название',
            'price' => 'Цена',
            'store_id' => 'Склад',
            'comments' => 'Комментарий',
            'date_create' => 'Дата создания',
            'date_update' => 'Дата последнего редактирования',
            'created_by_user' => 'Создан пользователем',
            'update_by_user' => 'Обновлен пользователем',
            'status' => 'Статус',
        ];
    }

    public function getCreatedByUser(){
        return $this->hasOne(Users::className(), ['id' => 'created_by_user']);
    }

    public function getUpdateByUser(){
        return $this->hasOne(Users::className(), ['id' => 'update_by_user']);
    }

    public function getStore(){
        return $this->hasOne(ToolsStores::className(), ['id' => 'store_id']);
    }
}
