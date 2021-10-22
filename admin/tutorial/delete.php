<?php

include '../../connection.php';
include 'security.php';

$tid = $_POST['tid'];
$qry = "DELETE FROM Tutorial WHERE Id = '{$tid}';";
mysqli_query($con, $qry);

?>