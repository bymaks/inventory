<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tools */

$this->title = 'Создать инструмент';
$this->params['breadcrumbs'][] = ['label' => 'Инструменты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tools-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
