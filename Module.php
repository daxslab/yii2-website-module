<?php

namespace daxslab\website;

use daxslab\thumbnailer\Thumbnailer;
use daxslab\website\models\Website;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\Module as BaseModule;
use yii\helpers\Url;
use yii\httpclient\Client;
use yii\web\NotFoundHttpException;
use yii\base\InvalidArgumentException;
use yii\i18n\PhpMessageSource;

/**
 * Class Module
 * @package daxslab\website
 */
class Module extends BaseModule implements BootstrapInterface
{

    public $token;

    public $defaultRoute = 'page';

    public $languages = [];

    public $cacheThumbnails = false;

    public $urlRules = [
        '<_lang:[\w-]+>' => 'page/home',
        '<_lang:[\w-]+>/<slug:[\w-/]+>' => 'page/view',
    ];

    public function bootstrap($app)
    {
        if(empty($this->languages)){
            $this->languages = [Yii::$app->language];
        }

        $configUrlRule = [
            'routePrefix' => 'website',
            'rules' => $this->urlRules,
        ];

        $configUrlRule['class'] = 'yii\web\GroupUrlRule';
        $rule = Yii::createObject($configUrlRule);

        $app->urlManager->addRules([$rule], false);

    }

    public function init()
    {
        if (!isset($this->token)) {
            throw new InvalidArgumentException(Yii::t('website',"The token must be set"));
        }

        $website = Website::find()->byToken($this->token);

        if ($website == null) {
            throw new InvalidArgumentException(Yii::t('website',"The token is invalid"));
        }

        $app = Yii::$app;

        $app->set('website', $website);

        if (!$app->has('thumbnailer')) {
            $app->set('thumbnailer', [
                'class' => Thumbnailer::class,
                'thumbnailsPath' => '@webroot/assets/thumbnails',
                'thumbnailsBaseUrl' => '@web/assets/thumbnails',
                'enableCaching' => $this->cacheThumbnails,
            ]);
        }

        if (!isset($app->get('i18n')->translations['website*'])) {
            $app->get('i18n')->translations['website*'] = [
                'class' => PhpMessageSource::className(),
                'basePath' => __DIR__ . '/messages',
                'sourceLanguage' => 'en-US'
            ];
        }

        if (strstr($this->controllerNamespace, 'backend')) {
            $this->viewPath = '@daxslab/website/views/backend';
            WebsiteAsset::register(Yii::$app->view);
        } else {
            $this->viewPath = $this->viewPath == Yii::getAlias('@daxslab/website/views')
                ? '@daxslab/website/views/frontend'
                : $this->viewPath;
        }

        parent::init();

    }

    public function getMenuItems()
    {
        return [
            [
                'label' => Yii::t('website','Pages'),
                'url' => ["/{$this->id}/page/index"],
            ],
            [
                'label' => Yii::t('website','Media'),
                'url' => ["/{$this->id}/media/index"],
            ],
            [
                'label' => Yii::t('website','Menus'),
                'url' => ["/{$this->id}/menu/index"],
            ],
            [
                'label' => Yii::t('website','Settings'),
                'url' => ["/{$this->id}/website/update"],
            ]
        ];
    }

}
