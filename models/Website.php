<?php

namespace daxslab\website\models;

use common\models\User;
use Yii;
use yii\base\Exception;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\helpers\Url;

/**
 * This is the model class for table "website".
 *
 * @property integer $id
 * @property string $token
 * @property string $url
 *
 * @property User[] $users
 * @property mixed exportData
 */
class Website extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'website';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['url'], 'url'],
        ];
    }

    public function behaviors()
    {
        return [
            BlameableBehavior::class,
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('website', 'ID'),
            'token' => Yii::t('website', 'Token'),
        ];
    }

    public function getFirstLevelPages($language = null)
    {
        return $this->hasMany(Page::class, ['website_id' => 'id'])
            ->andWhere('parent_id IS NULL')
            ->andFilterWhere(['language' => $language]);
    }

    /**
     * @return ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::class, ['website_id' => 'id'])->inverseOf('website');
    }

    public function getMenu($slug)
    {
        return $this->getMenus()->bySlug($slug);
    }

    /**
     * @param $slug
     * @param $language
     * @return null|Page
     */
    public function getPage($slug, $language = null)
    {
        $language = $language ?: Yii::$app->language;
        return $this->getPages()->where([
            'language' => $language,
            'slug' => $slug
        ])->one();
    }

    /**
     * @return ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::class, ['website_id' => 'id'])
            ->inverseOf('website');
    }

    public function getRootPages()
    {
        return $this->getPages()->roots();
    }

    /**
     * @return ActiveQuery
     */
    public function getPageTypes()
    {
        return $this->hasMany(PageType::class, ['website_id' => 'id'])
            ->inverseOf('website');
    }

    /**
     * @return ActiveQuery
     */
    public function getMedias()
    {
        return $this->hasMany(Media::class, ['website_id' => 'id'])
            ->inverseOf('website');
    }

    /**
     * @return ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Media::class, ['website_id' => 'id'])
            ->andWhere(['LIKE', 'mime_type', 'image'])
            ->inverseOf('website');
    }

    /**
     * @return ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('website_user', ['website_id' => 'id']);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     * @throws \yii\db\Exception
     */
    public function getNotAssignedUsers()
    {
        $notAssignedIds = Yii::$app->db->createCommand('SELECT user_id from website_user where website_id = :website_id', [
            'website_id' => $this->id,
        ])->queryColumn();

        return User::find()
            ->where(['NOT IN', 'id', $notAssignedIds])->orderBy('username')
            ->all();
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws Exception
     */
    public function beforeSave($insert)
    {
//        $this->token = Yii::$app->security->generateRandomString(64);
        return parent::beforeSave($insert);
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            {
                $types = [];
                $types[] = new PageType([
                    'name' => 'landing',
                    'website_id' => $this->id,
                ]);
                $types[] = new PageType([
                    'name' => 'page',
                    'website_id' => $this->id,
                ]);
                $types[] = new PageType([
                    'name' => 'list',
                    'website_id' => $this->id,
                ]);
                $types[] = new PageType([
                    'name' => 'gallery',
                    'website_id' => $this->id,
                ]);

                foreach ($types as $type) {
                    $type['created_at'] = $this->created_at;
                    $type['updated_at'] = $this->created_at;
                    $type->save();
                }
            }
        }
//
//        try {
//            $this->createWebsiteDir();
//        } catch (Exception $e) {
//            die(var_dump($e));
//        }

        return parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @throws \yii\base\ErrorException
     */
    public function afterDelete()
    {
//        $url = str_replace('https://', '', $this->url);
//        $url = str_replace('http://', '', $this->url);
//        $websitePath = Yii::getAlias("@webroot/../../websites/{$url}");
//        FileHelper::removeDirectory($websitePath);

        return parent::afterDelete(); // TODO: Change the autogenerated stub
    }

    /**
     * @inheritdoc
     * @return WebsiteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WebsiteQuery(get_called_class());
    }

    /**
     * @return array all the data belonging to the website
     */
    public function getExportData()
    {
        $data = $this->attributes;

        $data['translations'] = array_map(function ($item) {
            return $item->exportData;
        }, $this->translations);

        $data['media'] = array_map(function ($item) {
            return $item->exportData;
        }, $this->getMedias()->all());

        $data['menus'] = array_map(function ($item) {
            return $item->exportData;
        }, $this->menus);

        unset($data['id']);
        return $data;
    }

}
