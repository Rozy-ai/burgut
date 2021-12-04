<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_location}}".
 *
 * @property int $id
 * @property string $alias
 * @property int $category_id
 * @property int $parent_category_id
 * @property int $parent_id
 * @property int $merchant_id
 * @property int $visited_count
 * @property int $sort_order
 * @property int $status
 * @property string $edited_username
 * @property string $create_username
 * @property string $date_created
 * @property string $date_modified
 */
class Location extends CommonActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%tbl_location}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['category_id', 'status'], 'required'],
            [['category_id', 'parent_category_id', 'parent_id', 'merchant_id', 'visited_count', 'sort_order', 'status'], 'integer'],
            [['date_created', 'date_modified'], 'safe'],
            [['alias', 'edited_username', 'create_username'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'alias' => Yii::t('app', 'Alias'),
            'category_id' => Yii::t('app', 'Category ID'),
            'parent_category_id' => Yii::t('app', 'Parent Category ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'merchant_id' => Yii::t('app', 'Merchant ID'),
            'visited_count' => Yii::t('app', 'Visited Count'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'status' => Yii::t('app', 'Status'),
            'edited_username' => Yii::t('app', 'Edited Username'),
            'create_username' => Yii::t('app', 'Create Username'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_modified' => Yii::t('app', 'Date Modified'),
        ];
    }
}
