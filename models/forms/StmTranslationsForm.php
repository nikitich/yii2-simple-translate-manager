<?php
/**
 * Created by PhpStorm.
 * User: dev-15
 * Date: 19.12.18
 * Time: 15:39
 */

namespace nikitich\simpletranslatemanager\models\forms;

use Yii;
use nikitich\simpletranslatemanager\models\StmLanguages;
use nikitich\simpletranslatemanager\models\StmCategories;
use nikitich\simpletranslatemanager\models\StmTranslations;
use yii\base\Model;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\validators\StringValidator;

class StmTranslationsForm extends StmTranslations
{
    public $translations;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            ['translations', 'validateTranslations'],
        ]);
    }

    public function validateTranslations($attribute)
    {
        if ( ! $this->hasErrors()) {
            if ( ! is_array($this->translations)) {
                $this->addError($attribute, Yii::t('simpletranslatemanager', 'Translations must be an array!'));
            } else {
                foreach ($this->translations as $language_id => $translation) {
                    if ( ! StmLanguages::findOne(['language_id' => $language_id])) {
                        $this->addError($attribute,
                            Yii::t('simpletranslatemanager', 'Language {lang} not exists', ['lang' => $language_id]));
                    }
                }
            }
        }
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        // var_dump($this->getOldAttributes());
        // var_dump(Yii::$app->controller->module);
        // var_dump($this->validate());
        // var_dump($this->getErrors());
        // var_dump($this->translations);
        // die();
        $status = 1;
        if ($this->validate()) {
            foreach ($this->translations as $language_id => $translation) {

                $oTranslation = StmTranslations::findOne([
                    'language' => $language_id,
                    'alias'    => $this->getOldAttribute('alias'),
                    'category' => $this->getOldAttribute('category'),
                ]);

                if (empty($oTranslation) && !empty($translation)) {
                    $oTranslation = new StmTranslations(['date_created' => new Expression('NOW()')]);
                }

                if ($oTranslation instanceof StmTranslations) {
                    $oTranslation->category     = $this->category;
                    $oTranslation->alias        = $this->alias;
                    $oTranslation->language     = $language_id;
                    $oTranslation->translation  = $translation;
                    $oTranslation->date_updated = new Expression('NOW()');
                    $oTranslation->author = Yii::$app->user->getIdentity()->username;

                    if ( ! $oTranslation->save()) {
                        $this->addErrors($oTranslation->getErrors());
                        $status *= 0;
                    }
                }
            }
        }

        return $status === 1;
    }

    /**
     * @param \kartik\form\ActiveForm $form
     * @param boolean                 $view_only
     *
     * @return array
     */
    public function getFormTabs($form, $view_only = false)
    {
        $languages = StmLanguages::find()
            ->select(['language_id AS label', '(\'\') AS content', '(FALSE) AS active'])
            ->where(['status' => StmLanguages::STATUS_ACTIVE])
            ->asArray()
            ->all()
        ;

        $tabs = array_combine(array_column($languages, 'label'), array_values($languages));

        $translations = StmTranslations::find()
            ->where([
                'alias'    => $this->alias,
                'category' => $this->category,
            ])
            ->all();

        foreach ($translations as $translation) {
            /** @var $translation \nikitich\simpletranslatemanager\models\StmTranslations */
            $tabs[$translation->language] = [
                'label'   => "<span class='stm-translation-exists'>$translation->language</span>",
                'content' => $this->_getTabContent($translation, $form, $view_only),
                'active'  => $translation->language == $this->language,
            ];
        }

        foreach ($tabs as $language_id => &$tab) {
            if (empty($tab['content'])) {
                $model = new StmTranslations();
                $model->language = $language_id;
                $model->category = $this->category;
                $model->alias = $this->alias;
                $model->translation = '';
                $tab['content'] = $this->_getTabContent($model, $form, $view_only);
                $tab['active'] = $language_id == $this->language;
            }
        }

        if (array_sum(array_column($tabs, 'active')) == 0) {
            if (isset($tabs['en-US'])) {
                $tabs['en-US']['active'] = true;
            } elseif(count($tabs) > 0) {
                reset($tabs);
                $tabs[key($tabs)]['active'] = true;
            }
        }

        return array_values($tabs);
    }

    /**
     * @param StmTranslations         $model
     * @param \kartik\form\ActiveForm $form
     * @param bool                    $view_only
     */
    private function _getTabContent($model, $form, $view_only = false)
    {
        if ($view_only) {
            return $model->translation;
        } else {
            return $form->field($model, 'translation')->textarea([
                'rows' => 6,
                'name' => self::formName() . "[translations][{$model->language}]",
            ]);
        }
    }

}