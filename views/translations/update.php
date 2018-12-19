<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model nikitich\simpletranslatemanager\models\StmTranslations */

$this->title = Yii::t('simpletranslatemanager', 'Update Stm Translations: {name}', [
    'name' => $model->alias . ' [' .$model->category . ']',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('simpletranslatemanager', 'Stm Translations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->category, 'url' => ['view', 'category' => $model->category, 'alias' => $model->alias, 'language_id' => $model->language]];
$this->params['breadcrumbs'][] = Yii::t('simpletranslatemanager', 'Update');
?>
<div class="stm-translations-update">

    <?= $this->render('_form', [
        'model' => $model,
        'categoriesList'           => $categoriesList,
    ]) ?>

</div>
