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

    <?php //= $form->field($model, 'category')->dropDownList($categoriesList) ?>
    <?= $form->field($model, 'category',
        [
            'addon' => [
                'append' => [
                    'content'  => Html::button('<span class="glyphicon glyphicon-remove"></span>', ['class' => 'btn btn-default', 'onclick' => "document.getElementById('stmtranslationssearch-category').value = ''"]),
                    'asButton' => true,
                ],
            ],
        ]
    )->widget(
        Typeahead::class,
        [
            'options'            => ['placeholder' => 'Select category ...'],
            'pluginOptions'      => ['highlight' => true],
            // 'defaultSuggestions' => $categoriesList,
            'defaultSuggestions' => array_keys($categoriesList),
            'dataset'            => [
                [
                    'local' => array_keys($categoriesList),
                    // 'local' => $categoriesList,
                    // 'prefetch' => $categoriesList,
                    // 'display' => 'category_name',
                    'limit' => 10,
                ],
            ],
        ]
    ) ?>

    <?= $form->field($model, 'alias') ?>

    <?= $form->field($model, 'language') ?>

    <?= $form->field($model, 'translation') ?>

    <?= $form->field($model, 'date_created') ?>

    <?php // echo $form->field($model, 'date_updated') ?>

    <?php // echo $form->field($model, 'author') ?>

    <?php // echo $form->field($model, 'type') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('simpletranslatemanager', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('simpletranslatemanager', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
