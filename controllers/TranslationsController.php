<?php

namespace nikitich\simpletranslatemanager\controllers;

use nikitich\simpletranslatemanager\models\forms\StmTranslationsUpdateForm;
use nikitich\simpletranslatemanager\models\StmCategories;
use nikitich\simpletranslatemanager\models\StmLanguages;
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
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all StmTranslations models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $translationsSearchModel  = new StmTranslationsSearch();
        $translationsDataProvider = $translationsSearchModel->search(Yii::$app->request->queryParams);
        $categoriesList           = StmCategories::getOptionsList();
        $languagesList            = StmLanguages::getOptionsList();

        return $this->render('index', [
            'translationsSearchModel'  => $translationsSearchModel,
            'translationsDataProvider' => $translationsDataProvider,
            'categoriesList'           => $categoriesList,
            'languagesList'            => $languagesList,
        ]);
    }

    /**
     * Displays a single StmTranslations model.
     *
     * @param string $category
     * @param string $alias
     * @param string $language_id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($category, $alias, $language_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($category, $alias, $language_id),
        ]);
    }

    /**
     * Creates a new StmTranslations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model          = new StmTranslations();
        $categoriesList = StmCategories::getOptionsList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'view',
                'category' => $model->category,
                'alias'    => $model->alias,
                'language_id' => $model->language,
            ]);
        }

        return $this->render('create', [
            'model'          => $model,
            'categoriesList' => $categoriesList,
        ]);
    }

    /**
     * Updates an existing StmTranslations model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param string $category
     * @param string $alias
     * @param string $language_id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($category, $alias, $language_id)
    {
        $model          = $this->findModel($category, $alias, $language_id);
        $categoriesList = StmCategories::getOptionsList();

        // if (Yii::$app->request->getIsPost()
        //     && $model->load(Yii::$app->request->post())
        // ) {
        //     // var_dump(Yii::$app->request->post());
        //     var_dump($model->validate());
        //     die();
        // }

        if (Yii::$app->request->getIsPost()) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect([
                    'view',
                    'category'    => $model->category,
                    'alias'       => $model->alias,
                    'language_id' => $model->language,
                ]);
            } else {
                var_dump($model->getErrors());
                die();
                foreach ($model->getErrors() as $attribute => $error) {
                    
                    Yii::$app->session->addFlash('error', $attribute . ': ' . $error);
                }
            }
        }

        return $this->render('update', [
            'model'          => $model,
            'categoriesList' => $categoriesList,
        ]);
    }

    /**
     * Deletes an existing StmTranslations model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param string $category
     * @param string $alias
     * @param string $language_id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($category, $alias, $language_id)
    {
        $this->findModel($category, $alias, $language_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StmTranslations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $category
     * @param string $alias
     * @param string $language_id
     *
     * @return StmTranslations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($category, $alias, $language_id)
    {
        if (($model = StmTranslationsUpdateForm::findOne([
                'category' => $category,
                'alias'    => $alias,
                'language' => $language_id,
            ])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('simpletranslatemanager', 'The requested page does not exist.'));
    }
}
