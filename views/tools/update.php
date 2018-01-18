<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tools */

$this->title = 'Update Tools: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Инструменты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="tools-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
