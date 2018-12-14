<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model nikitich\simpletranslatemanager\models\StmTranslationsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stm-translations-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'category') ?>

    <?= $form->field($model, 'alias') ?>

    <?= $form->field($model, 'language') ?>

    <?= $form->field($model, 'translation') ?>

    <?= $form->field($model, 'date_created') ?>

    <?php // echo $form->field($model, 'date_updated') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('simpletranslatemanager', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('simpletranslatemanager', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
