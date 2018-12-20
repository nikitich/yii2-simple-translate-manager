<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model \nikitich\simpletranslatemanager\models\forms\StmTranslationsForm */

$this->title                   = $model->category;
$this->params['breadcrumbs'][] = ['label' => Yii::t('simpletranslatemanager', 'Stm Translations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
\nikitich\simpletranslatemanager\assets\StmAsset::register($this);
$snippet = "<?= Yii::t('{$model->category}', '{$model->alias}') ?>";
?>
<div class="stm-translations-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-xs-12">
            <?= Html::a(Yii::t('simpletranslatemanager', 'Update'),
                ['update', 'category' => $model->category, 'alias' => $model->alias, 'language_id' => $model->language],
                ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('simpletranslatemanager', 'Delete'),
                ['delete', 'category' => $model->category, 'alias' => $model->alias, 'language_id' => $model->language],
                [
                    'class' => 'btn btn-danger',
                    'data'  => [
                        'confirm' => Yii::t('simpletranslatemanager',
                                'Are you sure you want to delete this translation?') .
                            "\n\n [{$model->language}] {$model->category}\\{$model->alias} " .
                            "\n\n Note: this will delete only traslation for one language: \n [{$model->language}]",
                        'method'  => 'post',
                    ],
                ]) ?>

            <?php if (YII_ENV_DEV === true): ?>
            <?= Html::input('text', 'snippet', $snippet, ['class' => 'stm_t_snippet', 'disabled' => 'disabled']) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?= DetailView::widget([
                'model'      => $model,
                'attributes' => [
                    'category',
                    'alias',
                    'language',
                    'translation:ntext',
                    'date_created',
                    'date_updated',
                    'author',
                    // 'type',
                ],
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?= TabsX::widget([
                'items'        => $model->getFormTabs(null, true),
                'position'     => TabsX::POS_ABOVE,
                'bordered'     => true,
                'encodeLabels' => false,
            ]) ?>

        </div>
    </div>
</div>
