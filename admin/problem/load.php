<?php

include '../../connection.php';
include 'security.php';

//Problem
$title = trim($_POST['title']);
$diff = $_POST['diff'];
$tags = [];
$tags = $_POST['tags'];

//Pagination
$page = $_POST['page'];
$lim = 5;
$off = ($page - 1) * $lim;

//Changes based on conditions
if ($title == '') {
    $title = '%';
}
if (count($tags) > 1) {
    array_pop($tags);
}

//Query writing
$qry = '';

$qry = "SELECT Id, Title, Difficulty, Author FROM Problem WHERE Title LIKE '%{$title}%' AND Difficulty LIKE '%{$diff}%' AND (Tags LIKE '%{$tags[0]}%'";

//Adding tags
$len_tag = count($tags);
if ($len_tag == 1) { //only one tag or no tags
    $qry .= ")";
}
else { //more than one
    for ($i = 1; $i < $len_tag; $i++) {
        $qry .= " OR Tags LIKE '%{$tags[$i]}%'";
    }
    $qry .= ")";
}

$qry .= " ORDER BY Added_Time DESC LIMIT {$lim} OFFSET {$off};";

$res = mysqli_query($con, $qry) or die('Query Error');
if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $prb_id = $row['Id'];
        $prb_tit = $row['Title'];
        $prb_dif = $row['Difficulty'];
        $prb_auth = $row['Author'];

        $qry_auth = "SELECT Username FROM User WHERE Username = '{$prb_auth}';";
        $res_auth = mysqli_query($con, $qry_auth);
        if (mysqli_num_rows($res_auth) > 0) {
            $prb_auth = '<td><a href="../../profile.php?user='.$prb_auth.'">'.$prb_auth.'</a></td>';
        }
        else {
            $prb_auth = '<td>'.$prb_auth.'</td>';
        }

        echo '<tr>';
            echo '<td><a href="../../problem/details.php?id='.$prb_id.'">'.$prb_tit.'</a></td>';
            if ($prb_dif == 'Simple') {
                echo '<td class="text-secondary">'.$prb_dif.'</td>';
            }
            else if ($prb_dif == 'Easy') {
                echo '<td class="text-success">'.$prb_dif.'</td>';
            }
            else if ($prb_dif == 'Medium') {
                echo '<td class="text-warning">'.$prb_dif.'</td>';
            }
            else if ($prb_dif == 'Moderate') {
                echo '<td style="color: rgb(214, 118, 70);">'.$prb_dif.'</td>';
            }
            else {
                echo '<td class="text-danger">'.$prb_dif.'</td>';
            }
            echo $prb_auth;
            echo '<td><a class="btn btn-sm btn-primary" href="details.php?id='.$prb_id.'"><i class="far fa-edit"></i></a></td>';
            
            echo '<td><button data-toggle="modal" class="btn btn-sm btn-danger dltbtn" data-target="#dlt_prb" data-id="'.$prb_id.'"><i class="far fa-trash-alt"></i></button></td>';
        echo '</tr>';
    }
}
else {
    echo '<tr class="text-danger text-center">';
        echo '<td>No</td>';
        echo '<td>results</td>';
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
