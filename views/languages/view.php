<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model nikitich\simpletranslatemanager\models\StmLanguages */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('simpletranslatemanager', 'Stm Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="stm-languages-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('simpletranslatemanager', 'Update'), ['update', 'id' => $model->language_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('simpletranslatemanager', 'Delete'), ['delete', 'id' => $model->language_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('simpletranslatemanager', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php try {
        echo DetailView::widget([
            'model'      => $model,
            'attributes' => [
                'language_id',
                'language',
                'country',
                'name',
                'name_ascii',
                'status',
            ],
        ]);
    } catch (Exception $e) {
        echo '<pre>DetailView exception: ' . $e->getMessage() . '</pre>';
    } ?>

</div>
