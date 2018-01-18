<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tools_stores".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $status
 *
 * @property Tools[] $tools
 */
class ToolsStores extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tools_stores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['description'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTools()
    {
        return $this->hasMany(Tools::className(), ['store_id' => 'id']);
    }
}
