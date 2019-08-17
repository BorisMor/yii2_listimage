<?php

namespace common\models;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Позволит подключить ContentImage к любой модели
 *
 * Class ContentImageBehavior
 * @package common\models
 */
class ContentImageBehavior extends Behavior {

    /** @var array описание форматов изображений  */
    public $formatImage = [];

    /** @var \Closure Получение текущего ContentImage  */
    public $getContentImage;

    /** @var ContentImage */
    protected $_image;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    /**
     * @return ContentImage
     */
    public function getImage()
    {
        if ($this->_image) {
            return $this->_image;
        }

        if ($this->getContentImage instanceof \Closure || (is_array($this->getContentImage) && is_callable($this->getContentImage))) {
            $this->_image = call_user_func($this->getContentImage);
        }

        if (!$this->_image) {
            $this->_image = new ContentImage();
        }

        $this->_image->formatImage = $this->formatImage;

        return $this->_image;
    }

    /**
     * Сохранить загружаемый файл
     * @param $uploadFile
     * @return bool|int
     * @throws \yii\base\Exception
     */
    public function saveUploadFile($uploadFile)
    {
        if (!$uploadFile) {
            return false;
        }

        if (is_object($uploadFile) && $uploadFile instanceof UploadedFile) {
            return $this->getImage()->upload($uploadFile);
        }

        return false;
    }

    public function afterDelete()
    {
        $this->getImage()->delete();
    }

}