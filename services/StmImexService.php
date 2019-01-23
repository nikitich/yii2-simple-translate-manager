<?php
/**
 * Created by PhpStorm.
 * User: dev-15
 * Date: 26.12.18
 * Time: 12:37
 */

namespace nikitich\simpletranslatemanager\services;

use nikitich\simpletranslatemanager\models\StmCategories;
use nikitich\simpletranslatemanager\models\StmLanguages;
use nikitich\simpletranslatemanager\models\StmTranslations;
use Yii;
use yii\helpers\FileHelper;
use yii\data\ActiveDataProvider;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xls as XlsReader;
use PhpOffice\PhpSpreadsheet\Writer\Xls as XlsWriter;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use nikitich\simpletranslatemanager\models\forms\StmImportUploadForm;

class StmImexService
{
    /**
     * @param $dataProvider
     *
     * @return string|null
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \yii\base\Exception
     */
    public static function exportTranslations($dataProvider)
    {
        if ($dataProvider instanceof ActiveDataProvider) {
            $spreadsheet = new Spreadsheet();
            $sheet       = $spreadsheet->getActiveSheet();
            $time        = date('Y-m-d_H-i-s');

            $aTranslations = $dataProvider->query->all();

            $aColumns = range('A', 'Z');
            foreach (range('A', 'H') as $sLetter1) {
                foreach (range('A', 'Z') as $sLetter2) {
                    $aColumns[] = $sLetter1 . $sLetter2;
                }
            }
            $iRow = 1;
            if (is_array($aTranslations) && count($aTranslations) > 0) {
                $aAttributes = $aTranslations[0]->getAttributes();
                if (is_array($aAttributes) && count($aAttributes) > 0) {
                    foreach (array_keys($aAttributes) as $key => $attribute) {
                        $cell = $aColumns[$key] . $iRow;
                        $sheet->setCellValue($cell, $attribute);
                        $sheet->getColumnDimension($aColumns[$key])->setAutoSize(true);
                    }
                }
                foreach ($aTranslations as $translation) {
                    $iRow++;
                    $iColumn = 0;
                    /** @var \nikitich\simpletranslatemanager\models\StmTranslations $translation */
                    $aValues = $translation->getAttributes();
                    foreach ($aValues as $key => $value) {
                        $cell = $aColumns[$iColumn] . $iRow;
                        $sheet->setCellValue($cell, $value);
                        $iColumn++;
                    }
                }

                $sheet->calculateColumnWidths();

                $writer = new XlsWriter($spreadsheet);

                $folder = self::getFilesFolderPath();
                if ( ! file_exists($folder)) {
                    FileHelper::createDirectory($folder);
                }
                $file = "$folder/traslations_$time.xls";

                try {
                    $writer->save($file);

                    return $file;
                } catch (Exception $e) {
                    Yii::error($e->getMessage());

                    return null;
                }
            }
        }

        return null;
    }

    public static function importTranslations($file)
    {
        if (preg_match('/^[a-zA-z\_\d\-]+\.xls$/', $file)) {
            $path = self::getFilesFolderPath() . '/uploads';
            $file = $path . DIRECTORY_SEPARATOR . $file;
            if (file_exists($file)) {
                $reader = new XlsReader();
                try {
                    $sheet = $reader->load($file);
                    try {
                        $sheetData = $sheet->getActiveSheet()->toArray(null, true, true, true);
                        if (is_array($sheetData) && count($sheetData) > 1) {
                            $header = array_values(array_shift($sheetData));
                            foreach ($sheetData as &$datum) {
                                $datum   = array_combine($header, array_values($datum));
                                $strInfo = "{$datum['category']} : {$datum['language']} : {$datum['alias']}";
                                if (self::updateRecord($datum)) {
                                    print_r("[success] {$strInfo}" . PHP_EOL);
                                } else {
                                    print_r("[error] {$strInfo}" . PHP_EOL);
                                }
                            }
                        }
                    } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
                        print_r("[error] {$e->getMessage()} \n");
                        Yii::error($e->getMessage());
                    }
                } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                    print_r("[error] {$e->getMessage()} \n");
                }
            }
        }

        return false;
    }

    /**
     * @return string
     */
    public static function getFilesFolderPath()
    {
        return Yii::getAlias('@runtime/imex/') . Yii::$app->session->getId();
    }

    /**
     * @return \nikitich\simpletranslatemanager\models\forms\StmImportUploadForm
     */
    public static function getUploadFormInstance()
    {
        return new StmImportUploadForm();
    }

    /**
     * @param $data array
     *
     * @return bool
     */
    private static function updateRecord($data)
    {
        if (is_array($data)
            && isset($data['category'])
            && isset($data['alias'])
            && isset($data['language'])
            && isset($data['translation'])
            && isset($data['date_created'])
            && isset($data['date_updated'])
            && isset($data['author'])
            && isset($data['type'])
        ) {
            $category = self::getCategoryByName($data['category']);
            $language = self::getLanguageByName($data['language']);
            if ($category !== null && $language !== null) {
                $record = StmTranslations::findOne([
                    'category' => $data['category'],
                    'language' => $data['language'],
                    'alias'    => $data['alias'],
                ]);
                $record = $record == null ? new StmTranslations() : $record;
                if ( ! isset($record->date_updated)
                    || ( ! empty($record->date_updated)
                        && strtotime($record->date_updated) < strtotime($data['date_updated'])
                    )
                ) {
                    $record->setAttributes($data);

                    return $record->save();
                } else {
                    print_r('[ignore]');

                    return true;
                }
            } else {
                print_r("[error] Category or Language is wrong \n");
            }
        } else {
            print_r("[error] Wrong data structure \n");
        }

        return false;
    }

    /**
     * @param string $categoryName
     *
     * @return \nikitich\simpletranslatemanager\models\StmCategories|null
     */
    private static function getCategoryByName($categoryName)
    {
        $category = StmCategories::findOne(['category_name' => $categoryName]);
        if ($category instanceof StmCategories) {
            return $category;
        } else {
            $category = new StmCategories([
                'category_name' => $categoryName,
                'comment'       => $categoryName . '_imported',
            ]);
            if ($category->save()) {
                return $category;
            } else {
                print_r("[error] can't create category {$categoryName}");
            }
        }

        return null;
    }

    /**
     * @param string $langName
     *
     * @return \nikitich\simpletranslatemanager\models\StmLanguages|null
     */
    private static function getLanguageByName($langName)
    {
        $language = StmLanguages::findOne(['language_id' => $langName]);
        if ($language instanceof StmLanguages) {
            return $language;
        } else {
            print_r("[error] Language '{$langName}' dosen't exist! \n");
        }

        return null;
    }
}