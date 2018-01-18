<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tools_inventory".
 *
 * @property int $id
 * @property int $tool_id
 * @property int $store_id
 * @property string $date_inventory
 * @property int $status
 *
 * @property Tools $tool
 * @property ToolsStores $store
 */
class ToolsInventory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tools_inventory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tool_id', ], 'required'],
            [['tool_id', 'store_id', 'status'], 'integer'],
            [['date_inventory'], 'safe'],
            //['date_inventory', 'default', Date('Y-m-d 00:00:00')],
            [['tool_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tools::className(), 'targetAttribute' => ['tool_id' => 'id']],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => ToolsStores::className(), 'targetAttribute' => ['store_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tool_id' => 'Tool ID',
            'store_id' => 'Store ID',
            'date_inventory' => 'Date Inventory',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTool()
    {
        return $this->hasOne(Tools::className(), ['id' => 'tool_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStore()
    {
        return $this->hasOne(ToolsStores::className(), ['id' => 'store_id']);
    }
}
