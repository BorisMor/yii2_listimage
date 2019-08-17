<?php

namespace common\models\base;

use Yii;
use common\models\ContentImage;

/**
 * This is the model class for table "content".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $view
 * @property int $content_image_id
 *
 * @property ContentImage $contentImage
 */
class BaseContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['view', 'content_image_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['content_image_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContentImage::className(), 'targetAttribute' => ['content_image_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'view' => 'View',
            'content_image_id' => 'Content Image ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentImage()
    {
        return $this->hasOne(ContentImage::className(), ['id' => 'content_image_id']);
    }

    /**
     * {@inheritdoc}
     * @return ContentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ContentQuery(get_called_class());
    }
}
