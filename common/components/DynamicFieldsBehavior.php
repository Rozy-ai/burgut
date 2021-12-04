<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 8/28/2019
 * Time: 4:52 PM
 */

namespace common\components;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\validators\Validator;


class DynamicFieldsBehavior extends Behavior
{
    /**
     * You can set custom model class. Default is short name of owner class.
     *
     * @var string
     */
    public $modelName;

    /**
     * Fields to store and load with your model. Example: ['address', 'is_client'].
     * @var array
     */
    public $fields = [];

    public $tableName = '{{%tbl_dynamic_fields}}';

    /**
     * @var array
     */
    private $_values = [];

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_BEFORE_DELETE => 'deleteModelValues',
        ];
    }

    public function canGetProperty($name, $checkVars = true)
    {
        return in_array($name, $this->fields);
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->_values)) {
            return $this->_values[$name];
        }
    }

    public function __set($name, $value)
    {
        if ($this->canSetProperty($name)) {
            $this->_values[$name] = $value;
        }
    }

    public function canSetProperty($name, $checkVars = true)
    {
        return in_array($name, $this->fields);
    }

    public function attach($owner)
    {
        /** @var ActiveRecord $owner */
        parent::attach($owner);

//        if (empty($this->languages) || !is_array($this->languages)) {
//            throw new InvalidConfigException('Please specify array of available languages for the ' . get_class($this) . ' in the '
//                . get_class($this->owner) . ' or in the application parameters', 101);
//        }
//
//        if (array_values($this->languages) !== $this->languages) { //associative array
//            $this->languages = array_keys($this->languages);
//        }
//
//        $this->languages = array_unique(array_map(function ($language) {
//            return $this->getLanguageBaseName($language);
//        }, $this->languages));
//
//        if (!$this->defaultLanguage) {
//            $this->defaultLanguage = isset(Yii::$app->params['defaultLanguage']) && Yii::$app->params['defaultLanguage'] ?
//                Yii::$app->params['defaultLanguage'] : Yii::$app->language;
//        }
//
//        $this->defaultLanguage = $this->getLanguageBaseName($this->defaultLanguage);
//
//        if (!$this->currentLanguage) {
//            $this->currentLanguage = $this->getLanguageBaseName(Yii::$app->language);
//        }
//
//        if (empty($this->attributes) || !is_array($this->attributes)) {
//            throw new InvalidConfigException('Please specify multilingual attributes for the ' . get_class($this) . ' in the '
//                . get_class($this->owner), 103);
//        }
//
//        if (!$this->langClassName) {
//            $this->langClassName = get_class($this->owner) . $this->langClassSuffix;
//        }
//
//        $this->langClassShortName = $this->getShortClassName($this->langClassName);
//        $this->ownerClassName = get_class($this->owner);
//        $this->ownerClassShortName = $this->getShortClassName($this->ownerClassName);
//
//        /** @var ActiveRecord $className */
//        $className = $this->ownerClassName;
//        $this->ownerPrimaryKey = $className::primaryKey()[0];
//
//        if (!isset($this->langForeignKey)) {
//            throw new InvalidConfigException('Please specify langForeignKey for the ' . get_class($this) . ' in the '
//                . get_class($this->owner), 105);
//        }

        $rules = $owner->rules();
        $validators = $owner->getValidators();

        foreach ($rules as $rule) {
            if (is_array($this->excludedValidators) && in_array($rule[1], $this->excludedValidators))
                continue;

            $rule_attributes = is_array($rule[0]) ? $rule[0] : [$rule[0]];
            $attributes = array_intersect($this->owner->attributes, $rule_attributes);
//
//            if (empty($attributes))
//                continue;

//            $rule_attributes = [];
            $rule_attributes = $this->fields;
//            foreach ($attributes as $key => $attribute) {
//                foreach ($this->languages as $language)
//                    if ($language != $this->defaultLanguage)
//                        $rule_attributes[] = $this->getAttributeName($attribute, $language);
//            }


            $params = array_slice($rule, 2);

//            if ($rule[1] !== 'required' || $this->requireTranslations) {
//                $validators[] = Validator::createValidator($rule[1], $owner, $rule_attributes, $params);
//            } elseif ($rule[1] === 'required') {
            if ($rule[1] === 'required') {
                $validators[] = Validator::createValidator('safe', $owner, $rule_attributes, $params);
            }
        }
//
//        if ($this->dynamicLangClass) {
//            $this->createLangClass();
//        }
//
//        $translation = new $this->langClassName;
//        foreach ($this->languages as $lang) {
//            foreach ($this->attributes as $attribute) {
//                $attributeName = $this->localizedPrefix . $attribute;
//                $this->setLangAttribute($this->getAttributeName($attribute, $lang), $translation->{$attributeName});
//                if ($lang == $this->defaultLanguage) {
//                    $this->setLangAttribute($attribute, $translation->{$attributeName});
//                }
//            }
//        }
    }

