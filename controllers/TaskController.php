<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\Task;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class TaskController extends Controller
{
    public function actionIndex(): string
    {
        $sort = Yii::$app->request->get('sort', 'created_at');
        $direction = Yii::$app->request->get('direction', SORT_DESC);

        $query = Task::find();

        $query->orderBy([$sort => $direction]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 3
            ]
        ]);


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'sort' => $sort,
            'direction' => $direction
        ]);
    }


    /**
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new Task();

        $model->scenario = 'create';


        if ($this->request->isPost) {


            if ($model->load($this->request->post())) {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

                if ($model->imageFile) {
                    $model->uploadImage();
                }

                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Задача успешно создана!');
                    return $this->redirect(['index']);
                }
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionPreview(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new Task();
        $model->scenario = 'create';

        $model->load($this->request->post(), '');

        return [
            'success' => $model->validate(),
            'html' => $this->renderPartial('_preview', ['model' => $model])
        ];
    }

    /**
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionUpdate(int $id)
    {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $model = $this->findModel($id);


        $model->scenario = 'update';


        if ($model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Задача успешно обновлена!');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }

    /**
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): ?Task
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Задача не найдена.');
    }

}
