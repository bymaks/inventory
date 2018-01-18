<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tools */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Инструменты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tools-view">
    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'code',
            'name',
            'price',
            [
                'label' => 'Склад',
                'value' => function($model){
                    return  ((!empty($model->store->name)?$model->store->name.' ':'')).(!empty($model->store->description)?$model->store->description:'');
                }
            ],
            'comments:ntext',
            [
                'label' => 'Дата создания',
                'value' => function($model){
                    return  ((!empty($model->date_create)?Date('d.m.Y H:i', strtotime($model->date_create)):'не известно'));
                }
            ],
            [
                'label' => 'Дата последнего редактирования',
                'value' => function($model){
                    return  ((!empty($model->date_update)?Date('d.m.Y H:i', strtotime($model->date_update)):'не известно'));
                }
            ],
            [
                'label' => 'Создан пользователем',
                'value' => function($model){
                    return  ((!empty($model->created_by_user)?Html::a($model->createdByUser->first_name.' '.$model->createdByUser->second_name,'/users/update?id='.$model->created_by_user):'не известно'));
                }
            ],
            [
                'label' => 'Обновлен пользователем',
                'value' => function($model){
                    return  ((!empty($model->update_by_user)?Html::a($model->updateByUser->first_name.' '.$model->updateByUser->second_name,'/users/update?id='.$model->update_by_user):'не известно'));
                }
            ],
            [
                'label' => 'Статус',
                'value' => function($model){
                    return  ($model->status==1?'Активный':'Удален');
                }
            ]
        ],
    ]) ?>

</div>