//    public function safeAttributes($values, $safeOnly = true)
//    {
//        return \yii\helpers\ArrayHelper::merge($this->owner->safeAttributes($values, $safeOnly = true), [$this->fields]);
//    }

//
//    public function safeAttributes()
//    {
//        $scenario = $this->getScenario();
//        $scenarios = $this->scenarios();
//        if (!isset($scenarios[$scenario])) {
//            return [];
//        }
//        $attributes = [];
//        foreach ($scenarios[$scenario] as $attribute) {
//            if ($attribute[0] !== '!' && !in_array('!' . $attribute, $scenarios[$scenario])) {
//                $attributes[] = $attribute;
//            }
//        }
//
//        return $attributes;
//    }


    public function afterFind($event)
    {
        $this->fields = $this->owner->getDynamicFieldNames();

        /* Load fields values */
        $query = (new Query())
            ->select(['field', 'value'])
            ->from($this->tableName)
            ->where(['model' => $this->getModelClass(), 'model_id' => $this->getPrimaryKey()]);
//        $model_dynamic_fields = ArrayHelper::map($query->all(), 'field', 'value');
        foreach (ArrayHelper::map($query->all(), 'field', 'value') as $field => $value) {
            if (in_array($field, $this->fields)) {
                $this->owner->$field = $value;
                if (substr($field,-3) === '_'.yii::$app->language){
                    $var = substr($field,0,-3);
                    $this->owner->$var = $value;
                }
            }
        }

//        echo "AfterFind";
//        print_r($dynamic_fields);
//        print_r($category_dynamic_fields);
//        exit(1);

//        $test_field = 'test_field';
//        $this->owner->$test_field = '';
    }

    protected function getModelClass()
    {
//        var_dump($this->getPrimaryKey());die;
        return $this->modelName ?: (new \ReflectionClass($this->owner))->getShortName();
    }

    protected function getPrimaryKey()
    {
        return $this->owner->getPrimaryKey();
    }

    public function afterSave($event)
    {
        /* Save fields values in separate table */
        $this->deleteModelValues();

        $data = [];

//        echo "<pre>";
//        print_r($this->owner->getAttribute('test_field'));
//        echo "</pre>";

        foreach ($this->fields as $field) {
//            echo "<pre>";
//            print_r($this->owner->$field);
//            echo "</pre>";

            $data[] = [
                $this->getModelClass(),
                $this->getPrimaryKey(),
                $field,
                $this->owner->$field,
            ];
        }

//        exit(1);
        Yii::$app->db->createCommand()->batchInsert($this->tableName, ['model', 'model_id', 'field', 'value'], $data)->execute();
    }

    public function deleteModelValues()
    {
        Yii::$app->db->createCommand()->delete($this->tableName, ['model' => $this->getModelClass(), 'model_id' => $this->getPrimaryKey()])->execute();
    }
}