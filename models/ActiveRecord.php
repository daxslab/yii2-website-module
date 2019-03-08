<?php

namespace daxslab\website\models;

use kartik\date\DatePicker;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use daxslab\behaviors\UploaderBehavior;
use yii\db\Expression;
use yii\helpers\Html;
use yii\helpers\Inflector;

class ActiveRecord extends \yii\db\ActiveRecord
{

    public $labelAttribute = 'name';

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::class,
                'defaultValue' => 1
            ],
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public static function getVisibleColumns($searchModel = null, $pjaxContainer)
    {
        return [
        ];
    }

    public function updateStamps()
    {
        $this->touch('updated_at');
        $this->updated_by = Yii::$app->user->id;
        $this->save();
    }

}