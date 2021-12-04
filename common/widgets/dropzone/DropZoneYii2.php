<?php
/**
 * Created by PhpStorm.
 * User: Fujitsu
 * Date: 1.4.2017
 * Time: 9:00 AM
 */

namespace common\widgets\dropzone;


class DropZoneYii2  extends \yii\base\Widget{
    public $dropzoneName = 'myDropzone';
    public $uploadUrl = '/site/upload';
    public $deleteUrl = '/site/deleteupload';
    public $mockFiles = [];
    public $inputId = 'fileupload3';
    public $enableMetadataEdit = true;

    public $options=[];

    public function init() {

        if (!isset($this->options['clickable'])) $this->options['clickable'] = true;
        if (!isset($this->options['addRemoveLinks'])) $this->options['addRemoveLinks'] = true;
        if (!isset($this->options['uploadMultiple'])) $this->options['uploadMultiple'] = false;
        if (!isset($this->options['parallelUploads'])) $this->options['parallelUploads'] = 100;
//        if (!isset($this->options['maxFilesize'])) $this->options['maxFilesize'] = 8;
        if (!isset($this->options['dictRemoveFile'])) $this->options['dictRemoveFile'] = 'Remove';
        if (!isset($this->options['dictFileTooBig'])) $this->options['dictFileTooBig'] = 'Image is bigger than 8MB';

        $this->options['params']=['folder'=>$this->inputId];

        if (!$this->enableMetadataEdit) {
            $this->enableMetadataEdit = 0;
        }
        parent::init();
    }



    public function run()
    {
        if(isset($this->inputId))
            return $this->render('inline-form',['inputId'=>$this->inputId]);
    }
}