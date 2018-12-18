<?php

namespace nikitich\simpletranslatemanager\models;

use Yii;

/**
 * This is the model class for table "stm_categories".
 *
 * @property string $category_name
 * @property string $comment
 *
 * @property StmTranslations[] $stmTranslations
 */
class StmCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stm_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_name', 'comment'], 'required'],
            [['category_name'], 'string', 'max' => 64],
            [['comment'], 'string', 'max' => 255],
            [['category_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'category_name' => Yii::t('simpletranslatemanager', 'Category Name'),
            'comment' => Yii::t('simpletranslatemanager', 'Comment'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStmTranslations()
    {
        return $this->hasMany(StmTranslations::className(), ['category' => 'category_name']);
    }

    public static function getOptionsList()
    {
        $all = self::find()->asArray()->all();
        // var_dump(array_combine(array_column($all, 'category_name'), array_column($all, 'comment')));
        // var_dump($all);
        // var_dump(array_values($all));
        // die();
        return array_combine(array_column($all, 'category_name'), array_column($all, 'comment'));
    }
}
