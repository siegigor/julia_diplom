<?php

namespace backend\controllers;

use Yii;
use common\models\Task;
use common\models\TaskSearch;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Test;
use backend\models\Model;

class TaskController extends MyController
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
        $searchModel = new TaskSearch();
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
        $model = new Task();
        $modelTests = [new Test];
        if ($model->load(Yii::$app->request->post())) {

            $modelTests = Model::createMultiple(Test::classname());
            Model::loadMultiple($modelTests, Yii::$app->request->post());

            // validate all models
            $valid = $model->validate();

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelTests as $modelTest) {
                            $modelTest->task_id = $model->id;
                            if (! ($flag = $modelTest->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        else {
            return $this->render('create', [
                'model' => $model,
                'modelTests' => (empty($modelTests)) ? [new Test] : $modelTests,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelTests = $model->test;

        if ($model->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelTests, 'id', 'id');
            $modelTests = Model::createMultiple(Test::classname(), $modelTests);
            Model::loadMultiple($modelTests, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelTests, 'id', 'id')));

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelTests) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            Test::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelTests as $modelTest) {
                            $modelTest->task_id = $model->id;
                            if (! ($flag = $modelTest->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelTests' => (empty($modelTests)) ? [new Test] : $modelTests,
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
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
