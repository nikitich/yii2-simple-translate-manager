<?php
/**
 * Created by PhpStorm.
 * User: dev-15
 * Date: 02.01.19
 * Time: 11:57
 */

namespace nikitich\simpletranslatemanager\models\forms;


use nikitich\simpletranslatemanager\services\StmImexService;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class StmImportUploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $translationsFile;

    public function rules()
    {
        return [
            [
                'translationsFile',
                'file',
                'skipOnEmpty' => false,
            ],
        ];
    }

    /**
     * @return bool
     */
    public function upload()
    {
        if ($this->validate()) {
            $path = StmImexService::getFilesFolderPath();
            $path .= DIRECTORY_SEPARATOR . 'uploads';
            if (!file_exists($path)) {
                try {
                    FileHelper::createDirectory($path);
                } catch (Exception $e) {
                    $this->addError('filename', $e->getMessage());
                    return false;
                }
            }
            $filename = $this->translationsFile->baseName . '.' . $this->translationsFile->extension;
            return $this->translationsFile->saveAs($path . DIRECTORY_SEPARATOR . $filename);
        }

        return false;
    }

}