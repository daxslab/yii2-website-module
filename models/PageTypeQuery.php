<?php

namespace daxslab\website\models;

/**
 * This is the ActiveQuery class for [[PageType]].
 *
 * @see PageType
 */
class PageTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PageType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PageType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
