<?php

namespace daxslab\website\commands;

use Da\User\Model\User;
use daxslab\website\models\Menu;
use daxslab\website\models\MenuItem;
use daxslab\website\models\Website;
use daxslab\website\models\Page;
use yii\console\Controller;
use yii\helpers\Console;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\validators\UrlValidator;
use Yii;

class CreateController extends Controller
{
    public function actionIndex($url, $type = null)
    {
        if (isset($url) && !filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException(Yii::t('website', '$url is not valid'));
        }

        $model = new Website([
            'url' => $url,
            'token' => Yii::$app->security->generateRandomString(),
        ]);

        if ($model->save()) {
            if ($type) {
                $type = ucfirst($type);
                $methodName = "generateContentFor{$type}";
                if (method_exists($this, $methodName)) {
                    $this->$methodName($model);
                }
            }
            $this->stdout(Yii::t('website', 'Website has been created. Use "{token}" as token!', [
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

    protected function generateContentForBasic(Website $website)
    {
        $menu = new Menu([
            'name' => 'main',
            'website_id' => $website->id,
        ]);
        if ($menu->save()) {
            foreach (Yii::$app->getModule('website')->languages as $language) {
                $pages = [
                    ['title' => 'Home', 'type' => 1, 'language' => $language],
                    ['title' => 'About', 'type' => 2, 'language' => $language],
                    ['title' => 'Services', 'type' => 3, 'language' => $language, 'pages' => [
                        ['title' => 'Service 1', 'type' => 2, 'language' => $language],
                        ['title' => 'Service 2', 'type' => 2, 'language' => $language],
                        ['title' => 'Service 3', 'type' => 2, 'language' => $language],
                    ]],
                ];
                foreach ($pages as $page) {
                    $this->generatePage($page, $website);
                }
            }
            foreach ($website->rootPages as $page) {
                $menuItem = new MenuItem([
                    'label' => $page->title,
                    'url' => $page->url,
                    'language' => $page->language,
                    'menu_id' => $menu->id,
                ]);
                $menuItem->save();
            }
        }
    }

    protected function generatePage(array $data, Website $website, Page $parent = null)
    {
        $page = new Page([
            'title' => $data['title'],
            'abstract' => Yii::t('website', 'Abstract for {title}', [
                'title' => $data['title'],
            ], $data['language']),
            'body' => Html::tag('p', Yii::t('website', 'Content for {title}.', [
                    'title' => $data['title'],
                ], $data['language']) . " Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aliquid atque blanditiis commodi cumque et eveniet fugit id laudantium molestiae nam nesciunt odit quos reprehenderit similique sint veritatis vero, vitae?"),
            'website_id' => $website->id,
            'parent_id' => isset($parent) ? $parent->id : null,
            'page_type_id' => $data['type'],
            'language' => $data['language'],
            'status' => Page::STATUS_POST_PUBLISHED,
        ]);
        if ($page->save()) {
            $this->stdout(Yii::t('website', 'Page {title} has been created.', [
                    'title' => $page->title,
                ]) . "\n", Console::FG_GREEN);

            if (isset($data['pages'])) {
                foreach ($data['pages'] as $subpage) {
                    $this->generatePage($subpage, $website, $page);
                }
            }
        } else {
            $this->stdout(Yii::t('website', 'Page {title} hasn\'t been created.', [
                    'title' => $page->title,
                ]) . "\n", Console::FG_RED);
            var_dump($model->errors);
        }

    }

}
