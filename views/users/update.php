<?php

use yii\helpers\Html;


$this->title = 'Редактировать сотрудника: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="user-update">
    <?= $this->render('_form', [
        'model' => $model,
        'modelRole' => $modelRole,

    ]) ?>
</div>