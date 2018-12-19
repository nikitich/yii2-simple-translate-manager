<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use \yii\helpers\Url;
use nikitich\simpletranslatemanager\models\StmTranslations;

/* @var $this yii\web\View */
/* @var $translationsSearchModel nikitich\simpletranslatemanager\models\StmTranslationsSearch */
/* @var $translationsDataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('simpletranslatemanager', 'Stm Translations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stm-translations-index">

    <?php Pjax::begin(); ?>

    <?php echo $this->render('_search', [
        'model'          => $translationsSearchModel,
        'categoriesList' => $categoriesList,
        'languagesList'  => $languagesList,
    ]); ?>

    <?= GridView::widget([
        'dataProvider'     => $translationsDataProvider,
        'filterModel'      => $translationsSearchModel,
        'filterRowOptions' => [
            'style' => 'display: none;',
        ],
        'columns'          => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'category',
                'label'     => Yii::t('simpletranslatemanager', 'Category'),
                'filter'    => false,
            ],
            [
                'attribute' => 'alias',
                'label'     => Yii::t('simpletranslatemanager', 'Alias'),
                'filter'    => false,
            ],
            [
                'attribute' => 'language',
                'label'     => Yii::t('simpletranslatemanager', 'Language'),
                'filter'    => false,
            ],
            [
                'value' => 'translation',
                'label' => Yii::t('simpletranslatemanager', 'Translation'),
            ],
            //'translation:ntext',
            //'date_created',
            //'date_updated',
            //'author',
            //'type',

            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
                'options'  => [
                    'style' => 'width:5%;',
                ],
                'buttons'  => [
                    'view'   => function ($url, $model, $key) {
                        /** @var $model StmTranslations */
                        $url  = Url::toRoute([
                            'translations/view',
                            'alias'       => $model->alias,
                            'category'    => $model->category,
                            'language_id' => $model->language,
                        ]);
                        $html = Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url,
                            ['class' => 'btn btn-primary']);

                        return $html;
                    },
                    'update' => function ($url, $model, $key) {
                        /** @var $model StmTranslations */
                        $url  = Url::toRoute([
                            'translations/update',
                            'alias'       => $model->alias,
                            'category'    => $model->category,
                            'language_id' => $model->language,
                        ]);
                        $html = Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                            ['class' => 'btn btn-primary']);

                        return $html;
                    },
                    // 'delete' => function ($url, $model, $key) {
                    //     /** @var $model StmTranslations */
                    //     $url  = Url::toRoute([
                    //         'translations/delete',
                    //         'alias'       => $model->alias,
                    //         'category'    => $model->category,
                    //         'language_id' => $model->language,
                    //     ]);
                    //     $html = Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['class' => 'btn btn-primary']);
                    //
                    //     return $html;
                    // },
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
