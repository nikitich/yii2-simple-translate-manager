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
 * @property string $author
 * @property string $type
 *
 * @property StmCategories $category0
 * @property StmLanguages $category1
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
            [['category', 'alias', 'author'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 5],
            [['type'], 'string', 'max' => 16],
            [['category', 'alias', 'language'], 'unique', 'targetAttribute' => ['category', 'alias', 'language']],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => StmCategories::className(), 'targetAttribute' => ['category' => 'category_name']],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => StmLanguages::className(), 'targetAttribute' => ['category' => 'language_id']],
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
            'author' => Yii::t('simpletranslatemanager', 'Author'),
            'type' => Yii::t('simpletranslatemanager', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory0()
    {
        return $this->hasOne(StmCategories::className(), ['category_name' => 'category']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory1()
    {
        return $this->hasOne(StmLanguages::className(), ['language_id' => 'category']);
    }
}
