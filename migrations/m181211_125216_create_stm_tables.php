<?php

use nikitich\simpletranslatemanager\Defaults;
use yii\db\Migration;

/**
 * Class m181211_125216_create_stm_tables
 */
class m181211_125216_create_stm_tables extends Migration
{
    private $categories_table = Defaults::CATEGORIES_TABLE;
    private $translation_table = Defaults::TRANSLATIONS_TABLE;
    private $language_table = Defaults::LANGUAGES_TABLE;

    public function safeUp()
    {
        $tables             = Yii::$app->db->schema->getTableNames();
        $dbType             = $this->db->driverName;
        $tableOptions_mysql = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        if ( ! in_array($this->language_table, $tables)) {
            if ($dbType == 'mysql') {
                $this->createTable($this->language_table, [
                    'language_id' => 'CHAR(5) NOT NULL',
                    'language'    => 'CHAR(3) NOT NULL',
                    'country'     => 'CHAR(3) NOT NULL',
                    'name'        => 'CHAR(32) NOT NULL',
                    'name_ascii'  => 'CHAR(32) NOT NULL',
                    'status'      => 'smallint NOT NULL',
                    'PRIMARY KEY (language_id)',
                ], $tableOptions_mysql);
            } else {
                $this->createTable($this->language_table, [
                    'language_id' => $this->string(5)->notNull(),
                    'language'    => $this->string(3)->notNull(),
                    'country'     => $this->string(3)->notNull(),
                    'name'        => $this->string(32)->notNull(),
                    'name_ascii'  => $this->string(32)->notNull(),
                    'status'      => $this->smallInteger()->notNull(),
                ]);
                $this->addPrimaryKey($this->language_table . '_pkey', $this->language_table, ['language_id']);

                $this->batchInsert($this->language_table, [
                    'language_id',
                    'language',
                    'country',
                    'name',
                    'name_ascii',
                    'status',
                ], Defaults::getLanguages());
            }
        }

        if ( ! in_array($this->categories_table, $tables)) {
            if ($dbType == 'mysql') {
                $this->createTable($this->categories_table, [
                    'category_name' => 'VARCHAR(64) NOT NULL',
                    'comment'       => 'VARCHAR(255) NOT NULL',
                    2               => 'PRIMARY KEY (`category_name`)',
                ], $tableOptions_mysql);
            } else {
                $this->createTable($this->categories_table, [
                    'category_name' => $this->string(64)->notNull(),
                    'comment'       => $this->string(255)->notNull(),
                ]);
                $this->addPrimaryKey('category_name_pkey', $this->categories_table, ['category_name']);

            }
            $this->batchInsert($this->categories_table, [
                'category_name',
                'comment',
            ], Defaults::getCategories());
        }

        if ( ! in_array($this->translation_table, $tables)) {
            if ($dbType == 'mysql') {
                $this->createTable($this->translation_table, [
                    'alias'        => 'CHAR(255) NOT NULL',
                    'category'     => 'CHAR(255) NOT NULL',
                    'language'     => 'CHAR(5) NOT NULL',
                    'translation'  => 'TEXT NOT NULL',
                    'date_created' => 'DATETIME NOT NULL',
                    'date_updated' => 'DATETIME NOT NULL',
                    'author'       => 'VARCHAR(255) NOT NULL DEFAULT \'' . Defaults::DEFAULT_AUTHOR . '\'',
                    'type'         => 'VARCHAR(16) NOT NULL DEFAULT \'' . Defaults::getTranslationTypes()[0] . '\'',
                    5              => 'PRIMARY KEY (`language`, `alias`)',
                ], $tableOptions_mysql);
            } else {
                $this->createTable($this->translation_table, [
                    'category'     => $this->string(255)->notNull(),
                    'alias'        => $this->string(255)->notNull(),
                    'language'     => $this->string(5)->notNull(),
                    'translation'  => $this->text()->notNull(),
                    'date_created' => $this->dateTime()->notNull(),
                    'date_updated' => $this->dateTime()->notNull(),
                    'author'       => $this->string(255)->notNull()->defaultValue(Defaults::DEFAULT_AUTHOR),
                    'type'         => $this->string(16)->defaultValue(Defaults::getTranslationTypes()[0]),
                ]);
                $this->addPrimaryKey('cat_alias_lang_pkey', $this->translation_table,
                    ['category', 'alias', 'language']);
            }

            $this->addForeignKey(
                'translations_category_fk',
                $this->translation_table,
                'category',
                $this->categories_table,
                'category_name',
                'RESTRICT',
                'RESTRICT'
            );

            $this->addForeignKey(
                'translations_language_fk',
                $this->translation_table,
                'language',
                $this->language_table,
                'language_id',
                'RESTRICT',
                'RESTRICT'
            );
        }


    }

    public function safeDown()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        if (in_array($this->translation_table, $tables)) {
            $this->dropForeignKey('translations_category_fk', $this->translation_table);
            $this->dropForeignKey('translations_language_fk', $this->translation_table);
            $this->dropTable($this->translation_table);
        }
        if (in_array($this->language_table, $tables)) {
            $this->dropTable($this->language_table);
        }
        if (in_array($this->categories_table, $tables)) {
            $this->dropTable($this->categories_table);
        }

    }
}
