<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model nikitich\simpletranslatemanager\models\StmLanguages */

$this->title = Yii::t('simpletranslatemanager', 'Create Stm Languages');
$this->params['breadcrumbs'][] = ['label' => Yii::t('simpletranslatemanager', 'Stm Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\nikitich\simpletranslatemanager\assets\StmAsset::register($this);
?>
<div class="stm-languages-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
