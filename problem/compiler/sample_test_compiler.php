<?php

include '../../connection.php';
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    exit('<h1>Invalid page request</h1>');
}

$pid = $_POST['pid'];
$lang = $_POST['language'];
$code = $_POST['code'];

$compilation_command = '';
$execution_command = '';
$code_file = '';
$binary_file = '';
$time_limit = 0;
$mem_limit = 0;

$verdict = '';
$flag = TRUE;
$output = '';
$time_needed = 0.00;
$memory_needed = 0.00;

function trim_lines($arr): string {
    $x = "";
    for ($i = 0; $i < count($arr); $i++) {
        $x .= rtrim($arr[$i]) . PHP_EOL;
    }
    return rtrim($x);
}

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
    $mem_limit = 512;
    $code_file = 'noob.py';
    $compilation_command = 'timeout 10s python3 noob.py 2>comp_msg.txt';
    $execution_command = 'timeout 10s time -v python3 noob.py < input.txt 2>exec_msg.txt >output.txt';
    $binary_file_file = 'noob.py';
}

shell_exec('chmod 777 /'.$code_file);
shell_exec('chmod 777 /'.$binary_file);

file_put_contents($code_file, $code);
shell_exec($compilation_command);
$comp_msg = file_get_contents('comp_msg.txt');

if ($lang == 'Python') {
    if (mb_substr_count($comp_msg, 'SyntaxError') == 0 && mb_substr_count($comp_msg, 'ZeroDivisionError') == 0) {
        $comp_msg = '';
    }
}

if (trim($comp_msg)){ //Compilation Error
    echo '<h5 class = "mb-3 ver-ce"><b>Compilation Error!</b></h5>';
    echo '<div class="text-muted">'.nl2br($comp_msg).'</div>';
    $flag = FALSE;
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
            echo '<h5 class = "mb-3 ver-tle"><b>TLE on sample case ' . $i.'</b></h5>';
            $flag = FALSE;
            break;
        }

        else {
            if ($sz > 23) { //Runtime Error
                echo '<h5 class = "mb-3 ver-re"><b>RE on sample case ' . $i . '</b></h5>';
                $flag = FALSE;
                break;
            }

            else {
                $exec_msg = array_slice($exec_msg, $sz - 23);
                $time_needed = floatval(substr($exec_msg[4], -6)); //in seconds
                $memory_needed = floatval(substr($exec_msg[9], 36)) / 1024; //in megabytes

                if ($memory_needed > $mem_limit) {
                    $verdict = 'MLE on testcase ' . $i;
                    echo '<h5 class = "mb-3 ver-mle">MLE on testcase ' . $i .'</h5>';
                    $flag = false;
                    break;
                }

                $judge_output = trim(file_get_contents('../../uploads/admin/testcases/'.$pid.'/output/'.$k));
                $ex_output = trim_lines(file('output.txt'));
                if ($ex_output != $judge_output) {
                    echo '<h5 class = "mb-3 ver-wa"><b>WA on sample case ' . $i . '</b></h5>';
                    $flag = FALSE;
                    break;
                }
            }
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