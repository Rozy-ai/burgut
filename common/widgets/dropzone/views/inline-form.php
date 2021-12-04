<?php
$dropZoneName = $this->context->dropzoneName;
$enableMetadataEdit = $this->context->enableMetadataEdit;
$options = $this->context->options;
$deleteUrl = \yii\helpers\Url::to([$this->context->deleteUrl]);
$uploadUrl = \yii\helpers\Url::to([$this->context->uploadUrl]);
$inputId = $this->context->inputId;

$documentEditUrl = \yii\helpers\Url::toRoute(['document/update']);


//$js = 'var $('#".$inputId."') = $("#'.$inputId.'");';
//$this->registerJs($js);

echo \kato\DropZone::widget([
    'id' => $dropZoneName,
    'dropzoneContainer' => $dropZoneName . '-myDropzone',
    'previewsContainer' => $dropZoneName . '-previews',
    'uploadUrl' => $uploadUrl,
    'options' => $options,

    'clientEvents' => [
        'success' => "function(file ,response){
                    if(!isNaN(parseInt(response))){
                        if($('#" . $inputId . "').val() == ''){
                            $('#" . $inputId . "').val(response);
                        }else{
                            var before =  $('#" . $inputId . "').val();
                            $('#" . $inputId . "').val(before +','+response);
                        }
                        file.id=response;
                    }else{
                        alert(response);
                    }
            }",

        'maxfilesexceeded' => "function(file) {
            this.removeAllFiles();
            this.addFile(file);
        }",

        "complete" => "function(file){
                var enableMetadataEdit=$enableMetadataEdit;
                if(enableMetadataEdit){
                    var newNode = document.createElement('a');
                    newNode.className = 'dz-remove dz-edit';
                    newNode.href = '$documentEditUrl'+'?id='+file.id;
                    newNode.setAttribute('data-toggle','modal')
                    newNode.setAttribute('data-target','#modaldocument')
                    newNode.innerHTML = 'Edit';
                    file.previewTemplate.appendChild(newNode);
                }
        }",

        'removedfile' => "function(file){
                    if(!file.hasOwnProperty('id'))
                        return;
                    var id=file.id;
                    
                    //configure hidden field
                    var data = $('#" . $inputId . "').val();
                    var remove = data.split(',');
                    remove = jQuery.grep(remove, function(value) {
                      return value != id;
                    });
                    $('#" . $inputId . "').val(remove.toString());
                    
                    var token = '" . Yii::$app->request->csrfParam . "';
                    $.ajax({
                        type: 'POST',
                        url: '" . $deleteUrl . "',
                        data : {YII_CSRF_TOKEN : token, fileId : id, type:'Avatar' },
                        success : function(){
                            $('.allert').show();
                        },
                        error : function(){
                            $('.error').show(); 
                        },
                    });
                    alert(file.name + ' is removed');
            }"
    ],
]);


$mockFiles = \yii\helpers\Json::encode($this->context->mockFiles);
$script = <<< JS

    var mockFiles =$mockFiles;
    var inputId ='$inputId';
    var uploadedIds =[];

        $.each(mockFiles, function(key,mockFile){
            // var mockFile = { name: value.name, size: value.size, url:value.url, id:value.id };
            $dropZoneName.emit("addedfile", mockFile);
            $dropZoneName.emit("thumbnail", mockFile,mockFile.url);
            // myDropzone.emit("thumbnail", mockFile, mockFile.url);
            $dropZoneName.emit("complete", mockFile);       
        });
        
        uploadedIds=mockFiles.map(function(file){
            return file.id;
        });
        
        if(uploadedIds.length>0){
            $('#'+inputId).val(uploadedIds.toString());
        }
        
        
        
        $("body").on("beforeSubmit", "form#dynamic-form", function () {
                var form = $(this);
        
                // return false if form still have some validation errors
                if (form.find(".has-error").length) {
                        return false;
                }
        
                // submit form
                $.ajax({
                        url    : form.attr("action"),
                        type   : "post",
                        data   : form.serialize(),
                        success: function (response) {
                               $("#modaldocument").modal("hide");
                               // $.pjax.reload({container:"#pjax-menu-item-list"}); //for pjax update
                        },
                        error  : function () {
                                //console.log("internal server error");
                        }
                });
                return false;
         });
JS;

$this->registerJs($script, yii\web\View::POS_READY);

?>


<div class="modal remote fade" id="modaldocument">
    <div class="modal-dialog">
        <div class="modal-content loader-lg"></div>
    </div>
</div>

