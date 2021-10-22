<?php

include '../../connection.php';
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    die('<h1>Invalid page request</h1>');
}

$aid = $_POST['aid'];
$qry = "DELETE FROM Announcement WHERE Id = {$aid};";
mysqli_query($con, $qry);

?>