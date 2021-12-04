<?php if (isset($commentsModel) && count($commentsModel) > 0) { ?>
    <div class="comments">
        <h4 class="title">There are 3 comments on this post</h4>
        <ul class="comments-list">
            <?php
            foreach ($commentsModel as $comment) {
                echo $this->render('//comment/_comment_view',['model'=>$comment]);
            }
            ?>
        </ul>
    </div>
<?php } ?>



<?php
$show_form= (isset($show_form) && $show_form==true) ? true : false;

if($show_form){
    echo $this->render('//comment/_form',['model'=>$comment]);
}
?>
