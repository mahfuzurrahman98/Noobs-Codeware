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
$prev_title = trim(mysqli_real_escape_string($con, $_POST['prev_title']));
$title = trim(mysqli_real_escape_string($con, $_POST['title']));
$up_id = make_id($title);
$start_tym = $_POST['start'];
$end_tym = $_POST['end'];
$freeze_tym = $_POST['frz'];
$desc = $_POST['desc'];
$rule = $_POST['rule'];
$problems = trim(mysqli_real_escape_string($con, $_POST['probs']));
$scores = trim(mysqli_real_escape_string($con, $_POST['scores']));
$author = trim(mysqli_real_escape_string($con, $_POST['author']));

function go_further() {
    global $con, $id, $title, $prev_title, $up_id, $start_tym, $end_tym, $freeze_tym, $desc, $bg_img, $rule, $problems, $scores, $author, $img, $img_err, $fname, $ftmp, $ftyp, $fext;
    if ($start_tym == '') {
        echo '<h4 class="text-danger mb-3">Set start time!</h4>
        <button class="btn btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if (strtotime($start_tym) < time()) {
        echo '<h4 class="text-danger mb-3">Invalid start time!</h4>
        <button class="btn btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if ($end_tym == '') {
        echo '<h4 class="text-danger mb-3">Set end time!</h4>
        <button class="btn btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if (strtotime($start_tym) > strtotime($end_tym)) {
        echo '<h4 class="text-danger mb-3">Invalid time interval!</h4>
        <button class="btn btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if (strtotime($start_tym) >= strtotime($freeze_tym) || strtotime($end_tym) < strtotime($freeze_tym)) {
        echo '<h4 class="text-danger mb-3">Invalid time for ranklist freezing!</h4>
        <button class="btn btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if ($desc == '') { //description blank
        echo '<h4 class="text-danger mb-3">Description can\'t be empty!</h4>
        <button class="btn btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if ($author == '') { //author blank
        echo '<h4 class="text-danger mb-3">Author\'s field can\'t be empty!</h4>
        <button class="btn btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if ($problems == '') { //problem blank
        echo '<h4 class="text-danger mb-3">Problem\'s field can\'t be empty!</h4>
        <button class="btn btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if ($scores == '') { //score blank
        echo '<h4 class="text-danger mb-3">Score\'s field can\'t be empty!</h4>
        <button class="btn btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if (substr_count($problems, ' ') != substr_count($scores, ' ')) { //author blank
        echo '<h4 class="text-danger mb-3">There is some error with problem and it\'s score!</h4>
        <button class="btn btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else {
        $qry = "UPDATE Contest SET
            Id = '{$up_id}',
            Title = '{$title}',
            Description = '{$desc}',
            Rules = '{$rule}',
            Start_Time = '{$start_tym}',
            Finish_Time = '{$end_tym}',
            Freeze_Time = '{$freeze_tym}',
            Problems = '{$problems}',
            Scores = '{$scores}',
            Author = '/{$author}/'
        WHERE Id = '{$id}';";
        mysqli_query($con, $qry) or die('Error');

        echo '<h4 class="text-success mb-3">Contest updated successfully!</h4>
        <button class="btn btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>';
    }
}

if (trim($title) == '') { //title blank
    echo '<h4 class="text-danger mb-3">Contest title can\'t be empty</h4>
    <button class="btn btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>';
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
        <button class="btn btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else {
        go_further();
    }    
}

?>