<?php

namespace daxslab\website\controllers\console;

use daxslab\website\models\Website;
use yii\console\Controller;
use yii\helpers\Inflector;
use yii\validators\UrlValidator;

class WebsiteController extends Controller
{
    public function actionCreate($name, $url = null)
    {
        if (isset($url) && !filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException(Yii::t('website','$url is not valid'));
        }

        $model = new Website([
            'name' => $name,
            'url' => isset($url) ? $url : 'www.' . Inflector::slug($name) . '.com',
            'token' => Yii::$app->security->generateRandomString(),
        ]);
    }
}