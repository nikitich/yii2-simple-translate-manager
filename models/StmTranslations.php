<?php

namespace nikitich\simpletranslatemanager\models;

use Yii;

/**
 * This is the model class for table "stm_translations".
 *
 * @property string $category
 * @property string $alias
 * @property string $language
 * @property string $translation
 * @property string $date_created
 * @property string $date_updated
 */
class StmTranslations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stm_translations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category', 'alias', 'language', 'translation', 'date_created', 'date_updated'], 'required'],
            [['translation'], 'string'],
            [['date_created', 'date_updated'], 'safe'],
            [['category', 'alias'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 5],
            [['category', 'alias', 'language'], 'unique', 'targetAttribute' => ['category', 'alias', 'language']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'category' => Yii::t('simpletranslatemanager', 'Category'),
            'alias' => Yii::t('simpletranslatemanager', 'Alias'),
            'language' => Yii::t('simpletranslatemanager', 'Language'),
            'translation' => Yii::t('simpletranslatemanager', 'Translation'),
            'date_created' => Yii::t('simpletranslatemanager', 'Date Created'),
            'date_updated' => Yii::t('simpletranslatemanager', 'Date Updated'),
        ];
    }
}
