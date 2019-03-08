<?php

namespace daxslab\website\models;

use Yii;
use yii\base\ErrorException;

/**
 * This is the model class for table "page_type".
 *
 * @property int $id
 * @property string $name
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $website_id
 *
 * @property Page[] $pages
 * @property Website $website
 */
class PageType extends ActiveRecord
{
    const TYPE_POST = 'post';
    const TYPE_HOME = 'home';
    const TYPE_GALLERY = 'gallery';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'website_id'], 'required'],
            [['website_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['website_id'], 'exist', 'skipOnError' => true, 'targetClass' => Website::className(), 'targetAttribute' => ['website_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('website','ID'),
            'name' => Yii::t('website','Name'),
            'created_at' => Yii::t('website','Created At'),
            'updated_at' => Yii::t('website','Updated At'),
            'created_by' => Yii::t('website','Created By'),
            'updated_by' => Yii::t('website','Updated By'),
            'website_id' => Yii::t('website','Website ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::class, ['page_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMetadataDefinitions()
    {
        return $this->hasMany(MetadataDefinition::className(), ['page_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebsite()
    {
        return $this->hasOne(Website::class, ['id' => 'website_id']);
    }

    public static function defaultPageTypes()
    {
        return ['home', 'post', 'gallery'];
    }

    public function getIsDefault(){
        return in_array($this->name, self::defaultPageTypes());
    }

    public function beforeDelete()
    {
        if (in_array($this->name, self::defaultPageTypes())) {
            throw new ErrorException(Yii::t('website',"You can't delete one of the default page types."));
        }

        return parent::beforeDelete();
    }

    /**
     * {@inheritdoc}
     * @return PageTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageTypeQuery(get_called_class());
    }
}
