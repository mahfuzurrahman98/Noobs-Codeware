<?php

include '../connection.php';
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    exit('<h1>Invalid page request</h1>');
}

//Problem
$title = trim($_POST['title']);
$diff = $_POST['diff'];
$tags = [];
$tags = $_POST['tags'];

//Pagination
$page = $_POST['page'];
$lim = 3;
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
//$qry = "SELECT Id, Title, Difficulty, Author FROM User_Problem WHERE Requested = 'Yes' AND Approved = 'No' AND Title LIKE '%{$title}%' AND Difficulty LIKE '%{$diff}%' AND (Tags LIKE '%{$tags[0]}%'";
$qry = "SELECT Id, Title, Difficulty, Author FROM User_Problem WHERE REquested = 'Yes' AND Approved = 'No' AND Title LIKE '%{$title}%' AND Difficulty LIKE '%{$diff}%' AND (Tags LIKE '%{$tags[0]}%'";

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
            echo '<td><b>'.$prb_tit.'</b></td>';
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
            echo '<td><a class="btn btn-sm btn-primary" target="-blank" href="view_prb.php?id='.$prb_id.'"><i class="fas fa-eye"></i></a></td>';
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