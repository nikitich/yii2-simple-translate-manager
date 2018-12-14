<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model nikitich\simpletranslatemanager\models\StmTranslations */

$this->title = Yii::t('simpletranslatemanager', 'Update Stm Translations: {name}', [
    'name' => $model->category,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('simpletranslatemanager', 'Stm Translations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->category, 'url' => ['view', 'category' => $model->category, 'alias' => $model->alias, 'language' => $model->language]];
$this->params['breadcrumbs'][] = Yii::t('simpletranslatemanager', 'Update');
?>
<div class="stm-translations-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
