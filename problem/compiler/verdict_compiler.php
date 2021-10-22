<?php

include '../../connection.php';
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    exit('<h1>Invalid page request</h1>');
}

$sub_id = $_POST['sub_id'];
$qry = "SELECT Problem_Id, Source_Code, Language FROM Submission WHERE Sub_Id = {$sub_id};";
$res = mysqli_query($con, $qry);

$row = mysqli_fetch_assoc($res);
$pid = $row['Problem_Id'];
$lang = $row['Language'];
$code = $row['Source_Code'];
$fs = 0;

function trim_lines($arr): string {
    $x = "";
    for ($i = 0; $i < count($arr); $i++) {
        $x .= rtrim($arr[$i]) . PHP_EOL;
    }
    return rtrim($x);
}

$time_limit = 0;
$mem_limit = 0;
$compilation_command = '';
$execution_command = '';
$code_file = '';

$flag = true;
$output = '';
$time_needed = 0.00; //Seconds
$memory_needed = 0.00; //MegaBytes

if ($lang == 'C') {
    $time_limit = 5;
    $mem_limit = 256;
    $code_file = 'noob.c';
    $compilation_command = 'gcc noob.c -o noob 2>comp_msg.txt';
    $execution_command = 'timeout 5s time -v ./noob < input.txt 2>exec_msg.txt >output.txt';
    $binary_file = './noob';
}

else if ($lang == 'C++') {
    $time_limit = 5;
    $mem_limit = 256;
    $code_file = 'noob.cpp';
    $compilation_command = 'g++ noob.cpp -o noob 2>comp_msg.txt';
    $execution_command = 'timeout 5s time -v ./noob < input.txt 2>exec_msg.txt >output.txt';
    $binary_file = './noob';
}

else if ($lang == 'Java') {
    $time_limit = 7;
    $mem_limit = 1536;
    $code_file = 'noob.java';
    $compilation_command = 'javac noob.java 2>comp_msg.txt';
    $execution_command = 'timeout 7s time -v java noob < input.txt 2>exec_msg.txt >output.txt';
    $binary_file = 'noob.class';
}

else if ($lang == 'Python') {
    $time_limit = 10;
    $mem_limit = 1024;
    $code_file = 'noob.py';
    $compilation_command = 'timeout 10s python3 noob.py 2>comp_msg.txt';
    $execution_command = 'timeout 10s time -v python3 noob.py < input.txt 2>exec_msg.txt >output.txt';
    $binary_file = 'noob.py';
}

$inps = scandir('../../uploads/admin/testcases/'.$pid.'/input');
$outs = scandir('../../uploads/admin/testcases/'.$pid.'/output');

shell_exec('chmod 777 /'.$code_file);
shell_exec('chmod 777 /'.$binary_file);

file_put_contents($code_file, $code);
$fs = filesize($code_file); //in Bytes
shell_exec($compilation_command);
$comp_msg = file_get_contents('comp_msg.txt');

if ($lang == 'Python') {
    if (mb_substr_count($comp_msg, 'SyntaxError') == 0 && mb_substr_count($comp_msg, 'ZeroDivisionError') == 0) {
        $comp_msg = '';
    }
}

if (trim($comp_msg)){ //Compilation Error
    $verdict = 'Compilation error';
    echo '<h5 class = "mb-3 ver-ce"><b>Compilation Error!</b></h5>';
    echo '<div class="text-muted">'.nl2br($comp_msg).'</div>';
    $flag = false;
}

else {
    for ($i = 2; $i < count($inps); $i++) {
        file_put_contents('input.txt', file_get_contents('../../uploads/admin/testcases/'.$pid.'/input/'.$inps[$i]));
        shell_exec($execution_command);

        $exec_msg = file('exec_msg.txt');
        $sz = count($exec_msg);

        if ($sz == 0) {
            $verdict = 'TLE on testcase ' . ($i - 2);
            echo '<h5 class = "mb-3 ver-tle">TLE on testcase ' . ($i - 2).'</h5>';
            $time_needed = $time_limit + 0.1;
            $mem_limit = 0.00;
            $flag = false;
            break;
        }

        else {
            $exec_msg = array_slice($exec_msg, $sz - 23);
            $time_needed = floatval(substr($exec_msg[4], -6)); //in seconds
            $memory_needed = floatval(substr($exec_msg[9], 36)); //in kB

            if ($sz > 23) { //Runtime Error
                $verdict = 'RE on testcase ' . ($i - 2);
                echo '<h5 class = "mb-3 ver-re">RE on testcase ' . ($i - 2) . '</h5>';
                $flag = false;
                break;
            }

            else {
                if ($memory_needed /1024 > $mem_limit) {
                    $verdict = 'MLE on testcase ' . ($i - 2);
                    echo '<h5 class = "mb-3 ver-mle">MLE on testcase ' . ($i - 2).'</h5>';
                    $flag = false;
                    break;
                }

                $judge_output = file_get_contents('../../uploads/admin/testcases/'.$pid.'/output/'.$outs[$i]);
                $ex_output = trim_lines(file('output.txt'));

                if ($ex_output != $judge_output) {
                    $verdict = 'WA on testcase ' . ($i - 2);
                    echo '<h5 class = "mb-3 ver-wa">WA on testcase ' . ($i - 2).'</h5>';
                    $flag = false;
                    break;
                }
            }
        }
    }
}

