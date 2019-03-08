<?php

namespace daxslab\website\models;

use backend\components\Lookup;
use Yii;
use yii2tech\ar\position\PositionBehavior;
use yii\db\Exception;
use yii\helpers\Url;

/**
 * This is the model class for table "menu_item".
 *
 * @property integer $id
 * @property integer $menu_id
 * @property string $language
 * @property string $label
 * @property string $url
 * @property integer $position
 *
 * @property Menu $menu
 */
class MenuItem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'language', 'label', 'url'], 'required'],
            [['menu_id'], 'integer'],
            [['language', 'label', 'url'], 'string', 'max' => 255],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::class, 'targetAttribute' => ['menu_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        $localBehaviors = [
            [
                'class' => PositionBehavior::class,
                'positionAttribute' => 'position',
                'groupAttributes' => [
                    'menu_id',
                    'language',
                ],
            ],
        ];
        return array_merge(parent::behaviors(), $localBehaviors);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('website','ID'),
            'menu_id' => Yii::t('website','Menu ID'),
            'language' => Yii::t('website','Language'),
            'label' => Yii::t('website','Label'),
            'url' => Yii::t('website','URL'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::class, ['id' => 'menu_id'])->inverseOf('menuItems');
    }

    public function getIsLastItem()
    {
        if ($this->position == $this->menu->getMenuItems()->count() - 1) {
            return true;
        }
        return false;
    }

    public function goUp()
    {

        if ($this->position == 0) {
            return true;
        }

        $previousItem = $this->menu->getMenuItems()->where([
            'position' => $this->position - 1,
            'language' => $this->language,
        ])->one();

        $previousItem->position = $this->position;
        $this->position--;

        try {
            return $previousItem->save() AND $this->save();
        } catch (Exception $e) {
            return false;
        }

    }

    public function goDown()
    {

        if ($this->isLastItem) {
            return true;
        }

        $nextItem = $this->menu->getMenuItems()->where([
            'position' => $this->position + 1,
            'language' => $this->language,
        ])->one();

        $nextItem->position = $this->position;
        $this->position++;

        try {
            return $nextItem->save() AND $this->save();
        } catch (Exception $e) {
            return false;
        }

    }

    public function afterDelete()
    {
        parent::afterDelete();
        self::updateAllCounters(['position' => -1], 'menu_id = :menu_id AND language = :language AND position > :position', [
            'menu_id' => $this->menu_id,
            'language' => $this->language,
            'position' => $this->position,
        ]);
    }

    public function fields()
    {
        return [
            'label',
            'url',
            'position',
        ];
    }

    public function getExportData()
    {
        $data = $this->attributes;

        unset($data['id']);
        unset($data['menu_id']);

        return $data;
    }

    /**
     * @inheritdoc
     * @return MenuItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MenuItemQuery(get_called_class());
    }
}
