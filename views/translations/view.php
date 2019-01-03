<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model \nikitich\simpletranslatemanager\models\forms\StmTranslationsForm */

$this->title                   = "{$model->category} : {$model->alias}";
$this->params['breadcrumbs'][] = ['label' => Yii::t('simpletranslatemanager', 'Stm Translations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
\nikitich\simpletranslatemanager\assets\StmAsset::register($this);
?>
<div class="stm-translations-view">

    <h1><?= Html::a(Html::encode($model->category),
            [Url::toRoute('translations/index'), 'StmTranslationsSearch' => ['category' => $model->category]]) ?></h1>

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
                            "\n\n [{$model->language}]\n[{$model->category}]\n[{$model->alias}]" .
                            "\n\n Note: this will delete only traslation for one language: \n [{$model->language}]",
                        'method'  => 'post',
                    ],
                ]) ?>
            <?= Html::a(
                Yii::t('simpletranslatemanager', 'Create Stm Translations'),
                ['create', 'category' => $model->category],
                ['class' => 'btn btn-success']
            ) ?>

        </div>
    </div>
    <?php if (YII_ENV_DEV === true): ?>
    <?php
        $snippet_php  = "Yii::t('{$model->category}', '{$model->alias}')";
        $snippet_html = "<?= {$snippet_php} ?>";
    ?>
    <div class="row stm_snippets">
        <div class="col-xs-12">
            <?= TabsX::widget([
                'items'        => [
                    [
                        'label'   => 'HTML',
                        'content' => Html::input('text', 'snippet', $snippet_html,
                            ['class' => 'stm_t_snippet', 'disabled' => 'disabled']),
                        'active'  => true,
                    ],
                    [
                        'label'   => 'PHP',
                        'content' => Html::input('text', 'snippet', $snippet_php,
                            ['class' => 'stm_t_snippet', 'disabled' => 'disabled']),
                        'active'  => false,
                    ],
                ],
                'position'     => TabsX::POS_ABOVE,
                'bordered'     => true,
                'encodeLabels' => false,
            ]) ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-xs-12">
            <?= DetailView::widget([
                'model'      => $model,
                'attributes' => [
                    'category',
                    'alias',
                    'date_created',
                    'date_updated',
                    'author',
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
