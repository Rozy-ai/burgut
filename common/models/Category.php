<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_category}}".
 *
 * @property integer $id
 * @property string $alias
 * @property string $meta_description
 * @property string $meta_keyword
 * @property string $description
 * @property string $name
 * @property string $url_prefix
 * @property integer $related_category_id
 * @property integer $parent_id
 * @property string $code
 * @property integer $top
 * @property integer $sort_order
 * @property integer $status
 * @property string $date_created
 * @property string $date_modified
 * @property string $edited_username
 * @property string $create_username
 */
class Category extends CommonActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['related_category_id', 'parent_id', 'top', 'sort_order', 'status'], 'integer'],
            [['status'], 'required'],
            [['date_created', 'date_modified'], 'safe'],
            [['alias', 'meta_description', 'meta_keyword', 'description', 'name', 'url_prefix', 'code', 'edited_username', 'create_username'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'alias' => Yii::t('app', 'Alias'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'meta_keyword' => Yii::t('app', 'Meta Keyword'),
            'description' => Yii::t('app', 'Description'),
            'name' => Yii::t('app', 'Name'),
            'url_prefix' => Yii::t('app', 'Url Prefix'),
            'related_category_id' => Yii::t('app', 'Related Category ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'code' => Yii::t('app', 'Code'),
            'top' => Yii::t('app', 'Top'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'status' => Yii::t('app', 'Status'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_modified' => Yii::t('app', 'Date Modified'),
            'edited_username' => Yii::t('app', 'Edited Username'),
            'create_username' => Yii::t('app', 'Create Username'),
        ];
    }
}
