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
$judges = '/' . trim(mysqli_real_escape_string($con, $_POST['judge'])) . '/';
$contestants = '/' . trim(mysqli_real_escape_string($con, $_POST['contestant'])) . '/';


$qry = "SELECT Title FROM Contest WHERE Id = '{$id}';";
$res1 = mysqli_query($con, $qry);

$qry = "SELECT Title FROM User_Contest WHERE Id = '{$id}';";
$res2 = mysqli_query($con, $qry);

if (mysqli_num_rows($res1) > 0 || mysqli_num_rows($res2) > 0) {
    echo 'A similar title has already been taken, try a different one!';
}
else if ($title == '') { //title blank
    echo 'Contest title can\'t be empty!';
}
else if ($start_tym == '') {
    echo 'Set start time!';
}
else if (strtotime($start_tym) < time()) {
    echo 'Invalid start time!';
}
else if ($end_tym == '') {
    echo 'Set end time!';
}
else if (strtotime($start_tym) > strtotime($end_tym)) {
    echo 'Invalid time interval!';
}
else if ($judges == '') {
    echo 'Judge\'s field can\'t be empty!';
}
else if (strpos($judges, ' ') !== false) {
   echo 'No spaces in, after or before judge\'s name!'; 
}
else if ($contestants == '') {
   echo 'Contestant\'s field can\'t be empty!'; 
}
else if (strpos($contestants, ' ') !== false) {
    echo 'No spaces in, after or before contestant\'s name!'; 
}
else {
    $qry = "INSERT INTO User_Contest(Id, Title, Start_Time, Finish_Time, Freeze_Time, Judges, Contestants) VALUES('{$id}', '{$title}', '{$start_tym}', '{$end_tym}', '{$end_tym}', '{$judges}', '{$contestants}');";
    mysqli_query($con, $qry) or die("insertion failed"); ?>
    hello
    <script>window.location="contest/setting.php?id=" + "<?php echo $id; ?>"</script>
<?php } ?>