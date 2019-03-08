<?php

namespace daxslab\website\models;

/**
 * This is the ActiveQuery class for [[MenuItem]].
 *
 * @see MenuItem
 */
class MenuItemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return MenuItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MenuItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function byLanguage($language){
        return $this->andFilterWhere(['language' => $language]);
    }
}
