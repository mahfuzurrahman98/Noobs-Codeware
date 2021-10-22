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
$tit = trim(mysqli_real_escape_string($con, $_POST['tit']));
$prev_tit = mysqli_real_escape_string($con, $_POST['prev_tit']);
$new_id = make_id($tit);
$dif = $_POST['dif'];
$stat = $_POST['stat'];
$cons = $_POST['cons'];
$ipf = $_POST['ipf'];
$opf = $_POST['opf'];
$note = $_POST['note'];
$tcc = trim(mysqli_real_escape_string($con, $_POST['tcc']));
$req = $_POST['req'];
$tag = '';


function go_further() {
    global $con, $id, $new_id, $tit, $prev_tit, $dif, $stat, $cons, $ipf, $opf, $note, $auth, $tcc, $tag, $req;
    if ($stat == '') {
        echo '<h4 class="text-danger mb-3">Problem statement can\'t be empty</h4>
        <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    if ($cons == '') {
        echo '<h4 class="text-danger mb-3">Problem constraints can\'t be empty</h4>
        <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if ($ipf == '') {
        echo '<h4 class="text-danger mb-3">Intput format can\'t be empty</h4>
        <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if ($opf == '') {
        echo '<h4 class="text-danger mb-3">Output format statement can\'t be empty</h4>
        <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if ($tag == '') {
        echo '<h4 class="text-danger mb-3">Select at least one tag</h4>
        <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else if ($tcc == '') {
        echo '<h4 class="text-danger mb-3">Testcase contributor\'s name can\'t be empty</h4>
        <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
    }
    else {
        //echo 'in_query';
        //echo 'arch: '.$arch.'<br>';
        $qry = "UPDATE User_Problem SET
            Id = '{$new_id}',
            Title = '{$tit}',
            Difficulty = '{$dif}',
            Tags = '{$tag}',
            Statement = '{$stat}',
            Constraints = '{$cons}',
            Input_Format = '{$ipf}',
            Output_Format = '{$opf}',
            Notes = '{$note}',
            Author = '{$_SESSION["Username"]}',
            TC_Contributor = '{$tcc}',
            Requested = '{$req}'
            WHERE Id = '{$id}';
        ";
        mysqli_query($con, $qry) or die("Updation failed!");
        rename('../../uploads/user/testcases/'.$id, '../../uploads/user/testcases/'.$new_id);

        echo '<div>
            <h4 class="text-success mb-3">Problem updated successfully!</h4>
            <a href="details.php?id='.$new_id.'" class="btn btn-lg btn-success"><b>Proceed</b></a>
        </div>';
    }
}

//echo 'prev_title: '.$prev_tit.'<br>';
//echo 'title: '.$tit.'<br>';
//echo 'prev_id: '.$id.'<br>';
//echo 'new_id: '.$new_id;

if (count($_POST['tags']) > 1) {
    foreach ($_POST['tags'] as $x) {
        $tag .= ' ' . $x;
    }
    $tag = trim($tag);
    //echo 'tags: '.$tag;
}

if (trim($tit) == '') { //title blank
    echo '<h4 class="text-danger mb-3">Problem title can\'t be empty</h4>
    <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
}
else if ($tit == $prev_tit) { //title not blank, unchanged
    go_further();
}
else if ($id == $new_id) { //title not blank, changed but id remain same
    go_further();
}
else { //title not blank, totally changed
    $qry = "SELECT Id FROM Problem WHERE Id = '{$new_id}';";
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