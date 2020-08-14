<?php

namespace daxslab\website\models;

use common\models\User;
//use backend\components\Lookup;
use Yii;
use daxslab\website\behaviors\SluggableBehavior;
use yii\db\ActiveQuery;
use yii\helpers\Url;
use yii2tech\ar\position\PositionBehavior;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property integer $website_id
 * @property integer $parent_id
 * @property integer $page_type_id
 * @property integer $status
 * @property string $title
 * @property string $slug
 * @property string $abstract
 * @property string $body
 * @property string $image
 * @property string $language
 * @property integer $position
 * @property string $url
 *
 * @property Page $parent
 * @property PageType $type
 * @property Page[] $pages
 * @property Website $website
 */
class Page extends ActiveRecord
{

    //post statuses
    const STATUS_POST_DRAFT = 0;
    const STATUS_POST_PUBLISHED = 1;

    private $_oldPageTypeId;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    public function __toString()
    {
        return $this->title;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'language', 'page_type_id'], 'required'],
            [['body'], 'string'],
            [['body'], 'cleanHtmlValidator'],
            [['title', 'slug', 'abstract', 'language'], 'string', 'max' => 1000],
            [['image', 'abstract', 'body'], 'default'],
            [['status'], 'integer'],
            [['status'], 'default', 'value' => self::STATUS_POST_DRAFT],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::class, 'targetAttribute' => ['parent_id' => 'id']],
            [['page_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PageType::class, 'targetAttribute' => ['page_type_id' => 'id']],
            [['website_id'], 'exist', 'skipOnError' => true, 'targetClass' => Website::class, 'targetAttribute' => ['website_id' => 'id']],
        ];
    }

    public function cleanHtmlValidator($attribute, $params)
    {
        $this->body = str_replace('"=""', "", $this->body);
    }

    public function behaviors()
    {
        $localBehaviors = [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'ensureUnique' => true,
            ],
            [
                'class' => PositionBehavior::class,
                'positionAttribute' => 'position',
                'groupAttributes' => [
                    'website_id',
                    'parent_id',
                    'language',
                ],
            ],
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
            'parent_id' => Yii::t('website','Parent ID'),
            'page_type_id' => Yii::t('website','Page Type'),
            'status' => Yii::t('website','Status'),
            'title' => Yii::t('website','Title'),
            'slug' => Yii::t('website','Slug'),
            'abstract' => Yii::t('website','Abstract'),
            'body' => Yii::t('website','Body'),
            'image' => Yii::t('website','Page Poster'),
            'language' => Yii::t('website','Language'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMetadatas()
    {
        return $this->hasMany(Metadata::className(), ['page_id' => 'id']);
    }

    public function getMetadata($name){
        $metadata = $this->getMetadatas()->byName($name)->one();
        return isset($metadata) ? $metadata->value : null;
    }

    /**
     * @return ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Page::class, ['id' => 'parent_id'])->inverseOf('pages');
    }

    /**
     * @return ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(PageType::class, ['id' => 'page_type_id'])->inverseOf('pages');
    }

    /**
     * @return ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::class, ['parent_id' => 'id'])->inverseOf('parent');
    }

    /**
     * @return ActiveQuery
     */
    public function getWebsite()
    {
        return $this->hasOne(Website::class, ['id' => 'website_id'])->inverseOf('pages');
    }

    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'created_by'])->inverseOf('createdPages');
    }

    public function getEditor()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by'])->inverseOf('updatedPages');
    }

    public function getIsPost()
    {
        return true;
    }

    public function fields()
    {
        return [
            'title',
            'slug',
            'abstract',
            'body',
            'language',
            'image',
            'parent_slug' => function ($model) {
                return $model->parent ? $model->parent->slug : null;
            },
            'mime_type' => function ($model) {
                return $model->type->name;
            },
            'created_at',
            'updated_at',
        ];
    }

    public function getExportData()
    {
        $data = $this->attributes;
        $data['pages'] = array_map(function ($item) {
            return $item->exportData;
        }, $this->pages);

        unset($data['id']);
        unset($data['website_id']);
        unset($data['parent_id']);

        return $data;
    }

    public function getMenuItem()
    {

        $items = array_map(function ($child) {
            return $child->menuItem;
        }, $this->pages);

        return [
            'label' => $this->title,
            'url' => $this->url,
            'items' => $items,
            'linkOptions' => ['target' => '_blank']
        ];
    }

    public function getUrl()
    {
        return "{$this->website->url}/{$this->language}/{$this->slug}";
    }

    public function afterFind()
    {
        $this->_oldPageTypeId = $this->page_type_id;
        parent::afterFind(); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->_oldPageTypeId != $this->page_type_id) {
            Metadata::deleteAll(['page_id' => $this->id]);
            foreach ($this->type->metadataDefinitions as $mdd) {
                $md = new Metadata([
                    'page_id' => $this->id,
                    'metadata_definition_id' => $mdd->id,
                ]);
                $md->save();
            }
        }

        if(!$this->isAttributeChanged('title')){
            //fixes child pages slugs
            foreach($this->pages as $page){
                $title = $page->title;
                $page->markAttributeDirty('title');
                $page->save();
            }
        }

        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    /**
     * @inheritdoc
     * @return PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }

}
