<?php

namespace common\models\base;

/**
 * This is the ActiveQuery class for [[BaseContentImage]].
 *
 * @see BaseContentImage
 */
class ContentImageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BaseContentImage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BaseContentImage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
