<?php
/**
 * Created by PhpStorm.
 * User: batyr
 * Date: 9/27/2019
 * Time: 6:03 PM
 */

namespace common\models\wrappers;


use arogachev\ManyToMany\behaviors\ManyToManyBehavior;
use common\models\CompetitionToTeam;
use common\models\Team;
use dosamigos\taggable\Taggable;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use Yii;

class TeamWrapper extends Team {
    private $_url;
    private $_content;

    public $tagIds = [];

    public function behaviors() {
        return [
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                    [
                        'editableAttribute' => 'tagIds', // Editable attribute name
                        'name' => 'tags',
                    ],
                ],
            ],
            [
                'class' => Taggable::className(),
            ],
        ];
    }


    public function rules() {
        return \yii\helpers\ArrayHelper::merge(parent::rules(), [
            [['tagNames'], 'safe'],
        ]);
    }


    public function getUrl($absolute = false) {
        if ($this->_url === null)
            $this->_url = Url::to(['team/view', 'id' => $this->id]);

        return $this->_url;
    }


    public function loadContent() {
        if (isset($this->_content))
            return $this->_content;

        if (isset($this->content_item_id)) {
            $this->_content = ItemWrapper::find()->where(['id' => $this->content_item_id])->multilingual()->one();
            return $this->_content;
        }
        return null;
    }


    public function getCategory() {
        return $this->hasOne(CategoryWrapper::className(), ['id' => 'category_id']);
    }


    public function getContent() {
        return $this->hasOne(ItemWrapper::className(), ['id' => 'content_item_id']);
    }


    public function getSportTypeList() {
        $list = CategoryWrapper::find()
            ->joinWith('parent p')
            ->where(['p.code' => 'sport-types'])
            ->all();

        return ArrayHelper::map($list, 'id', 'name');

    }


    private $_name;

    public function getName() {
        if (!isset($this->_name)) {
            $this->_name = $this->loadContent()->title;
        }

        return $this->_name;
    }


    public function getTags() {
        return $this->hasMany(TagWrapper::className(), ['id' => 'tag_id'])->viaTable('tbl_team_to_tag', ['team_id' => 'id']);
    }

    public function getCompetitionToTeams() {
        return $this->hasMany(CompetitionToTeam::className(), ['team_id' => 'id']);
    }

}