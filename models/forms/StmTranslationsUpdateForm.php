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

class StmTranslationsUpdateForm extends StmTranslations
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
        $status = 1;
        if ($this->validate()) {
            foreach ($this->translations as $language_id => $translation) {
                $oTranslation = $this->getIsNewRecord() ? new StmTranslations(['date_created' => new Expression('NOW()')]) : StmTranslations::findOne([
                    'language' => $language_id,
                    'alias'    => $this->getOldAttribute('alias'),
                    'category' => $this->getOldAttribute('category'),
                ]);

                if ( ! empty($oTranslation)) {
                    $oTranslation->category     = $this->category;
                    $oTranslation->alias        = $this->alias;
                    $oTranslation->language     = $language_id;
                    $oTranslation->translation  = $translation;
                    $oTranslation->date_updated = new Expression('NOW()');
                    $oTranslation->author = 'User: ' . Yii::$app->user->getIdentity()->username;

                    if ( ! $oTranslation->save()) {
                        $this->addErrors($oTranslation->getErrors());
                        $status *= 0;
                    }
                } else {
                    $status *= 0;
                }
            }
        }

        return $status === 1;
    }
}