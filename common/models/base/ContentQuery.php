<?php

namespace common\models\base;

/**
 * This is the ActiveQuery class for [[BaseContent]].
 *
 * @see BaseContent
 */
class ContentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BaseContent[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BaseContent|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function last($limit = 6)
    {
        return $this->limit($limit)->orderBy('id desc')->all(null);
    }
}
