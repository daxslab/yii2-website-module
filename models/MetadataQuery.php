<?php

namespace daxslab\website\models;

/**
 * This is the ActiveQuery class for [[Metadata]].
 *
 * @see Metadata
 */
class MetadataQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Metadata[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Metadata|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function byName($name){
        $this->joinWith('metadataDefinition');
        $this->where(['metadata_definition.name' => $name]);
        return $this;
    }
}
