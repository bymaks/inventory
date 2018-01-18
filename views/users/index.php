<?php
use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Сотрудники';
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
            'attribute'=>'name',
            'label' => 'Логин',
            'value' => function($model){
                return $model->name;
            },
        ],

        [
            'attribute'=>'first_name',
            'label' => 'Ф.И.О.',
            'content' => function($model){
                return Html::a($model->first_name.' '.$model->second_name,'/users/update?id='.$model->id);
            },
        ],
        [
            'attribute'=>'phone',
            'label' => 'Телефон',
            'content' => function($model){
                return $model->phone;
            },
        ],
        /*[
            'attribute'=>'email',
            'label' => 'e-mail',
            'content' => function($model){
                return $model->email;
            },
        ],*/
        [
            'attribute' => 'birthday',
            'label' => 'Возраст',
            'value' => function($model) {
                if(date('m',strtotime($model->birthday.' 00:00:00')) > date('m') || date('m',strtotime($model->birthday.' 00:00:00')) == date('m') && date('d',strtotime($model->birthday.' 00:00:00')) > date('d'))
                    return (date('Y') - date('Y',strtotime($model->birthday.' 00:00:00')) - 1);
                else
                    return (date('Y') - date('Y',strtotime($model->birthday.' 00:00:00')));
            }
        ],
        [
            'label' => 'Роль',
            'value' => function($model) {
                $result = 'не установлена';
                if(!empty($model->role)){

                    $result = $model->role->itemName->ru_name;
                }
                return $result;
            }
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
                Html::a('<i class="glyphicon glyphicon-plus"></i> Добавить сотрудника', ['create'], ['class' => 'btn btn-success'])
            ],
            '{export}',
            '{toggleData}',
        ],
        'columns' => $columns,
    ]); ?>
</div>
