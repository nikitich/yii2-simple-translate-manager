<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model nikitich\simpletranslatemanager\models\StmTranslations */

$this->title = Yii::t('simpletranslatemanager', 'Create Stm Translations');
$this->params['breadcrumbs'][] = ['label' => Yii::t('simpletranslatemanager', 'Stm Translations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stm-translations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
