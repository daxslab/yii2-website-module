<?php

namespace daxslab\website\behaviors;


use backend\models\Page;
use yii\helpers\Inflector;

class SluggableBehavior extends \yii\behaviors\SluggableBehavior
{
    protected function getValue($event)
    {
        $slugs = [Inflector::slug($this->owner->{$this->attribute})];
        $current = $this->owner->parent;
        while ($current) {
            $slugs[] = $current->slug;
            $current = $current->parent;
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
