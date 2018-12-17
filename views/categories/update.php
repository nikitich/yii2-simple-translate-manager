<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model nikitich\simpletranslatemanager\models\StmCategories */

$this->title = Yii::t('simpletranslatemanager', 'Update Stm Categories: {name}', [
    'name' => $model->category_name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('simpletranslatemanager', 'Stm Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->category_name, 'url' => ['view', 'id' => $model->category_name]];
$this->params['breadcrumbs'][] = Yii::t('simpletranslatemanager', 'Update');
?>
<div class="stm-categories-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
