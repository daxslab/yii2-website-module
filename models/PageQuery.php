<?php

namespace daxslab\website\models;

/**
 * This is the ActiveQuery class for [[Page]].
 *
 * @see Content
 */
class PageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Page[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Page|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function byStatus($status)
    {
        $this->andWhere(['status' => $status]);
        return $this;
    }

    public function byLanguage($language)
    {
        $this->andWhere(['language' => $language]);
        return $this;
    }

    public function bySlug($slug)
    {
        $this->andWhere(['slug' => $slug]);
        return $this->one();
    }

    public function byId($id)
    {
        $this->andWhere(['id' => $id]);
        return $this->one();
    }

    public function postBySlug($slug)
    {
        return $this->where([
            'slug' => $slug,
            'mime_type' => 'blog/post'
        ])->one();
    }

    public function isImage(){
        return $this->where(['LIKE', 'mime_type', 'image']);
    }

    public function isNotImage(){
        return $this
            ->andWhere(['NOT LIKE', 'mime_type', 'image'])
            ->andWhere(['NOT LIKE', 'mime_type', 'blog']);
    }

    public function roots(){
        return $this->where('parent_id IS NULL');
    }
}
