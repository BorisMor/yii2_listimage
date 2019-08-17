<?php

namespace common\models\base;

use Yii;
use common\models\Content;

/**
 * This is the model class for table "content_image".
 *
 * @property int $id
 * @property string $base_name
 * @property string $extension
 * @property int $size
 * @property string $type
 *
 * @property Content[] $contents
 */
class BaseContentImage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['base_name'], 'required'],
            [['size'], 'integer'],
            [['base_name', 'extension', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'base_name' => 'Base Name',
            'extension' => 'Extension',
            'size' => 'Size',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContents()
    {
        return $this->hasMany(Content::className(), ['content_image_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ContentImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ContentImageQuery(get_called_class());
    }
}
