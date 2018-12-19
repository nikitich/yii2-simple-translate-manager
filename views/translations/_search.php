<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Typeahead;

/* @var $this yii\web\View */
/* @var $model nikitich\simpletranslatemanager\models\StmTranslationsSearch */
/* @var $form kartik\form\ActiveForm */
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
                <?= Html::a('Additional fields', ['#'],['class' => 'btn btn-primary', 'data-toggle'=>"collapse", 'data-target'=>"#additional_search_fields"]) ?>
                <?= Html::submitButton(Yii::t('simpletranslatemanager', 'Search'), ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('simpletranslatemanager', 'Reset'), ['/i18n/translations'], ['class' => 'btn btn-default']) ?>
                <span class="pull-right"><?= Html::a(
                        Yii::t('simpletranslatemanager', 'Create Stm Translations'),
                        ['create'],
                        ['class' => 'btn btn-success']
                    ) ?></span>

            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
