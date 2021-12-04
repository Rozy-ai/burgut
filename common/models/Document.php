<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_document}}".
 *
 * @property int $id
 * @property string $filename
 * @property string $org_filename
 * @property string $size
 * @property string $path
 * @property string $cropped_path
 * @property string $type
 * @property int $video_document_id
 * @property string $code
 */
class Document extends CommonActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%tbl_document}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['filename'], 'required'],
            [['size'], 'number'],
            [['video_document_id'], 'integer'],
            [['filename', 'org_filename', 'path', 'cropped_path', 'type', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'filename' => Yii::t('app', 'Filename'),
            'org_filename' => Yii::t('app', 'Org Filename'),
            'size' => Yii::t('app', 'Size'),
            'path' => Yii::t('app', 'Path'),
            'cropped_path' => Yii::t('app', 'Cropped Path'),
            'type' => Yii::t('app', 'Type'),
            'video_document_id' => Yii::t('app', 'Video Document ID'),
            'code' => Yii::t('app', 'Code'),
        ];
    }
}
