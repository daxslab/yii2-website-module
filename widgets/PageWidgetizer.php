<?php

namespace daxslab\website\widgets;


use yii\base\Exception;
use yii\base\Widget;
use DOMDocument;
use yii\helpers\HtmlPurifier;
use yii\helpers\Html;
use Yii;

class PageWidgetizer extends Widget
{

    public $body = null;

    private $_doc = null;
    private $_output = null;

    public function init()
    {
        $this->_doc = new DOMDocument('1.0', 'UTF-8');
        $this->_doc->xmlStandalone = false;
        $this->_doc->loadHTML('<div>'.utf8_decode($this->body).'</div>', LIBXML_NOERROR | LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $this->_output = $this->_doc->saveHTML();
        parent::init();
    }


    public function run()
    {
        $blocks = $this->_doc->getElementsByTagName('block');
        foreach($blocks as $node){
            try{
                $block = $this->node2Block($node);
            }catch (Exception $e){
                $block = Html::tag('div', $e->getMessage(), ['class' => 'alert alert-danger']);
            }

            $this->_output = str_replace($node->ownerDocument->saveHtml($node), $block, $this->_output);
        }

        return $this->_output;
    }

    protected function node2Block($node){

        $slug = $node->getAttribute('slug');
        $action = $node->getAttribute('action');

        if($slug == '' && $action == ''){
            throw new \ErrorException('"slug" or "action" must be set in block nodes');
        }

        $module = $this->view->context->module->id;
        $action = $action ?: "/$module/block/view";

        $params = [];
        foreach($node->attributes as $attribute){
            $params[$attribute->name] = $attribute->value;
        }

        unset($params['action']);

        try{
            $output = Yii::$app->runAction($action, ['params' => $params]);
        }catch(Exception $e){
            $output = Html::tag('div', $e->getMessage(), ['class' => 'alert alert-danger']);
        }

        return $output;
    }

    protected function node2Widget($node)
    {
        $className = $node->getAttribute('classname');
        if(!class_exists($className)){
            throw new \ErrorException('Component not supported');
        }

        $config = [
            'page' => $node->getAttribute('page'),
        ];

        foreach($node->attributes as $attribute){
            $config[$attribute->name] = $attribute->value;
        }

        unset($config['classname']);

        return $className::widget($config);
    }
}
