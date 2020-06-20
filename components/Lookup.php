<?php

namespace daxslab\website\components;

use daxslab\website\models\ActiveRecord;
use daxslab\website\models\Page;
use yii\helpers\Html;
use Yii;
use yii\helpers\Inflector;
use yii\helpers\Url;

class Lookup
{
    public static function getPostStatusOptions()
    {
        return [
            Page::STATUS_POST_DRAFT => Yii::t('website', 'Draft'),
            Page::STATUS_POST_PUBLISHED => Yii::t('website', 'Published'),
        ];
    }

    public static function getBreadcrumbsForPage(Page $model, $frontend = false)
    {
        $items = [];
        $current = $model;

        while ($current) {
            $items[] = [
                'label' => Html::encode($current->title),
                'url' => $frontend
                    ? $current->url
                    : ['page/update', 'id' => $current->id],
            ];
            $current = $current->parent;
        }

        if(!$frontend) {
            $items[] = [
                'label' => Yii::t('website', 'Pages'),
                'url' => ['page/index'],
            ];
        }

        $items[0] = $model->isNewRecord
            ? Yii::t('website', 'New Page')
            : Html::encode($model->title);

        return array_reverse($items);
    }

    public static function getLink(ActiveRecord $model, $type, $otherParams = [])
    {
        $controllerId = Inflector::camel2id(array_reverse(explode('\\', get_class($model)))[0]);
        $params = ["{$controllerId}/{$type}"];
        if (in_array($type, ['view', 'update', 'delete'])) {
            $params['id'] = $model->id;
        }
        $params = array_merge($params, $otherParams);
        return Url::toRoute($params);
    }
}
