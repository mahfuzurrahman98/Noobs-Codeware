<?php

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    exit('<h1>Invalid page request</h1>');
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

$time_limit = 0;
$mem_limit = 0;

if ($lang == 'C') {
    $time_limit = 5;
    $mem_limit = 256;
    $code_file = 'noob.c';
    $compilation_command = 'gcc noob.c -o noob 2>comp_msg.txt';
    $execution_command = 'timeout 5s time -v ./noob < input.txt 2>exec_msg.txt >output.txt';
    $binary_file = 'noob';
}

else if ($lang == 'C++') {
    $time_limit = 5;
    $mem_limit = 256;
    $code_file = 'noob.cpp';
    $compilation_command = 'g++ noob.cpp -o noob 2>comp_msg.txt';
    $execution_command = 'timeout 5s time -v ./noob < input.txt 2>exec_msg.txt >output.txt';
    $binary_file = 'noob';
}

else if ($lang == 'Java') {
    $time_limit = 7;
    $mem_limit = 1536;
    $code_file = 'noob.java';
    $compilation_command = 'javac noob.java 2>comp_msg.txt';
    $execution_command = 'timeout 5s time -v java noob < input.txt 2>exec_msg.txt >output.txt';
    $binary_file = 'noob.class';
}

else if ($lang == 'Python') {
    $time_limit = 512;
    $mem_limit = 0;
    $code_file = 'noob.py';
    $compilation_command = 'timeout 10s python3 noob.py 2>comp_msg.txt';
    $execution_command = 'timeout 10s time -v python3 noob.py < input.txt 2>exec_msg.txt >output.txt';
    $binary_file = 'noob.py';
}

file_put_contents($code_file, $code);
shell_exec('chmod 777 /'.$code_file);
shell_exec('chmod 777 /'.$binary_file);

shell_exec($compilation_command);
$comp_msg = file_get_contents('comp_msg.txt');

if (trim($comp_msg)) { //Compilation Error
    $msg = '<h6 class = "mb-1 ver-ce"><b>Compilation Error!</b></h6>';
    if ($lang != 'Php' && $lang != 'Javascript') {
        $output = $comp_msg;
    }
}

else { //Compiled, No Compilation Error
    //Run binary file
    shell_exec($execution_command);

    $exec_msg = file('exec_msg.txt');
    $sz = count($exec_msg);

    if ($sz == 0) {
        $time_needed = $time_limit;
        $msg = '<h6 class = "ver-tle"><b>Terminated due to timeout!</b></h6>';
        $output = '';
    }

    else {
        if ($sz > 23) { //Runtime Error
            $msg = '<h6 class = "mb-1 ver-re"><b>Runtime Error!</b></h6>';
            $output = '';
            if ($lang != 'Php' && $lang != 'Javascript') {
                for ($i = 0; $i < $sz - 23; $i++) {
                    $output .= $exec_msg[$i];
                }
            }
        }

        else {
            $msg = '<h6 class = "mb-1 ver-acc"><b>Successfully Compiled & Executed!</b></h6>';
            $output = trim(file_get_contents('output.txt'));
            $success = 1;
        }

        $exec_msg = array_slice($exec_msg, $sz - 23);

        $time_needed = sprintf('%0.2f', floatval(substr($exec_msg[4], -6)));
        $memory_needed = sprintf('%0.2f', floatval(substr($exec_msg[9], 36)) / 1024);
    }
}

if ($lang == 'C' || $lang == 'C++') {
    shell_exec('rm '.$binary_file);
}
else if ($lang == 'Java') {
    shell_exec('rm *.class');
}

file_put_contents('output.txt', 'The binary file hasn\'t executed yet');
echo nl2br($msg);
echo '<div class="text-muted">Time: '.$time_needed.'s; Memory: ' . $memory_needed . 'MB</div>';
$output = str_replace(' ', '&nbsp' ,$output);
$output = str_replace("\t", '&nbsp&nbsp&nbsp&nbsp' ,$output);
echo nl2br($output);

?>