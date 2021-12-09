<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_item}}".
 *
 * @property int $id
 * @property string $alias
 * @property int $category_id
 * @property int $parent_category_id
 * @property int $visited_count
 * @property int $sort_order
 * @property int $status
 * @property int $is_main
 * @property int $is_menu
 * @property int $type
 * @property string $author
 * @property string $location
 * @property string $edited_username
 * @property string $create_username
 * @property string $date_created
 * @property string $date_modified
 *
 * @property TblItemLang[] $tblItemLangs
 */
class Item extends CommonActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbl_item}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'parent_category_id', 'visited_count', 'sort_order', 'status', 'is_main', 'is_menu', 'type'], 'integer'],
            [['status', 'type'], 'required'],
            [['date_created', 'date_modified'], 'safe'],
            [['alias', 'author', 'location', 'edited_username', 'create_username'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'alias' => Yii::t('app', 'Alias'),
            'category_id' => Yii::t('app', 'Category ID'),
            'parent_category_id' => Yii::t('app', 'Parent Category ID'),
            'visited_count' => Yii::t('app', 'Visited Count'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'status' => Yii::t('app', 'Status'),
            'is_main' => Yii::t('app', 'Is Main'),
            'is_menu' => Yii::t('app', 'Is Menu'),
            'type' => Yii::t('app', 'Type'),
            'author' => Yii::t('app', 'Author'),
            'location' => Yii::t('app', 'Location'),
            'edited_username' => Yii::t('app', 'Edited Username'),
            'create_username' => Yii::t('app', 'Create Username'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_modified' => Yii::t('app', 'Date Modified'),
        ];
    }

}
