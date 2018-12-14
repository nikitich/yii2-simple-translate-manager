<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model nikitich\simpletranslatemanager\models\StmTranslations */

$this->title = $model->category;
$this->params['breadcrumbs'][] = ['label' => Yii::t('simpletranslatemanager', 'Stm Translations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="stm-translations-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('simpletranslatemanager', 'Update'), ['update', 'category' => $model->category, 'alias' => $model->alias, 'language' => $model->language], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('simpletranslatemanager', 'Delete'), ['delete', 'category' => $model->category, 'alias' => $model->alias, 'language' => $model->language], [
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
                'category',
                'alias',
                'language',
                'translation:ntext',
                'date_created',
                'date_updated',
            ],
        ]);
    } catch (Exception $e) {
        echo '<pre>DetailView exception: ' . $e->getMessage() . '</pre>';
    } ?>

</div>
