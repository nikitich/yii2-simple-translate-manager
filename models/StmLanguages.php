<?php

namespace nikitich\simpletranslatemanager\models;

use Yii;

/**
 * This is the model class for table "stm_languages".
 *
 * @property string $language_id
 * @property string $language
 * @property string $country
 * @property string $name
 * @property string $name_ascii
 * @property int    $status
 */
class StmLanguages extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE  = 1;

    const STATUS_DISBLED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stm_languages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['language_id', 'language', 'country', 'name', 'name_ascii', 'status'], 'required'],
            [['status'], 'default', 'value' => null],
            [['status'], 'integer'],
            [['language_id'], 'string', 'max' => 5],
            [['language', 'country'], 'string', 'max' => 3],
            [['name', 'name_ascii'], 'string', 'max' => 32],
            [['language_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'language_id' => Yii::t('simpletranslatemanager', 'Language ID'),
            'language'    => Yii::t('simpletranslatemanager', 'Language'),
            'country'     => Yii::t('simpletranslatemanager', 'Country'),
            'name'        => Yii::t('simpletranslatemanager', 'Name'),
            'name_ascii'  => Yii::t('simpletranslatemanager', 'Name Ascii'),
            'status'      => Yii::t('simpletranslatemanager', 'Status'),
        ];
    }
}
