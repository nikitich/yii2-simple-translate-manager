<?php
namespace nikitich\simpletranslatemanager\models;

use yii\base\Model;

class FileModel extends Model
{
    public $filename;
    private $filePath;
    private $attachmentName;


    public function rules()
    {
        return [
            ['filename', 'filter', 'filter' => 'trim'],
            ['filename', 'required'],
            ['filename', 'string'],
        ];
    }

    public function formName()
    {
        return '';
    }

    public function setFile($filename)
    {
        if ($this->load(['filename' => $filename]) && $this->validate()) {
            $this->filePath = $this->filename;
            if (file_exists($this->filePath)) {
                $aPathParts = explode('/', $this->filePath);
                if (count($aPathParts) > 0) {
                    $this->attachmentName = $aPathParts[count($aPathParts) - 1];

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * @return mixed
     */
    public function getAttachmentName()
    {
        return $this->attachmentName;
    }
}