<?php

namespace backend\controllers;

use Yii;
use common\models\Competition;
use common\models\CompetitionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class CompetitionController extends MyController
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new CompetitionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Competition();

        if ($model->load(Yii::$app->request->post()) && $model->saveAdmin(Yii::$app->identity->user->id)) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->task_ids = explode(", ", $model->task_ids);
        $model->time_start = date('Y-m-d\TH:i', $model->time_start);
        $model->time_end = date('Y-m-d\TH:i',  $model->time_end);
        if ($model->load(Yii::$app->request->post()) ) {
            
            $model->task_ids = implode(", ", $model->task_ids);
            $model->time_start = strtotime($model->time_start);
            $model->time_end = strtotime($model->time_end); 
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Competition::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionCheck($id)
    {
        Competition::checkCompetition($id);
        return $this->redirect(['index']);
    }
}
