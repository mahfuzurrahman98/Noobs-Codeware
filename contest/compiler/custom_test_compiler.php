<?php

include '../../connection.php'; 
if (!isset($_SESSION["Username"])) {
    header("Location: ../../login.php");
}

$msg = '';
$output = '';
$time_needed = 0.00; //Seconds
$memory_needed = 0.00; //MegaBytes

$lang = $_POST['language'];
$code = $_POST['code'];
$input = $_POST['input'];
file_put_contents('input.txt', $input);

$compilation_command = '';
$execution_command = '';
$code_file = '';
$success = 0;

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

if (trim($comp_msg)){ //Compilation Error
    $msg = '<h5 class = "ver-ce"><b>Compilation Error!</b></h5>';
    $output = '<div class="text-muted">'.$comp_msg.'</div>';
} 

else { //Compiled, No Compilation Error
    //Run binary file
    shell_exec($execution_command);

    $exec_msg = file('exec_msg.txt');
    $sz = count($exec_msg);

    if ($sz == 0) {
        $time_needed = 5.00;
        $msg = '<h5 class = "ver-tle"><b>Terminated due to timeout!</b></h5>';
        $output = '';
    }

    else {
        if ($sz > 23) { //Runtime Error
            $msg = '<h5 class = "ver-re"><b>Runtime Error!</b></h5>';
            $output = '';
            for ($i = 0; $i < $sz - 23; $i++) {
                $output .= $exec_msg[$i];
            }
        }

        else {
            $msg = '<h5 class = "text-success"><b>Successfully Compiled & Executed!</b></h5>';
            $output = file_get_contents('output.txt');
            $success = 1;
        }

        $exec_msg = array_slice($exec_msg, $sz - 23);
        $time_needed = sprintf('%0.2f',floatval(substr($exec_msg[4], -6)));
        $memory_needed = sprintf('%0.2f', floatval(substr($exec_msg[9], 36)) / 1024);
    }
}

if ($lang == 'C' || $lang == 'C++') {
    shell_exec('rm ./noob');
}
else if ($lang == 'Java') {
    shell_exec('rm *.class');
}
file_put_contents('output.txt', 'Hello Noobs!');

echo nl2br($msg);
echo '<div class="text-muted">Time: '.$time_needed.'s; Memory: ' . $memory_needed . 'MB</div>';
$output = str_replace(' ', '&nbsp' ,$output);
echo nl2br($output);

?>