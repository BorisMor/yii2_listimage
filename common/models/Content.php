<?php

namespace common\models;

use common\models\base\BaseContent;
use yii\web\UploadedFile;

class Content extends BaseContent
{
    const IMAGE_THUMB = 'thumb';
    const IMAGE_VIEW = 'view';
    
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
    public function getImage()
    {
        static $img;

        if ($img) {
            return  $img;
        }

        $img = parent::getContentImage()->one();

        if (!$img) {
            $img = new ContentImage();
        }

        /**
         * Форматы изображений
         */
        $img->formatImage = [
            static::IMAGE_THUMB => ['w' => 200, 'h' => 200],
            static::IMAGE_VIEW => ['w' => 1200, 'h' => 1000],
        ];

        return $img;
    }

    protected function uploadImageFile()
    {
        if (!$this->imageFile) {
            return true;
        }

        if ($this->validate()) {
            $this->content_image_id = $this->getImage()->upload($this->imageFile);
            $result = !empty($this->content_image_id);

            if ($result) {
                $this->imageFile = null;
            }

            return $result;
        } else {
            return false;
        }
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