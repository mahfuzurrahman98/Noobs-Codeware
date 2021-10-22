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

function chechkName($st) {
    foreach (str_split($st) as $k) {
        if ($k >= '0' && $k <= '9') {
            continue;
        }
        else if (($k >= 'A' && $k <= 'Z') || ($k >= 'a' && $k <= 'z')) {
            continue;
        }
        else if ($k == ' ' || $k == '_') {
            continue;
        }
        else {
            return FALSE;
        }
    }
    return TRUE;
}

$tit = trim(mysqli_real_escape_string($con, $_POST['tit']));
$id = make_id($tit);
$dif = $_POST['dif'];
$stat = $_POST['stat'];
$cons = $_POST['cons'];
$ipf = $_POST['ipf'];
$opf = $_POST['opf'];
$note = $_POST['note'];
$auth = trim(mysqli_real_escape_string($con, $_POST['auth']));
$tcc = trim(mysqli_real_escape_string($con, $_POST['tcc']));
$arch = $_POST['arch'];

$tag = '';
foreach ($_POST['tags'] as $x) {
    $tag .= ' ' . $x;
}
$tag = trim($tag);

$qry = "SELECT Title FROM Problem WHERE Id = '{$id}';";
$res = mysqli_query($con, $qry);

if (mysqli_num_rows($res) > 0) {
    echo '<h4 class="text-danger mb-3">A similar title has already been taken, try a different one!</h4>
    <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
}
else if ($tit == '') { //title blank
    echo '<h4 class="text-danger mb-3">Problem title can\'t be empty!</h4>
    <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
}
else if ($stat == '') {
    echo '<h4 class="text-danger mb-3">Problem statement can\'t be empty!</h4>
    <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
}
else if ($cons == '') {
    echo '<h4 class="text-danger mb-3">Problem constraints can\'t be empty!</h4>
    <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
}
else if ($ipf == '') {
    echo '<h4 class="text-danger mb-3">Intput format can\'t be empty!</h4>
    <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
}
else if ($opf == '') {
    echo '<h4 class="text-danger mb-3">Output format statement can\'t be empty!</h4>
    <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
}
else if ($tag == '') {
    echo '<h4 class="text-danger mb-3">Select at least one tag</h4>
    <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
}
else if ($auth == '') {
    echo '<h4 class="text-danger mb-3">Author\'s name can\'t be empty!</h4>
    <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
}
else if (!chechkName($auth)) {
    echo '<h4 class="text-danger mb-3">Author\'s name can only contains alphaneumeric characters</h4>
    <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
}
else if ($tcc == '') {
    echo '<h4 class="text-danger mb-3">Testcase contributor\'s name can\'t be empty!</h4>
    <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
}
else if (!chechkName($tcc)) {
    echo '<h4 class="text-danger mb-3">Testcase contributor\'s name can only contains underscore alphaneumeric and characters</h4>
    <button class="btn btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>';
}
else {
    shell_exec('mkdir ../../uploads/admin/testcases/'.$id);
    shell_exec('mkdir ../../uploads/admin/testcases/'.$id.'/input');
    shell_exec('mkdir ../../uploads/admin/testcases/'.$id.'/output');

    shell_exec('echo> ../../uploads/admin/testcases/'.$id.'/input/0.txt');
    shell_exec('echo> ../../uploads/admin/testcases/'.$id.'/output/0.txt');

    $qry = "INSERT INTO Problem(Id, Title, Difficulty, Tags, Statement, Constraints, Input_Format, Output_Format, Sample_Test, Notes, Author, TC_Contributor, Archive) VALUES('{$id}', '{$tit}', '{$dif}', '{$tag}', '{$stat}', '{$cons}', '{$ipf}', '{$opf}', '0.txt', '{$note}', '{$auth}', '{$tcc}', '{$arch}');";
    mysqli_query($con, $qry) or die("err".mysqli_error());
    //mysqli_query($con, $qry);
    echo "qry: ".$qry;

    $qry = "INSERT INTO Problem_Statistics(P_Id) VALUES('{$id}');";
    mysqli_query($con, $qry) or die("insertion failed1!");
    //mysqli_query($con, $qry);
    echo "qry2: ".$qry;

    ?>

    <div>
        <h4 class="text-success">Problem added successfully</h4>
        <div class="text-muted mt-2 mb-3">Proceed to the next page for adding testcases and further modification</div>
        <a href="details.php?id=<?php echo $id; ?>" class="btn btn-lg btn-success"><b>Proceed</b></a>
    </div>
<?php } ?>