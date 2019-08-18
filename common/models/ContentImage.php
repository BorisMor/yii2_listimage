<?php

namespace common\models;

use common\models\base\BaseContentImage;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;


class ContentImage extends BaseContentImage {

    /**
     * Формат изображения. Задает владелец записью
     *
     * [ 'prefix' => ['w' => 100, 'h' => 100, 'thumb' => false ] ]
     * w-ширина, h - высота, thumb - обрезать четко по размеру
     *
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
    protected function getFileName($prefix = ''): string
    {
        return  $this->id . '_' . $prefix . '_' . $this->base_name . '.' . $this->extension;
    }

    /**
     * Полный путь до файла
     * @param string $prefix
     * @return string
     * @throws \yii\base\Exception
     */
    protected function getFilePath($prefix = ''):string
    {
        return  static::getPathUpload() . DIRECTORY_SEPARATOR . $this->getFileName($prefix);
    }

    /**
     * Url до изображения
     * @param $prefix
     * @return string
     */
    public function getUrl($prefix):string
    {
        if ($this->base_name) {
            return '/uploads/' . $this->getFileName($prefix);
        }

        return '';
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

    /**
     * Создать файлы нужного размера
     * @throws \yii\base\Exception
     */
    protected function processImage()
    {
        $originalFile = $this->getFilePath();

        foreach ($this->formatImage as $prefix => $option) {

            $newFileName = $this->getFilePath($prefix);
            $width = $option['w'] ?? 0;
            $height = $option['h'] ?? 0;
            $thumb = $option['thumb'] ?? false;

            if ($thumb) {
                Image::thumbnail($originalFile, $width, $height)
                    ->save($newFileName, ['quality' => 80]);
            } else {
                Image::getImagine()->open($originalFile)
                    ->thumbnail(new Box($width, $height))
                    ->save($newFileName , ['quality' => 80]);
            }
        }
    }

    /**
     * Загрузить файл
     * @param UploadedFile $upload
     * @return int
     * @throws \yii\base\Exception
     */
    public function upload(UploadedFile $upload)
    {
        $oldImage  = $this->getAllFiles();

        $this->type = $upload->type;
        $this->base_name = $upload->baseName;
        $this->size = $upload->size;
        $this->extension = $upload->extension;

        if ($this->save() && $upload->saveAs( $this->getFilePath())) {
            $this->processImage();
            $this->deleteOldFile($oldImage);
        }

        return $this->id;
    }

    public function delete()
    {
        foreach ($this->getAllFiles() as $prefix => $path) {
            if (file_exists($path)) {
                unlink($path);
            }
        }

        return parent::delete();
    }
}