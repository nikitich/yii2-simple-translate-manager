<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $translationsSearchModel nikitich\simpletranslatemanager\models\StmTranslationsSearch */
/* @var $translationsDataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('simpletranslatemanager', 'Stm Translations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stm-translations-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php echo $this->render('_search', ['model' => $translationsSearchModel, 'categoriesList' => $categoriesList,]); ?>

    <p>
        <?= Html::a(Yii::t('simpletranslatemanager', 'Create Stm Translations'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $translationsDataProvider,
        'filterModel' => $translationsSearchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'category',
            'alias',
            'language',
            'translation:ntext',
            //'date_created',
            //'date_updated',
            //'author',
            //'type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
