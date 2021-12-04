<?php
if (count($this->context->teams)) {
    echo "<h3>Turnir</h3>";


    $inputId = 'bracket_' . uniqid();
    $results = \yii\helpers\Json::encode(array_values($this->context->results));
    $teams = \yii\helpers\Json::encode($this->context->teams);

//    echo "<pre>";
//    print_r($teams);
//    print_r($results);
//    echo "</pre>";

//$mockFiles = \yii\helpers\Json::encode($this->context->mockFiles);
    $script = <<< JS

    // var mockFiles =$mockFiles;
    var inputId ='$inputId';
    var results =$results;
    var teams =$teams;
    var uploadedIds =[];

    var data = {
        teams:teams,
        results:results
        // teams : [
        //     ["Team 1",  "Team 2" ],
        //     ["Team 3",  "Team 4" ],
        //     ["Team 5",  "Team 6" ],
        //     ["Team 7",  "Team 8" ],
        //     ["Team 9",  "Team 10"],
        //     ["Team 11", "Team 12"],
        //     ["Team 13", "Team 14"],
        //     ["Team 15", "Team 16"]
        // ],
        // results : [
        //     [[3,5], [2,4], [6,3], [2,3], [1,5], [5,3], [7,2], [1,2]],
        //     [[1,2], [3,4], [5,6], [7,8]],
        //     [[9,1], [8,2]],
        //     [[1,3],[1,7]]
        // ]
    }

    $(function() { 
        $("#$inputId").bracket({init: data}) 
    })

// var bigData = {
//   teams : [
//     ["Team 1",  "Team 2" ],
//     ["Team 3",  "Team 4" ],
//     ["Team 5",  "Team 6" ],
//     ["Team 7",  "Team 8" ],
//     ["Team 9",  "Team 10"],
//     ["Team 11", "Team 12"],
//     ["Team 13", "Team 14"],
//     ["Team 15", "Team 16"]
//   ],
//   results : [
//     [[3,5], [2,4], [6,3], [2,3], [1,5], [5,3], [7,2], [1,2]],
//     [[1,2], [3,4], [5,6], [7,8]],
//     [[9,1], [8,2]],
//     [[1,3]]
//   ]
// }
// 
// $(function() { $('#'+inputId).bracket({init: bigData}) })


JS;

    $this->registerJs($script, yii\web\View::POS_READY);

    ?>

    <div id="<?= $inputId ?>"></div>

<?php } ?>