<?php 
if (!defined('noob')) {
    exit('<h1>Invalid page request</h1>');
}
?>

<h5 class="text-danger">Last Unsolved</h5>

<?php

$qry_unsolved = "SELECT DISTINCT Id, Title FROM Problem JOIN Submission ON Title = Problem_Title WHERE Problem_Title NOT IN(SELECT DISTINCT Problem_Title FROM Submission WHERE Verdict = 'Accepted') LIMIT 5;";

$res_unsolved = mysqli_query($con, $qry_unsolved) or die("Query Failed!");

if (mysqli_num_rows($res_unsolved) > 0) {
    $ff = 0;
    while ($row = mysqli_fetch_assoc($res_unsolved)) {
        $up_id = $row['Id'];
        $up_tit = $row['Title'];
        if ($ff) {
            echo ' | ';
        }
        echo '<a href="details.php?id='.$up_id.'">'.$up_tit.'</a></i>';
        $ff = 1;
    }
}
?>