<li class="comment ">
    <div class="comment-author relative-pos clearfix">
        <h5 class="name"><?= $model->fullname ?></h5>
        <h6 class="meta"><?= $model->renderDateToWord($model->date_created); ?></h6>
    </div>
    <h5 class="name"><?= \yii\bootstrap\Html::encode($model->comment) ?></h5>
    <a href="#" data-id=<?=$model->id ?> class="btn tiny">Replay</a>
</li>