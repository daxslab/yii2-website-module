<?php

namespace daxslab\website;

use dosamigos\ckeditor\CKEditorAsset;
use yii\bootstrap4\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class WebsiteAsset extends AssetBundle
{
    public $sourcePath = '@daxslab/website/assets';
    public $css = [
        'css/backend.css',
    ];
    public $js = [
        'js/ckeditor/imagebrowser/plugin.js',
        'js/ckeditor/showprotected/plugin.js',
        'js/jquery.fn.sortable.js',
        'js/backend.js',
    ];
    public $depends = [
        BootstrapAsset::class,
        JqueryAsset::class,
        CKEditorAsset::class,
    ];
}
