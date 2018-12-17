<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model nikitich\simpletranslatemanager\models\StmCategories */

$this->title = $model->category_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('simpletranslatemanager', 'Stm Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="stm-categories-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('simpletranslatemanager', 'Update'), ['update', 'id' => $model->category_name], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('simpletranslatemanager', 'Delete'), ['delete', 'id' => $model->category_name], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('simpletranslatemanager', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'category_name',
            'comment',
        ],
    ]) ?>

</div>
