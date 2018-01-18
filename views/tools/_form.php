<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Tools */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tools-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true])->label('Инвент. номер') ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название') ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true])->label('Цена') ?>

    <?= $form->field($model, 'store_id')->dropDownList(ArrayHelper::map(\app\models\ToolsStores::find()->select(['id','concat_ws(" ", name, description) as "name"'] )->where(['status'=>1])->all(), 'id', 'name' ) ,['prompt'=>'Не выбран'])->label('Склад')?>

    <?= $form->field($model, 'comments')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->checkbox()?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
