<?php

include '../../connection.php';
include 'security.php';

function make_id($s) {
    $st = "";
    $k = 0;
    $firstChar = TRUE;
    
    for ($i = 0; $i < strlen($s); $i++) {
        if (($s[$i] >= 'a' && $s[$i] <= 'z') || ($s[$i] >= 'A' && $s[$i] <= 'Z')) {
            $firstChar = FALSE;
            if ($k > 0) {
                $k = 0;
                if (!$firstChar) {
                    $st .= '-';
                }
            }
            $st .= strtolower($s[$i]);
        }
        else if ($s[$i] >= '0' && $s[$i] <= '9') {
            $firstChar = FALSE;
            if ($k > 0) {
                $k = 0;
                if (!$firstChar) {
                    $st .= '-';
                }
            }
            $st .= $s[$i];
        }
        else {
            $k++;
        }
    }
    return $st;
}

$id = $_POST['id'];
$title = $_POST['title'];
$prev_title = $_POST['prev_title'];
$up_id = make_id($title);
$start_tym = $_POST['start'];
$end_tym = $_POST['end'];
$freeze_tym = $_POST['freeze'];
$desc = $_POST['desc'];
$rule = $_POST['rule'];
$problems = $_POST['probs'];
$scores = $_POST['scores'];
$judges = $_POST['judges'];
$contestants = $_POST['contestants'];

$err_msg = '';
$prb_arr = explode(' ', $problems);
$jud_arr = explode('/', $judges);
$cont_arr = explode('/', $contestants);
for ($i = 0; $i < count($prb_arr); $i++) {
    $qry1 = "SELECT * FROM User_Problem WHERE Id = '{$prb_arr[$i]}';";
    $res1 = mysqli_query($con, $qry1);
    if (mysqli_num_rows($res1) == 0) {
        $err_msg = 'No such problems found with id = '.$prb_arr[$i];
        break;
    }
    else { //problem is valid, check if it is form any of the judges
        $judge_found = FALSE;
        for ($j = 0; $j < count($jud_arr); $j++) {
            $qry2 = "SELECT * FROM User_Problem WHERE Id = '{$prb_arr[$i]}' AND Author = '{$jud_arr[$j]}';";
            $res2 = mysqli_query($con, $qry2);
            if (mysqli_num_rows($res2) > 0) {
                $judge_found = TRUE;
            }
        }
        if (!$judge_found) {
            $err_msg = 'The problem with id = '.$prb_arr[$i].' is not authored by any of the mentioned judges';
            break;
        }
    }
}

function go_further() {
    global $con, $id, $title, $prev_title, $up_id, $start_tym, $end_tym, $freeze_tym, $desc, $rule, $problems, $scores, $judges, $contestants, $err_msg;
    if ($start_tym == '') {
        echo '<h4 class="text-danger mb-3">Set start time!</h4>
        <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if (strtotime($start_tym) < time()) {
        echo '<h4 class="text-danger mb-3">Invalid start time!</h4>
        <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if ($end_tym == '') {
        echo '<h4 class="text-danger mb-3">Set end time!</h4>
        <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if ($end_tym == '') {
        echo '<h4 class="text-danger mb-3">Set end time!</h4>
        <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if (strtotime($start_tym) > strtotime($end_tym)) {
        echo '<h4 class="text-danger mb-3">Invalid time interval!</h4>
        <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if ($freeze_tym == '') {
        echo '<h4 class="text-danger mb-3">Set ranklist freeze time!</h4>
        <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if (strtotime($start_tym) > strtotime($freeze_tym) || strtotime($freeze_tym) > strtotime($end_tym)) {
        echo '<h4 class="text-danger mb-3">Invalid time for ranklist freezing!</h4>
        <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if ($desc == '') { //description blank
        echo '<h4 class="text-danger mb-3">Description can\'t be empty!</h4>
        <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if ($judges == '') { //judges blank
        echo '<h4 class="text-danger mb-3">Judge\'s field can\'t be empty!</h4>
        <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if ($contestants == '') { //contestants blank
        echo '<h4 class="text-danger mb-3">Contestants\'s field can\'t be empty!</h4>
        <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if ($problems == '') { //problem blank
        echo '<h4 class="text-danger mb-3">Problem\'s field can\'t be empty!</h4>
        <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if ($scores == '') { //score blank
        echo '<h4 class="text-danger mb-3">Score\'s field can\'t be empty!</h4>
        <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if (substr_count($problems, ' ') != substr_count($scores, ' ')) { //author blank
        echo '<h4 class="text-danger mb-3">There is some error with problem and it\'s score!</h4>
        <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if($err_msg) {
        echo '<h4 class="text-danger mb-3">'.$err_msg.'!</h4>
        <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else {
        $qry = "UPDATE User_Contest SET
            Id = '{$up_id}',
            Title = '{$title}',
            Description = '{$desc}',
            Rules = '{$rule}',
            Start_Time = '{$start_tym}',
            Finish_Time = '{$end_tym}',
            Freeze_Time = '{$freeze_tym}',
            Problems = '{$problems}',
            Scores = '{$scores}',
            Judges = '/{$judges}/',
            Contestants = '/{$contestants}/'
        WHERE Id = '{$id}';";

        mysqli_query($con, $qry) or die('Error');

        echo $up_id;
    }
}

if (trim($title) == '') { //title blank
    echo '<h4 class="text-danger mb-3">Contest title can\'t be empty</h4>
    <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
}
else if ($title == $prev_title) { //title not blank, unchanged
    go_further();
}
else if ($id == $up_id) { //title not blank, changed but id remain same
    go_further();
}
else { //title not blank, totally changed
    $qry = "SELECT Id FROM Problem WHERE Id = '{$up_id}';";
    $res = mysqli_query($con, $qry);
    if (mysqli_num_rows($res) > 0) { //this id already taken, title not acceptable
        echo '<h4 class="text-danger">Similar title has already taken, try a different one</h4>
        <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else {
        go_further();
    }    
}

?>