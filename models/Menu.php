<?php

namespace daxslab\website\models;

use backend\components\Lookup;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property integer $website_id
 * @property string $name
 * @property string $slug
 *
 * @property Website $website
 * @property MenuItem[] $menuItems
 */
class Menu extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['website_id', 'name'], 'required'],
            [['website_id'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['website_id'], 'exist', 'skipOnError' => true, 'targetClass' => Website::class, 'targetAttribute' => ['website_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        $localBehaviors = [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
            ]
        ];

        return array_merge($localBehaviors, parent::behaviors());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('website','ID'),
            'website_id' => Yii::t('website','Website ID'),
            'name' => Yii::t('website','Name'),
            'slug' => Yii::t('website','Slug'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebsite()
    {
        return $this->hasOne(Website::class, ['id' => 'website_id'])->inverseOf('menus');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItems($language = null)
    {
        return $this->hasMany(MenuItem::class, ['menu_id' => 'id'])
            ->orderBy('position')
            ->byLanguage($language)
            ->inverseOf('menu');
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $output = [];
        foreach($this->website->translationsCodes as $code){
            $output[$code] = $this->getMenuItems()->orderBy('position')->where(['language' => $code])->all();
        }
        return $output;
    }

    public function getExportData(){
        $data = $this->attributes;
        $data['items'] = array_map(function($item){
            return $item->exportData;
        }, $this->menuItems);

        unset($data['id']);
        unset($data['website_id']);

        return $data;
    }

    /**
     * @inheritdoc
     * @return MenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MenuQuery(get_called_class());
    }
}
