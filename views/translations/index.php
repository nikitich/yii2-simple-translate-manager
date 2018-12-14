<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel nikitich\simpletranslatemanager\models\StmTranslationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('simpletranslatemanager', 'Stm Translations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stm-translations-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('simpletranslatemanager', 'Create Stm Translations'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns'      => [
                ['class' => 'yii\grid\SerialColumn'],

                'category',
                'alias',
                'language',
                'translation:ntext',
                'date_created',
                //'date_updated',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
    } catch (Exception $e) {
        echo '<pre>Grid exception: ' . $e->getMessage() . '</pre>';
    } ?>
    <?php Pjax::end(); ?>
</div>

