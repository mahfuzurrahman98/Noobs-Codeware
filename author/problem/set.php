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

$tit = trim(mysqli_real_escape_string($con, $_POST['tit']));
$id = make_id($tit);
$dif = $_POST['dif'];
$auth = $_SESSION['Username'];

$tag = '';
foreach ($_POST['tags'] as $x) {
    $tag .= ' ' . $x;
}
$tag = trim($tag);

$qry = "SELECT Title FROM User_Problem WHERE Id = '{$id}';";
$res = mysqli_query($con, $qry);

if (mysqli_num_rows($res) > 0) {
    echo 'A similar title has already been taken, try a different one!';
}
else if ($tit == '') { //title blank
    echo 'Problem title can\'t be empty!';
}
else if ($tag == '') { //tags blank
    echo 'Select at least one tags, make sure what kind of problem you want to set.';
}
else {
    shell_exec('mkdir ../../uploads/user/testcases/'.$id);
    shell_exec('mkdir ../../uploads/user/testcases/'.$id.'/input');
    shell_exec('mkdir ../../uploads/user/testcases/'.$id.'/output');

    shell_exec('echo> ../../uploads/user/testcases/'.$id.'/input/0.txt');
    shell_exec('echo> ../../uploads/user/testcases/'.$id.'/output/0.txt');

    $qry = "INSERT INTO User_Problem(Id, Title, Difficulty, Sample_Test, Tags, Author, TC_Contributor) VALUES('{$id}', '{$tit}', '{$dif}', '0.txt', '{$tag}', '{$auth}', '{$auth}');";

    mysqli_query($con, $qry) or die($qry); ?>

    <script>
        window.location="problem/details.php?id=" + "<?php echo $id; ?>";
    </script>

<?php } ?>