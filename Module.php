<?php

namespace daxslab\website;

use daxslab\behaviors\UploaderBehavior;
use daxslab\thumbnailer\Thumbnailer;
use daxslab\website\models\Website;
use Yii;
use yii\base\Module as BaseModule;
use yii\console\Application;
use yii\helpers\Url;
use yii\httpclient\Client;
use yii\web\NotFoundHttpException;
use yii\base\InvalidArgumentException;
use yii\i18n\PhpMessageSource;

/**
 * Class Module
 * @package daxslab\website
 */
class Module extends BaseModule
{

    public $token;

    public $defaultRoute = 'page';

    public $languages = [];

    public $cacheThumbnails = false;

    public $renamer = UploaderBehavior::RENAME_RANDOM;

    public $urlRules = [
        '<_lang:[\w-]+>' => 'page/home',
        '<_lang:[\w-]+>/<slug:[\w/-]+>' => 'page/view',
    ];

    public function init()
    {
        parent::init();
    }

    public function getMenuItems()
    {
        return [
            [
                'label' => Yii::t('website', 'Pages'),
                'url' => ["/{$this->id}/page/index"],
            ],
            [
                'label' => Yii::t('website', 'Media'),
                'url' => ["/{$this->id}/media/index"],
            ],
            [
                'label' => Yii::t('website', 'Menus'),
                'url' => ["/{$this->id}/menu/index"],
            ],
            [
                'label' => Yii::t('website', 'Settings'),
                'url' => ["/{$this->id}/website/update"],
            ]
        ];
    }

}
