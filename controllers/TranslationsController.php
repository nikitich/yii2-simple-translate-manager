<?php

namespace nikitich\simpletranslatemanager\controllers;

use Yii;
use nikitich\simpletranslatemanager\models\StmTranslations;
use nikitich\simpletranslatemanager\models\StmTranslationsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TranslationsController implements the CRUD actions for StmTranslations model.
 */
class TranslationsController extends Controller
{
    /**
     * {@inheritdoc}
     */
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

    /**
     * Lists all StmTranslations models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StmTranslationsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StmTranslations model.
     * @param string $category
     * @param string $alias
     * @param string $language
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($category, $alias, $language)
    {
        return $this->render('view', [
            'model' => $this->findModel($category, $alias, $language),
        ]);
    }

    /**
     * Creates a new StmTranslations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StmTranslations();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'category' => $model->category, 'alias' => $model->alias, 'language' => $model->language]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing StmTranslations model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $category
     * @param string $alias
     * @param string $language
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($category, $alias, $language)
    {
        $model = $this->findModel($category, $alias, $language);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'category' => $model->category, 'alias' => $model->alias, 'language' => $model->language]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing StmTranslations model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $category
     * @param string $alias
     * @param string $language
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($category, $alias, $language)
    {
        $this->findModel($category, $alias, $language)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StmTranslations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $category
     * @param string $alias
     * @param string $language
     * @return StmTranslations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($category, $alias, $language)
    {
        if (($model = StmTranslations::findOne(['category' => $category, 'alias' => $alias, 'language' => $language])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('simpletranslatemanager', 'The requested page does not exist.'));
    }
}
