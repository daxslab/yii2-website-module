<?php

namespace daxslab\website\behaviors;


use backend\models\Page;
use yii\helpers\Inflector;

class SluggableBehavior extends \yii\behaviors\SluggableBehavior
{
    protected function getValue($event)
    {
        $slugs = [Inflector::slug($this->owner->{$this->attribute})];
        if($this->owner->parent){
            $slugs[] = $this->owner->parent->slug;
        }

        return implode('/', array_reverse($slugs));
    }

    protected function validateSlug($slug)
    {
        $usedSlugs = Page::find()->where([
            'website_id' => $this->owner->website_id,
            'language' => $this->owner->language,
        ])->select('slug')->column();

        return !in_array($slug, $usedSlugs);
    }
}
