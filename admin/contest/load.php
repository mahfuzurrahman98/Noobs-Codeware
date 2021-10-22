<?php

include '../../connection.php';
include 'security.php';

//Problem
$tit = trim($_POST['tit']);
$auth = $_POST['auth'];
$stat = $_POST['stat'];

//Pagination
$page = $_POST['page'];
$lim = 5;
$off = ($page - 1) * $lim;

//Changes based on conditions
if ($tit == '') {
    $tit = '%';
}

//Query writing
$qry = "SELECT Id, Title, Start_Time, Finish_Time, Author FROM Contest WHERE Title LIKE '%{$tit}%' AND Author LIKE '%{$auth}%'";

//Calculate running time
if ($stat == 'Ended') {
    $qry .= " AND Finish_Time < CURRENT_TIMESTAMP";
}
else if ($stat == 'Running') {
    $qry .= " AND CURRENT_TIMESTAMP >= Start_Time AND CURRENT_TIMESTAMP <= Finish_Time";
}
else if ($stat == 'Featured') {
    $qry .= " AND Start_Time > CURRENT_TIMESTAMP";
}
else {
    $qry .= "";
}

$qry .= " ORDER BY Start_Time DESC LIMIT {$lim} OFFSET {$off};";

$res = mysqli_query($con, $qry) or die('Query Error');
if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $con_id = $row['Id'];
        $con_tit = $row['Title'];
        $auth = explode('/', $row['Author']);
        $con_st = $row['Start_Time'];
        $con_ft = $row['Finish_Time'];
        $to_time = strtotime($con_ft);
        $from_time = strtotime($con_st);
        $x = abs($to_time - $from_time) / 60;
        $len = intval($x / 60).":".sprintf("%02d", ($x % 60));

        for ($i = 0; $i < count($auth); $i++) {
            $auth[$i] = trim($auth[$i]);
            $qry_auth = "SELECT Username FROM User WHERE Username = '{$auth[$i]}';";
            $res_auth = mysqli_query($con, $qry_auth);
            if (mysqli_num_rows($res_auth) > 0) {
                $auth[$i] = '<a href="../../profile.php?user='.$auth[$i].'">'.$auth[$i].'</a>';
            }
        }

        echo '<tr>';
            echo '<td><a href="../../contest/overview.php?id='.$con_tit.'">'.$con_tit.'</a></td>'; ?>
            <td>
                <?php foreach ($auth as $x) {
                    echo $x.' ';
                } ?>
            </td>
            <?php
            echo '<td>'.$con_st.'</td>';
            echo '<td class="text-danger">'.$len.'</td>';
            echo '<td>
                <a class="btn btn-success" href="overview.php?id='.$con_id.'"><i class="fas fa-eye"></i></a>
                <a class="btn btn-secondary mt-1 mt-lg-0" href="setting.php?id='.$con_id.'"><i class="fas fa-cog"></i></a>
            </td>';
        echo '</tr>';
    }
}
else {
    echo '<tr class="text-danger text-center">';
        echo '<td>No</td>';
        echo '<td>contests</td>';
        echo '<td>are</td>';
        echo '<td>found</td>';
    echo '</tr>';
}
?>

<script>
    var x = -1;
    $(".dltbtn").click(function() {
        x = $(this).attr('data-id');
        console.log(x);
    })

    function del() {
        $.ajax({
            url: "delete.php",
            method: "POST",
            data: {
                pid: x
            },
            success: function(response) {
                window.location.reload();
            }
        });
    }
</script>
