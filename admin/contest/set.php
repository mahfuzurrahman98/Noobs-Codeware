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

$title = trim(mysqli_real_escape_string($con, $_POST['title']));
$id = make_id($title);
$start_tym = $_POST['start'];
$end_tym = $_POST['end'];
$freeze_tym = $_POST['frz'];
$desc = $_POST['desc'];
$rule = $_POST['rule'];
$problems = trim(mysqli_real_escape_string($con, $_POST['probs']));
$scores = trim(mysqli_real_escape_string($con, $_POST['scores']));
$author = trim(mysqli_real_escape_string($con, $_POST['author']));

$qry = "SELECT Title FROM Contest WHERE Id = '{$id}';";
$res = mysqli_query($con, $qry);

if (mysqli_num_rows($res) > 0) {
    echo '<h4 class="text-danger mb-3">A similar title has already been taken, try a different one!</h4>
    <button class="btn btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>';
}
else if ($title == '') { //title blank
    echo '<h4 class="text-danger mb-3">Contest title can\'t be empty!</h4>
    <button class="btn btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>';
}
else if ($start_tym == '') {
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
    echo 'id: ' . $id . '<br>';
    echo 'tit: ' . $title . '<br>';
    echo 'desc: ' . $desc . '<br>';
    echo 'rule: ' . $rule . '<br>';
    echo 'st: ' . $start_tym . '<br>';
    echo 'et: ' . $end_tym . '<br>';
    echo 'prb: ' . $problems . '<br>';
    echo 'scr: ' . $scores . '<br>';
    echo 'auth: ' . $author . '<br>';
    $qry = "INSERT INTO Contest(Id, Title, Description, Rules, Start_Time, Finish_Time, Freeze_Time, Problems, Scores, Author) VALUES('{$id}', '{$title}', '{$desc}', '{$rule}', '{$start_tym}', '{$end_tym}', '{$freeze_tym}', '{$problems}', '{$scores}', '/{$author}/');";
    mysqli_query($con, $qry) or die($qry);

    echo '<h4 class="text-success mb-3">Contest set successfully!</h4>
    <a class="btn btn btn-success" href="setting.php?id='.$id.'">Proceed</a>';
}
?>