<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel nikitich\simpletranslatemanager\models\StmLanguagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('simpletranslatemanager', 'Stm Languages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stm-languages-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('simpletranslatemanager', 'Create Stm Languages'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns'      => [
                ['class' => 'yii\grid\SerialColumn'],

                'language_id',
                'language',
                'country',
                'name',
                'name_ascii',
                //'status',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
    } catch (Exception $e) {
        echo '<pre>Grid exception: ' . $e->getMessage() . '</pre>';
    } ?>
    <?php Pjax::end(); ?>
</div>
