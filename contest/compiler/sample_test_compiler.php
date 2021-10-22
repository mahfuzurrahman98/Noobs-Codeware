<?php

include '../../connection.php'; 
if (!isset($_SESSION["Username"])) {
    header("Location: ../../login.php");
}

$pid = $_POST['pid'];
$lang = $_POST['language'];
$code = $_POST['code'];

$compilation_command = '';
$execution_command = '';
$code_file = '';
$success = 0;

function trim_lines($arr) {
    $x = "";
    for ($i = 0; $i < count($arr); $i++) {
        $x .= rtrim($arr[$i]) . PHP_EOL;
    }
    return rtrim($x);
}

if ($lang == 'C') {
    $code_file = 'noob.c';
    $compilation_command = 'gcc noob.c -o noob 2>comp_msg.txt';
    $execution_command = 'timeout 5s time -v ./noob < input.txt 2>exec_msg.txt >output.txt';
}

else if ($lang == 'C++') {
    $code_file = 'noob.cpp';
    $compilation_command = 'g++ noob.cpp -o noob 2>comp_msg.txt';
    $execution_command = 'timeout 5s time -v ./noob < input.txt 2>exec_msg.txt >output.txt';
}

else if ($lang == 'Java') {
    $code_file = 'noob.java';
    $compilation_command = 'javac noob.java 2>comp_msg.txt';
    $execution_command = 'timeout 5s time -v java noob < input.txt 2>exec_msg.txt >output.txt';
}

else if ($lang == 'Python') {
    $code_file = 'noob.py';
    $compilation_command = 'python3 noob.py 2>comp_msg.txt';
    $execution_command = 'timeout 5s time -v python3 noob.py < input.txt 2>exec_msg.txt >output.txt';
}

file_put_contents($code_file, $code);
shell_exec($compilation_command);
$comp_msg = file_get_contents('comp_msg.txt');

if ($lang == 'Python') {
    if (mb_substr_count($comp_msg, 'SyntaxError') == 0) {
        $comp_msg = '';
    }
}

$verdict = '';
$flag = 1;
$output = '';
$time_needed = 0.00;
$memory_needed = 0.00;



if (trim($comp_msg)){ //Compilation Error
    echo '<h5 class = "mb-3 ver-ce"><b>Compilation Error!</b></h5>';
    echo '<div class="text-muted">'.nl2br($comp_msg).'</div>';
    $flag = 0;
}

else {
    $qry = "SELECT Sample_Test FROM Problem WHERE Id = '{$pid}';";
    $res = mysqli_query($con, $qry);
    while ($row = mysqli_fetch_assoc($res)) {
        $tst = explode(' ', $row['Sample_Test']);
    }
    for ($i = 0; $i < count($tst); $i++) {

        $k = $tst[$i];
        file_put_contents('input.txt', file_get_contents('../../uploads/admin/testcases/'.$pid.'/input/'.$k));
        shell_exec($execution_command);

        $exec_msg = file('exec_msg.txt');
        $sz = count($exec_msg);

        if ($sz == 0) {
            echo '<h5 class = "mb-3 ver-tle"><b>TLE On Sample Case ' . $i.'</b></h5>';
            $time_needed = 5.00;
            $flag = 0;
            break;
        }

        else {
            if ($sz > 23) { //Runtime Error
                echo '<h5 class = "mb-3 ver-re"><b>RE On Sample Case ' . $i . '</b></h5>';
                $flag = 0;
                break;
            }

            else { //Check WA
                $judge_output = trim(file_get_contents('../../uploads/admin/testcases/'.$pid.'/output/'.$k));
                $ex_output = trim_lines(file('output.txt'));
                if ($ex_output != $judge_output) {
                    echo '<h5 class = "mb-3 ver-wa"><b>WA On Sample Case ' . $i . '</b></h5>';
                    $flag = 0;
                    break;
                }
            }

            $exec_msg = array_slice($exec_msg, $sz - 23);
            $time_needed = sprintf('%0.2f',floatval(substr($exec_msg[4], -6)));
            $memory_needed = sprintf('%0.2f', floatval(substr($exec_msg[9], 36)) / 1024);
        }
    }

}
if ($lang == 'C' || $lang == 'C++') {
    shell_exec('rm ./noob');
}
else if ($lang == 'Java') {
    shell_exec('rm *.class');
}
file_put_contents('output.txt', 'Hello Noobs!');

if ($flag) {
    echo '<h5 class = "mb-3 text-success"><b>Sample testcases passed</b></h5>';
}
?>