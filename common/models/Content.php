<?php

namespace common\models;

use common\models\base\BaseContent;
use yii\web\UploadedFile;

/**
 * Class Content
 * @package common\models
 * @method saveUploadFile(UploadedFile $upload) Сохранение выбранного файла в ContentImage
 * @method ContentImage getImage()
 */
class Content extends BaseContent
{
    const IMAGE_THUMB = 'thumb';
    const IMAGE_VIEW = 'view';

    /**
     * @var UploadedFile
     */
    public $uploadImageFile;

    public function behaviors()
    {
        return [
            [
                'class' => ContentImageBehavior::className(),
                'formatImage' => [
                    static::IMAGE_THUMB => ['w' => 400, 'h' => 350, 'thumb' => true ],
                    static::IMAGE_VIEW => ['w' => 1200, 'h' => 1000],
                ],
                'getContentImage' => function () {
                    return $this->getContentImage()->one();
                }
            ],
        ];
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['uploadImageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            ['uploadImageFile', 'required', 'when' => function($model) {
                return empty($model->content_image_id);
            }, 'enableClientValidation' => false ]
        ]);
    }

    public function load($data, $formName = null)
    {
        $result = parent::load($data, $formName);
        $this->uploadImageFile = UploadedFile::getInstance($this, 'uploadImageFile');

        return $result;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->saveUploadFile($this->uploadImageFile)) {
            $this->content_image_id = $this->getImage()->id;
            $this->uploadImageFile = null;
        }

        return parent::save($runValidation, $attributeNames);
    }

    public function incrementView()
    {
        $this->view++;
        $this->updateAttributes(['view']);
    }
}