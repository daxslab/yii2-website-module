<?php

namespace daxslab\website\models;

/**
 * This is the ActiveQuery class for [[Media]].
 *
 * @see Media
 */
class MediaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Media[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Media|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function byMimeType($mime_type)
    {
        $this->andWhere(['mime_type' => $mime_type]);
        return $this;
    }
}
