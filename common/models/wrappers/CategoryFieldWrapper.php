<?php

namespace common\models\wrappers;

use arogachev\ManyToMany\behaviors\ManyToManyBehavior;
use common\models\Album;
use common\models\CategoryField;
use common\models\CategoryFieldLang;
use common\models\CategoryLang;
use common\models\Item;
use common\models\Category;
use common\models\Music;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\helpers\Url;

class CategoryFieldWrapper extends CategoryField
{

    public function rules()
    {
        return \yii\helpers\ArrayHelper::merge(parent::rules(), [
            [['field_description'], 'required'],
            [['field_description'], 'string'],
            [['field_description'], 'safe'],
        ]);
    }

    public function behaviors()
    {
        return [
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => Yii::$app->urlManager->languages,
                'langClassName' => CategoryFieldLang::className(), // or namespace/for/a/class/PostLang
                'defaultLanguage' => Yii::$app->language,
                'langForeignKey' => 'category_field_id',
                'tableName' => "{{%tbl_category_field_lang}}",
                'attributes' => [
                    'field_description'
                ]
            ]
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(CategoryWrapper::className(), ['id' => 'category_id']);
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    public function getTranslations()
    {
        return $this->hasMany(CategoryFieldLang::className(), ['category_field_id' => 'id']);
    }
}
