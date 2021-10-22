<?php

$msg = '';
$output = '';
$time_needed = 0.00; //Seconds
$memory_needed = 0.00; //MegaBytes

$code = $_POST['code'];
$lang = $_POST['lang'];
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
    $binary_file = 'noob';
}

else if ($lang == 'C++') {
    $code_file = 'noob.cpp';
    $compilation_command = 'g++ noob.cpp -o noob 2>comp_msg.txt';
    $execution_command = 'timeout 5s time -v ./noob < input.txt 2>exec_msg.txt >output.txt';
    $binary_file = 'noob';
}

else if ($lang == 'Java') {
    $code_file = 'noob.java';
    $compilation_command = 'javac noob.java 2>comp_msg.txt';
    $execution_command = 'timeout 5s time -v java noob < input.txt 2>exec_msg.txt >output.txt';
    $binary_file = 'noob.class';
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
    if (mb_substr_count($comp_msg, 'SyntaxError') == 0 && mb_substr_count($comp_msg, 'ZeroDivisionError') == 0) {
        $comp_msg = '';
    }
}

if (trim($comp_msg)) { //Compilation Error
    $msg = 'Compilation Error';
    $output = $comp_msg;
} 

else { //Compiled, No Compilation Error
    //Run binary file
    shell_exec($execution_command);

    $exec_msg = file('exec_msg.txt');
    $sz = count($exec_msg);

    if ($sz == 0) {
        $time_needed = 5.00;
        $msg = 'Timeout Error';
        $output = '';
    }

    else {
        if ($sz > 23) { //Runtime Error
            $msg = 'Runtime Error';
            $output = '';
            for ($i = 0; $i < $sz - 23; $i++) {
                $output .= $exec_msg[$i];
            }
        }

        else {
            $msg = 'Success';
            $output = trim(file_get_contents('output.txt'));
            $success = 1;
        }

        $exec_msg = array_slice($exec_msg, $sz - 23);

        $time_needed = sprintf('%0.2f', floatval(substr($exec_msg[4], -6)));
        $memory_needed = sprintf('%0.2f', floatval(substr($exec_msg[9], 36)) / 1024);
    }
}

if ($lang == 'C' || $lang == 'C++' || $lang == 'Java') {
    shell_exec('rm '.$binary_file);
}
$ret = [];
$ret['msg'] = $msg;
$ret['output'] = $output;
echo json_encode($ret);

?>