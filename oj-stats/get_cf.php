<?php

if (empty($u_CF_Handle)) {
    $f_cf = 0;
} 
else {
    $cfh = $u_CF_Handle;
    function load2($node, $sp, $arguments = array()) {
        $context = stream_context_create(array(
            'http' => array(
                'header'=>'Connection: close\r\n',
                'method'  => 'POST',
                'content' => '',
                'timeout' => 5
            )
        ));
        $src = 'https://codeforces.com/api/';

        if (is_array($arguments) === false) {
            $arguments = array($arguments);
        }
        if (empty($arguments)) {
            $response = file_get_contents($src . $node, false, $context);
        } else {
            foreach ($arguments as &$argument) {
                if (is_array($argument)) {
                    $argument = implode(',', $argument);
                }
            }
            $response = file_get_contents($src . $node . $sp . implode('/', $arguments), false, $context);
        }
        return json_decode($response, true);
    }

    $cf_info = load2('user.info', '?', 'handles=' . $cfh);
    if ($cf_info['status'] == "FAILED") {
        $f_cf = 0;
    }
    else {
        $cf_usr_res = $cf_info['result'][0];
        $reg_tim = $cf_usr_res['registrationTimeSeconds'];
        $usr_rat = $cf_usr_res['rating'];
        $usr_rank = $cf_usr_res['rank'];
        $usr_mxrat = $cf_usr_res['maxRating'];
        $usr_mxrank = $cf_usr_res['maxRank'];

        $sub = load2('user.status', '?', 'handle=' . $cfh . '&from=1&count=10');
        $sub = $sub['result'];

        $cf_subs = [];
        for ($i=0; $i <10 ; $i++) { 
            $tmp = [];
            $tmp[0] = $sub[$i]['id']; //submission
            $tmp[1] = $sub[$i]['contestId']; //contest id
            $tmp[2] = $sub[$i]['problem']['index']; //problem number
            $tmp[3] = $sub[$i]['problem']['name']; //title
            $tmp[4] = $sub[$i]['verdict']; //verdict
            $tmp[5] = $sub[$i]['programmingLanguage']; // language
            $tmp[6] = gmdate("Y-m-d H:i", $sub[$i]['creationTimeSeconds']); //when
            $cf_subs[$i] = $tmp;
        }
    }
}

?>