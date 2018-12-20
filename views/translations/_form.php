<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Typeahead;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model \nikitich\simpletranslatemanager\models\forms\StmTranslationsForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $categoriesList array */
?>

<div class="stm-translations-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('simpletranslatemanager', 'Save'), ['class' => 'btn btn-success']) ?>
                
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6 col-lg-3">
            <?= $form->field($model, 'category')
                ->widget(
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
            <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?= TabsX::widget([
                'items'        => $model->getFormTabs($form),
                'position'     => TabsX::POS_ABOVE,
                'bordered'     => true,
                'encodeLabels' => false,
            ]) ?>
        </div>
    </div>


    <?php //= $form->field($model, 'language')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'translation')->textarea(['rows' => 6]) ?>

    <?php //= $form->field($model, 'date_created')->textInput() ?>

    <?php //= $form->field($model, 'date_updated')->textInput() ?>

    <?php //= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>


    <?php ActiveForm::end(); ?>

</div>
