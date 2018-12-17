<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model nikitich\simpletranslatemanager\models\StmCategories */

$this->title = Yii::t('simpletranslatemanager', 'Create Stm Categories');
$this->params['breadcrumbs'][] = ['label' => Yii::t('simpletranslatemanager', 'Stm Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stm-categories-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