if ($lang == 'C' || $lang == 'C++') {
    shell_exec('rm ./noob');
}
if ($lang == 'Java') {
    shell_exec('rm *.class');
}
file_put_contents('output.txt', 'Hello Noobs!');

if ($flag) {
    $verdict = 'Accepted';
    echo '<h5 class = "mb-3 text-success">Accepted</h5>';
}

//Query Processing Part
$unm = $_SESSION['Username'];
$code = str_replace('\n', '\\\\n' ,$code);
$code = str_replace('\r', '\\\\r' ,$code);
$code = str_replace('\t', '\\\\t' ,$code);

//Update statistics - No. of submission
$qry = "UPDATE Problem_Statistics SET No_Of_Sub := No_Of_Sub + 1 WHERE P_Id = '{$pid}';";
mysqli_query($con, $qry);
//Update statistics - No. of user
$qry = "SELECT Verdict FROM Submission WHERE Problem_Id = '{$pid}' AND Username = '{$unm}';";
$res = mysqli_query($con, $qry);
if (mysqli_num_rows($res) == 0) {
    $qry = "UPDATE Problem_Statistics SET No_Of_User := No_Of_User + 1 WHERE P_Id = '{$pid}';";
    mysqli_query($con, $qry);
}

if (substr($verdict, 0, 1) == 'C') {
    $qry = "UPDATE Problem_Statistics SET No_Of_CE := No_Of_CE + 1 WHERE P_Id = '{$pid}';";
    mysqli_query($con, $qry);
}
else if (substr($verdict, 0, 1) == 'R') {
    $qry = "UPDATE Problem_Statistics SET No_Of_RE := No_Of_RE + 1 WHERE P_Id = '{$pid}';";
    mysqli_query($con, $qry);
}
else if (substr($verdict, 0, 1) == 'T') {
    $qry = "UPDATE Problem_Statistics SET No_Of_TLE := No_Of_TLE + 1 WHERE P_Id = '{$pid}';";
    mysqli_query($con, $qry);
}
else if (substr($verdict, 0, 1) == 'M') {
    $qry = "UPDATE Problem_Statistics SET No_Of_MLE := No_Of_MLE + 1 WHERE P_Id = '{$pid}';";
    mysqli_query($con, $qry);
}
else if (substr($verdict, 0, 1) == 'W') {
    $qry = "UPDATE Problem_Statistics SET No_Of_WA := No_Of_WA + 1 WHERE P_Id = '{$pid}';";
    mysqli_query($con, $qry);
}
else if (substr($verdict, 0, 1) == 'A') {
    $qry = "UPDATE Problem_Statistics SET No_Of_Acc := No_Of_Acc + 1 WHERE P_Id = '{$pid}';";
    mysqli_query($con, $qry);
    //Update No. of solve if not solved by current user previously
    $qry = "SELECT Verdict FROM Submission WHERE Problem_Id = '{$pid}' AND Username = '{$unm}' AND Verdict = 'Accepted';";
    $res = mysqli_query($con, $qry);
    if (mysqli_num_rows($res) == 0) {
        $qry = "UPDATE Problem_Statistics SET No_Of_Solve := No_Of_Solve + 1 WHERE P_Id = '{$pid}';";
        mysqli_query($con, $qry);
    }
}

$qry = "UPDATE Submission SET
    Verdict = '{$verdict}',
    Time = {$time_needed},
    Memory = {$memory_needed},
    Source_Size = {$fs}
WHERE Sub_Id = {$sub_id};";

mysqli_query($con, $qry) or die($qry);


if ($verdict == 'Accepted') {
    //Delete from todo, if there
    $qry = "DELETE FROM Todo WHERE Problem_Id = '{$pid}' AND _user = '{$unm}';";
    mysqli_query($con, $qry);

    //Add another solve
    $qry = "SELECT Sub_Id FROM Submission WHERE Problem_Id = '{$pid}' AND Username = '{$unm}' AND Verdict = 'Accepted';";
    $res = mysqli_query($con, $qry);
    if (mysqli_num_rows($res) == 0) {
        $qry = "UPDATE User SET Solve := Solve + 1 WHERE Username = '{$unm}';";
        mysqli_query($con, $qry);
    }
}

?>