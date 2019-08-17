<?php

namespace common\models;

use common\models;
use common\models\base\BaseContent;
use yii\web\UploadedFile;

class Content extends BaseContent
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ]);
    }

    /**
     * Модель
     * @return ContentImage
     */
    public function getModelContentImage()
    {
        static $img;

        if ($img) {
            return  $img;
        }

        $img = parent::getContentImage()->one();

        if (!$img) {
            $img = new ContentImage();
        }

        $img->

        return $img;
    }

    protected function uploadImageFile()
    {
        if (!$this->imageFile) {
            return true;
        }

        $this->content_image_id = $this->getModelContentImage()->upload($this->imageFile);

        return !empty($this->content_image_id);
    }

    public function load($data, $formName = null)
    {
        $result = parent::load($data, $formName);
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        return $result;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $result = $this->uploadImageFile();
        $result = $result && parent::save($runValidation, $attributeNames);

        return $result;
    }
}