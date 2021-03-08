<?php

namespace daxslab\website\models;

use Yii;
use yii\validators\Validator;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "metadata".
 *
 * @property int $id
 * @property string $value
 * @property int $page_id
 * @property int $metadata_definition_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property MetadataDefinition $metadataDefinition
 * @property Page $page
 */
class Metadata extends \daxslab\website\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'metadata';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'customValidator'],
            [['page_id', 'metadata_definition_id'], 'required'],
            [['page_id', 'metadata_definition_id'], 'integer'],
            [['metadata_definition_id'], 'exist', 'skipOnError' => true, 'targetClass' => MetadataDefinition::className(), 'targetAttribute' => ['metadata_definition_id' => 'id']],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
        ];
    }

    public function customValidator($attribute, $params)
    {
        $validator = Yii::createObject($this->metadataDefinition->type, []);
        $validator->validateAttribute($this, 'value');
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('website', 'ID'),
            'value' => $this->metadataDefinition->name,
            'page_id' => Yii::t('website', 'Page ID'),
            'metadata_definition_id' => Yii::t('website', 'Metadata Definition ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMetadataDefinition()
    {
        return $this->hasOne(MetadataDefinition::className(), ['id' => 'metadata_definition_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    public function fields()
    {
        return [
            'name' => function () {
                return $this->metadataDefinition->name;
            },
            'value'
        ];
    }

    /**
     * {@inheritdoc}
     * @return MetadataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MetadataQuery(get_called_class());
    }
}
