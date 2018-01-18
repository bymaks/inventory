<?php

namespace app\controllers;

use app\models\ToolsInventory;
use app\models\ToolsStores;
use Yii;
use app\models\Tools;
use app\models\SearchTools;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;

class ToolsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','update','create','view','tools-report', 'inventory'],
                        'allow' => true,
                        'roles' => ['Booker',],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(){
        $searchModel = new SearchTools();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'titlePage'=>'Инструменты',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id){
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate(){
        $model = new Tools();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id){
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionToolsReport(){
        $searchModel = new SearchTools();
        $dataProvider = $searchModel->searchForReport(Yii::$app->request->queryParams);

        return $this->render('index', [
            'titlePage'=>'Требуют учета',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionInventory(){

        if(Yii::$app->request->isPost){
            $result = [
                'status'=>'4',
                'message'=>'Пустые данные',
            ];
            if(is_numeric(Yii::$app->request->post('code')) ){
                $tool = Tools::find()->where(['code'=>Yii::$app->request->post('code'), 'status'=>1])->one();
                if(!empty($tool)){
                    if($tool->store_id == Yii::$app->request->post('store_id')){
                        $toolsInventory = new ToolsInventory();
                        $toolsInventory->tool_id  = $tool->id;
                        $toolsInventory->store_id = $tool->store_id;
                        if($toolsInventory->save(true)){
                            $result = [
                                'status'=>'1',
                                'toolId'=>$tool->id,
                                'toolCode'=>$tool->code,
                                'toolName'=>$tool->name,
                                'store'=>$tool->store->name.' ('.$tool->store->description.')',
                                'message'=>'Успешно сохранен',
                            ];
                        }
                        else{
                            //не сохраненно и вывести ошибку
                            $result = [
                                'status'=>'2',
                                'toolId'=>$tool->id,
                                'toolCode'=>$tool->code,
                                'toolName'=>$tool->name,
                                'store'=>$tool->store->name.' ('.$tool->store->description.')',
                                'message'=>'Не сохранено',
                            ];
                        }

                    }
                    else{
                        $result = [
                            'status'=>'3',
                            'toolId'=>$tool->id,
                            'toolCode'=>$tool->code,
                            'toolName'=>$tool->name,
                            'store'=>'Указанный склад:'.$tool->store->name.' ('.$tool->store->description.')',
                            'message'=>'Склад не совпадает',
                        ];
                    }
                }
                else{
                    // активный инструмент по такому номеру на нейден
                    $result = [
                        'status'=>'4',
                        'message'=>'Активный инструмент по такому номеру на нейден',
                    ];
                }
            }


            return json_encode($result);
        }


        $storeSelect = false;
        if(!empty(Yii::$app->request->get('store')) && is_numeric(Yii::$app->request->get('store'))){
            $storeSelect = ToolsStores::find()->where(['id'=>Yii::$app->request->get('store')])->one();
        }

        return $this->render('inventory',[
            'storeSelect'=>$storeSelect,
            'stores'=>ToolsStores::find()->where(['status'=>1])->all(),
        ]);

    }

    protected function findModel($id){
        if (($model = Tools::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
