<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace daxslab\website;

use daxslab\thumbnailer\Thumbnailer;
use daxslab\website\models\Website;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\InvalidArgumentException;
use yii\i18n\PhpMessageSource;

/**
 * Bootstrap class of the yii2-usuario extension. Configures container services, initializes translations,
 * builds class map, and does the other setup actions participating in the application bootstrap process.
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws InvalidConfigException
     */
    public function bootstrap($app)
    {
        if ($app->hasModule('website') && $app->getModule('website') instanceof Module) {

            $module = $app->getModule('website');

            if (!isset($app->get('i18n')->translations['website*'])) {
                $app->get('i18n')->translations['website*'] = [
                    'class' => PhpMessageSource::className(),
                    'basePath' => __DIR__ . '/messages',
                    'sourceLanguage' => 'en-US'
                ];
            }

            if($app instanceof \yii\web\Application){

                if(empty($module->languages)){
                    $module->languages = [$app->language];
                }

//                $configUrlRule = [
//                    'routePrefix' => 'website',
//                    'rules' => $module->urlRules,
//                ];
//
//                $configUrlRule['class'] = 'yii\web\GroupUrlRule';
//                $rule = Yii::createObject($configUrlRule);
//
//                $app->urlManager->addRules([$rule], false);

                if (!$app->has('thumbnailer')) {
                    $app->set('thumbnailer', [
                        'class' => Thumbnailer::class,
                        'thumbnailsPath' => '@webroot/assets/thumbnails',
                        'thumbnailsBaseUrl' => '@web/assets/thumbnails',
                        'enableCaching' => $module->cacheThumbnails,
                    ]);
                }

                if (!isset($module->token)) {
                    throw new InvalidArgumentException(Yii::t('website',"The token must be set"));
                }

                $website = Website::find()->byToken($module->token);

                if ($website == null) {
                    throw new InvalidArgumentException(Yii::t('website',"The token is invalid"));
                }

                $app->set('website', $website);

                if (strstr($module->controllerNamespace, 'backend')) {
                    $module->viewPath = '@daxslab/website/views/backend';
                    WebsiteAsset::register($app->view);
                } else {
                    $module->viewPath = $module->viewPath == Yii::getAlias('@daxslab/website/views')
                        ? '@daxslab/website/views/frontend'
                        : $module->viewPath;
                }
            }else{
                $module->controllerNamespace = 'daxslab\website\commands';
            }

        }
    }


}
