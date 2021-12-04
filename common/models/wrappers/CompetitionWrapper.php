<?php
/**
 * Created by PhpStorm.
 * User: batyr
 * Date: 9/27/2019
 * Time: 6:00 PM
 */

namespace common\models\wrappers;


use arogachev\ManyToMany\behaviors\ManyToManyBehavior;
use common\models\Competition;
use common\models\CompetitionToParticipant;
use common\models\CompetitionToTeam;
use dosamigos\taggable\Taggable;
use yii\helpers\ArrayHelper;
use Yii;
use yii\helpers\Url;

class CompetitionWrapper extends Competition
{
    private $_url;
    private $_content;
    public $tagIds = [];

    public function behaviors()
    {
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


    public function rules()
    {
        return \yii\helpers\ArrayHelper::merge(parent::rules(), [
            [['tagNames'], 'safe'],
        ]);
    }


    public function attributeLabels()
    {
        return \yii\helpers\ArrayHelper::merge(parent::attributeLabels(), [
            'season_id' => Yii::t('app', 'Season'),
        ]);
    }

    public function loadContent()
    {
        if (isset($this->_content))
            return $this->_content;

        if (isset($this->content_item_id)) {
            $this->_content = ItemWrapper::find()->where(['id' => $this->content_item_id])->multilingual()->one();
            return $this->_content;
        }
        return null;
    }


    public function getUrl($absolute = false)
    {
        if ($this->_url === null)
            $this->_url = Url::to(['competition/view', 'id' => $this->id]);

        return $this->_url;
    }


    public function getSportTypeList()
    {
        $list = CategoryWrapper::find()
            ->joinWith('parent p')
            ->where(['p.code' => 'sport-types'])
            ->all();

        return ArrayHelper::map($list, 'id', 'name');
    }


    //needs to be adapted to get by sport-types later
    public function getSeasonsList()
    {
        return ArrayHelper::map(SeasonWrapper::find()->where(['competition_id' => $this->id])->all(), 'id', 'name');
    }

    public function getTeamCount()
    {
        return CompetitionToTeam::find()->where(['competition_id' => $this->id])->count();
    }

    public function getAthleteCount()
    {
        return CompetitionToParticipant::find()->where(['competition_id' => $this->id, 'type' => CompetitionToParticipantWrapper::PARTICIPANT_TYPE_ATHLETE])->count();
    }


    public function getSeason()
    {
        return $this->hasOne(SeasonWrapper::className(), ['id' => 'season_id']);
    }


    public function getCategory()
    {
        return $this->hasOne(CategoryWrapper::className(), ['id' => 'category_id']);
    }


    public function getDocuments()
    {
        return $this->hasMany(DocumentWrapper::className(), ['id' => 'document_id'])
            ->viaTable('tbl_competition_to_document', ['item_id' => 'id'])
            ->orderBy('type');
    }


    public function getTags()
    {
        return $this->hasMany(TagWrapper::className(), ['id' => 'tag_id'])->viaTable('tbl_competition_to_tag', ['competition_id' => 'id']);
    }

}