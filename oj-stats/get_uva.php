<?php

$u_UVa_Handle ='Mahfuz98';

$acc = 0;
$nos = 0;
$show = [];
$source = 'https://uhunt.onlinejudge.org/api/';
$context = stream_context_create(array(
    'http' => array(
        'header'=>'Connection: close\r\n',
        'method'  => 'POST',
        'content' => '',
        'timeout' => 5
    )
));

function load($url) {
    global $context;
    $response = file_get_contents($url, false, $context);
    return json_decode($response, true);
}

function cmp($a, $b) {
    return $a[4] < $b[4];
}

function userSubmissions($userid) {
    $sub = load('https://uhunt.onlinejudge.org/api/subs-user-last/'.$userid.'/10')['subs'];
    usort($sub, "cmp");

    $verdict = [
        10 => "Submission error", 15 => "Can't be judged", 20 => "In queue",
        30 => "Compilation error", 35 => "Restricted", 40 => "Runtime error",
        45 => "Output limit", 50 => "Time limit", 60 => "Memory limit",
        70 => "Wrong answer", 80 => "Presentation error", 90 => "Accepted"
    ];
    $language = [1 => "ANSI C", 2 => "Java", 3 => "C++", 4 => "Pascal", 5 => "C++11", 6 => "Python3"];
    
    for ($i = 0; $i < 10; $i++) {
        $prob = load('https://uhunt.onlinejudge.org/api/p/id/'.$sub[$i][1]);
        $tmp = [];
        $tmp[0] = $sub[$i][0];
        $tmp[1] = $prob['num'];
        $tmp[2] = $prob['title'];
        $tmp[3] = $verdict[$sub[$i][2]];
        $tmp[4] = $language[$sub[$i][5]];
        $tmp[5] = gmdate("Y-m-d H:i", $sub[$i][4]);
        $tmp[6] = $sub[$i][1];
        $show[$i] = $tmp;
    }
    return $show;
}

if (empty($u_UVa_Handle)) {
    $f_uv = 0;
}
else {
    $user_id = load('https://uhunt.onlinejudge.org/api/uname2uid/'.$u_UVa_Handle);
    //echo 'uid: '.$user_id;

    if ($user_id == 0) {
        $f_uv = 0;
    }
    else {
        $stat = load($source.'ranklist/'.$user_id.'/0/0');
        $acc = $stat[0]['ac'];
        $nos = $stat[0]['nos'];
        $rank = $stat[0]['rank'];
        $subs = userSubmissions($user_id);
        $wid = number_format($acc / $nos * 100, 2, '.', '');
    }
}

?>