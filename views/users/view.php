<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


$this->title = $model->second_name." ".$model->first_name." ".$model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'first_name',
            'second_name',
            'last_name',
            'phone',
            'email:email',
            'birthday',
            'status',
        ],
    ]) ?>
</div>
