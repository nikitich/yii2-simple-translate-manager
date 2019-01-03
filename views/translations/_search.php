<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Typeahead;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model nikitich\simpletranslatemanager\models\StmTranslationsSearch */
/* @var $form kartik\form\ActiveForm */
/* @var $categoriesList array */
/* @var $languagesList array */
/* @var $importUploadForm \nikitich\simpletranslatemanager\models\forms\StmImportUploadForm */
?>

<div class="stm-translations-search">
    <?php $form = ActiveForm::begin([
        'action'  => ['index'],
        'method'  => 'get',
        'options' => [
            'data-pjax' => 1,
        ],
    ]); ?>
    <div class="row">
        <div class="col-xs-6 col-lg-3">
            <?= $form->field($model, 'category',
                [
                    'addon' => [
                        'append' => [
                            'content'  => Html::button('<span class="glyphicon glyphicon-remove"></span>', [
                                'class'   => 'btn btn-default',
                                'onclick' => "document.getElementById('stmtranslationssearch-category').value = ''",
                            ]),
                            'asButton' => true,
                        ],
                    ],
                ]
            )->widget(
                Typeahead::class,
                [
                    'options'            => ['placeholder' => 'Select category ...'],
                    'pluginOptions'      => ['highlight' => true],
                    'defaultSuggestions' => array_keys($categoriesList),
                    'dataset'            => [
                        [
                            'local' => array_keys($categoriesList),
                            'limit' => 10,
                        ],
                    ],
                ]
            ) ?>
        </div>
        <div class="col-xs-6 col-lg-3">
            <?= $form->field($model, 'language')->dropDownList($languagesList) ?>
        </div>
    </div>
    <div class="row">

        <div class="col-xs-12 col-lg-6">
            <div id="additional_search_fields" class="collapse">
                <?= $form->field($model, 'alias') ?>

                <?= $form->field($model, 'translation') ?>

                <?php // echo $form->field($model, 'date_created') ?>

                <?php // echo $form->field($model, 'date_updated') ?>

                <?php // echo $form->field($model, 'author') ?>

                <?php // echo $form->field($model, 'type') ?>

            </div>
            <div class="form-group">
                <?= Html::button(Yii::t('simpletranslatemanager', 'Additional fields'), [
                    'class'       => 'btn btn-primary',
                    'data-toggle' => "collapse",
                    'data-target' => "#additional_search_fields",
                ]) ?>
                <?= Html::submitButton(Yii::t('simpletranslatemanager', 'Search'), ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('simpletranslatemanager', 'Reset'), ['/i18n/translations'],
                    ['class' => 'btn btn-default']) ?>
                <span class="pull-right"><?= Html::a(
                        Yii::t('simpletranslatemanager', 'Create Stm Translations'),
                        ['create'],
                        ['class' => 'btn btn-success']
                    ) ?></span>

            </div>

        </div>
        <?php ActiveForm::end(); ?>

        <div class="col-xs-12 col-lg-6">
            <div class="form-group">
                <span class="pull-right">
                    <?= Html::a(
                        Yii::t('simpletranslatemanager', 'Export'),
                        array_merge(['export'], Yii::$app->request->queryParams),
                        [
                            'class'     => 'btn btn-primary',
                            'data-pjax' => "0",
                        ]
                    ) ?>
                    <?php
                    Modal::begin([
                        'header'       => 'Select File for import translations',
                        'toggleButton' => [
                            'label' => Yii::t('simpletranslatemanager', 'Import'),
                            'class' => 'btn btn-default',
                        ],
                    ]);
                    $form_upload = ActiveForm::begin([
                        'action'  => ['import'],
                        'options' => [
                            'enctype' => 'multipart/form-data', // important
                            'data-pjax' => 1,
                        ]
                    ]);
                    echo $form_upload->field($importUploadForm, 'translationsFile')->widget(FileInput::class, [
                        'options' => ['accept' => 'xls'],
                        'pluginOptions' => [
                            'uploadUrl' => \yii\helpers\Url::toRoute('translations/import'),
                            'maxFileCount' => 1,
                        ]
                    ]);
                    ActiveForm::end();
                    Modal::end();
                    ?>
                </span>
            </div>
        </div>
    </div>

</div>
