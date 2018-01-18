<?php
use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Требуют учета';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <?php
    $layoutGrid= '
        <div style="float: right;">{toolbar}</div>
        {summary} 
        {items}
        {pager}
        <div class="clearfix"></div>
        ';
    $columns =  [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute'=>'code',
            'label' => 'Код',
            'value' => function($model){
                return $model->code;
            },
            'format'=>'raw'
        ],
        [
            'attribute'=>'name',
            'label' => 'Название',
            'value' => function($model){
                return Html::a($model->name,'/tools/update?id='.$model->id);
            },
            'format'=>'html'
        ],
        [
            'attribute'=>'price',
            'label' => 'Цена',
            'value' => function($model){
                return number_format($model->price,2,'.',' ').' р.';
            },
        ],
        [
            'attribute' => 'store_id',
            'label' => 'Склад',
            'value' => function($model) {
                $result = 'Склад не установлен';
                if(!empty($model->store)){
                    $result = $model->store->name.' ('.$model->store->description.')';
                }
                return $result;
            },
            'filter'=>\yii\helpers\ArrayHelper::map(\app\models\ToolsStores::find()->where(['status'=>1])->all(), 'id','description'),
        ],
        [
            'attribute'=>'status',
            'label' => 'Статус',
            'content' => function($model){
                return $model->status ? "<span class='text-success'>Активный</span>" : "<span class='text-danger'>Не активный</span>";
            },
            'filter'=>array("1"=>"Активый","0"=>"Не активный"),
        ],
    ];
    ?>
    <?=GridView::widget([
        'dataProvider'=>$dataProvider,
        'filterModel'=>$searchModel,
        'showPageSummary'=>false,
        'layout' => $layoutGrid,
//        'tableOptions' => [
//            'class' => 'table table-striped table-bordered mobile'
//        ],
        'pjax'=>true,
        'striped'=>true,
        'hover'=>true,

        //'panel'=>['type'=>'primary', 'heading'=>$this->title],
        'responsive'=>false,
        'responsiveWrap'=>false,
        'toolbar' =>  [
            ['content' =>
                Html::a('<i class="glyphicon glyphicon-plus"></i> Добавить инструмент', ['create'], ['class' => 'btn btn-success'])
            ],
            '{export}',
            '{toggleData}',
        ],
        'columns' => $columns,
    ]); ?>
</div>

