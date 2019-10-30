<?php

namespace daxslab\website\commands;

use Da\User\Model\User;
use daxslab\website\models\Website;
use yii\console\Controller;
use yii\helpers\Console;
use yii\helpers\Inflector;
use yii\validators\UrlValidator;
use Yii;

class CreateController extends Controller
{
    public function actionIndex($url)
    {
        if (isset($url) && !filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException(Yii::t('website', '$url is not valid'));
        }

        $model = new Website([
            'url' => $url,
            'token' => Yii::$app->security->generateRandomString(),
        ]);

        if ($model->save()) {
            $this->stdout(Yii::t('website', 'Website has been created. Use {token} as token!', [
                    'token' => $model->token
                ]) . "\n", Console::FG_GREEN);
        } else {
            $this->stdout(Yii::t('website', 'Please fix following errors:') . "\n", Console::FG_RED);
            foreach ($model->errors as $errors) {
                foreach ($errors as $error) {
                    $this->stdout(' - ' . $error . "\n", Console::FG_RED);
                }
            }
        }
    }
}
