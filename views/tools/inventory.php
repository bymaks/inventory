<?php
use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Инвентаризация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <?php
    if(empty($storeSelect)){
        foreach ($stores as $store){
            echo Html::a($store->name.' ('.$store->description.')', \yii\helpers\Url::current(['store'=>$store->id])).Html::tag('br');
        }
    }
    else{
        ?>
        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                    <input type="text" name="ToolId" count="0" store="<?=$storeSelect->id?>" id="ToolId" autofocus="" class="form-control" >
                    <span class="input-group-btn">
                        <button class="btn btn-default btn btn-primary"   id="sendBtn" type="button">Найден</button>
                    </span>
                </div><!-- /input-group -->
                <div class="input-group">
                    <span id="resultScan"></span>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
        <section class="controls">
            <div style="float:left;">
                <button id="camera-me" >Заупстить распознавание номера</button>
            </div>
            <div id="video-preview">
                <button id="stop-decode" >Остановить</button>
            </div>
        </section>
        <div id="interactive" class="viewport"></div>


        <?php
    }
    ?>
</div>

