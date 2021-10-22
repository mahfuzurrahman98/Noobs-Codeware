<?php

include '../connection.php';

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    die('Invalid page request');
}

$tit = trim(mysqli_real_escape_string($con, $_POST['title']));
$cat = $_POST['category'];
$auth = trim(mysqli_real_escape_string($con, $_POST['author']));
$page = $_POST['page'];
$lim = 5;
$off = ($page - 1) * $lim;
$qry = '';

if ($tit == 'All' OR $tit == '') {
    $tit = '%';
}
if ($cat == 'All') {
    $cat = '%';
}
if ($auth == 'All' OR $auth == '') {
    $auth = '%';
}

$qry = "SELECT * FROM Tutorial WHERE Title LIKE '%{$tit}%' AND Category LIKE '{$cat}' AND Author LIKE '%{$auth}%' AND Approved = 'Yes' LIMIT {$lim} OFFSET {$off};";
$res = mysqli_query($con, $qry);


if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $tut_id = $row['Id'];
        $tut_tit = $row['Title'];
        $tut_cat = $row['Category'];
        $tut_auth = $row['Author'];
        $tut_tym = $row['Added_Time'];
        
        echo '<tr>';
        echo '<td>' . '<div class="p-2 shadow shadow-lg bg-white rounded">' .
            '<div>'.'<a class="h4" href="show.php?id=' . $tut_id. '">'. $tut_tit . '</a>' . '</div>'.
            '<i class="fas fa-book-open"></i>' .
            '<span class="text-dark ml-1 mr-5">' . $tut_cat . '</span>' .
            '<i class="fas fa-calendar-alt"></i>' .
            '<span class="text-info">' . date(" M j Y g:i A", strtotime($tut_tym)) . '</span>' .
            '</div>'.
        '</td>';
        echo '</tr>';
    }
}

?>
