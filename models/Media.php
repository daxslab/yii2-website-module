<?php

namespace daxslab\website\models;

use Yii;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\web\UploadedFile;
use daxslab\behaviors\UploaderBehavior;

/**
 * This is the model class for table "media".
 *
 * @property int $id
 * @property int $website_id
 * @property string $mime_type
 * @property string $filename
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property string $url
 * @property string $path
 * @property string $prettyName
 * @property string $prettyIcon
 * @property boolean $isImage
 *
 * @property Website $website
 */
class Media extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['filename'], 'file', 'skipOnEmpty' => true],
            [['website_id'], 'required'],
            [['website_id'], 'integer'],
            [['website_id'], 'exist', 'skipOnError' => true, 'targetClass' => Website::className(), 'targetAttribute' => ['website_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        $localBehaviors = [
            [
                'class' => UploaderBehavior::class,
                'uploadPath' => '@uploads',
            ],
        ];
        return array_merge(parent::behaviors(), $localBehaviors);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('website','ID'),
            'website_id' => Yii::t('website','Website ID'),
            'mime_type' => Yii::t('website','Mime Type'),
            'filename' => Yii::t('website','Filename'),
        ];
    }

    public function getLinks($type)
    {
        $links = [
            //common
//            Lookup::ACTION_VIEW => Url::toRoute(['/content/view', 'id' => $this->id, 'website_id' => $this->website_id]),
//            Lookup::ACTION_UPDATE => Url::toRoute(['/website/manage-media', 'website_id' => $this->website_id, 'action' => 'update', 'post_id' => $this->id]),
//            Lookup::ACTION_DELETE => Url::toRoute(['/media/delete', 'id' => $this->id, 'website_id' => $this->website_id]),
            //media
//            Lookup::ACTION_DOWNLOAD => Url::toRoute(['/media/download', 'id' => $this->id, 'website_id' => $this->website_id]),
        ];
        return $links[$type];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebsite()
    {
        return $this->hasOne(Website::class, ['id' => 'website_id']);
    }

    public function getUrl()
    {
        $websiteUrl = $this->website->url;
        return "{$websiteUrl}/uploads/{$this->filename}";
    }

    public function getPath()
    {
        return Yii::getAlias("@uploads/{$this->filename}");
    }

    public function getPrettyName()
    {
        return Inflector::slug($this->filename) . '.' . pathinfo($this->filePath, PATHINFO_EXTENSION);
    }

    public function getPrettyIcon()
    {
        $icon = str_replace('/', '-', $this->mime_type);
        return Yii::getAlias("@web/images/mime_types/{$icon}.svg");
    }

    public function getIsImage()
    {
        return strstr($this->mime_type, 'image') != false;
    }

    public function getSize()
    {
        if (file_exists($this->path)) {
            return filesize($this->path);
        }
    }

    public function beforeSave($insert)
    {
        if ($this->filename instanceof UploadedFile) {
            $this->mime_type = $this->filename->type;
        }
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     * @return MediaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MediaQuery(get_called_class());
    }
}
