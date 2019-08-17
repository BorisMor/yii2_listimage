<?php

namespace common\models;

use common\models\base\BaseContentImage;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class ContentImage extends BaseContentImage {

    /**
     * Формат изоражения
     * @var array
     */
    public $formatImage = [];

    /**
     * Вернет каталог с загрузки
     * @return string
     * @throws \yii\base\Exception
     */
    protected static function getPathUpload():string
    {
        static $result;

        if ($result) {
            return  $result;
        }

        $result = \Yii::getAlias('@frontend'). '/web/uploads';

        if (!is_dir($result)) {
            FileHelper::createDirectory($result);
        }

        return  $result;
    }

    /**
     * Имя файла
     * @param string $prefix
     * @return string
     */
    public function getFileName($prefix = ''): string
    {
        return  $this->id . '_' . $prefix . '_' . $this->base_name . '.' . $this->extension;
    }

    /**
     * Полный путь до файла
     * @param string $prefix
     * @return string
     * @throws \yii\base\Exception
     */
    public function getFilePath($prefix = ''):string
    {
        return  static::getPathUpload() . '/' . $this->getFileName($prefix);
    }

    /**
     * Список всех изображений разных форматов
     * @return array
     * @throws \yii\base\Exception
     */
    protected function getAllFiles():array
    {
        $result = [];
        $result[''] = $this->getFilePath();

        foreach ($this->formatImage as $prefix => $size) {
            $result[$prefix] = $this->getFilePath($prefix);
        }

        return  $result;
    }

    /**
     * Удалить старые файлы от предудузей загрузки
     * @param $list
     * @throws \yii\base\Exception
     */
    protected function deleteOldFile(array $list)
    {
        foreach ($list as $prefix => $path) {
            $currentPath = $this->getFilePath($prefix);
            if ($currentPath != $path && file_exists($path)) {
                unlink($path);
            }
        }
    }

    public function upload(UploadedFile $upload)
    {
        $oldImage  = $this->getAllFiles();

        $this->type = $upload->type;
        $this->base_name = $upload->baseName;
        $this->size = $upload->size;
        $this->extension = $upload->extension;
        $this->save();

        if ($upload->saveAs( $this->getFilePath())) {
            $this->deleteOldFile($oldImage);
        }
        return $this->id;
    }
}