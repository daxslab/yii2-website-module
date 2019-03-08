<?php

namespace daxslab\website\models;

/**
 * This is the ActiveQuery class for [[MetadataDefinition]].
 *
 * @see MetadataDefinition
 */
class MetadataDefinitionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MetadataDefinition[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MetadataDefinition|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
