<?php

include '../../connection.php';
include 'security.php';

$pid = $_POST['pid'];
$qry = "DELETE FROM Problem WHERE Id = '{$pid}';";
mysqli_query($con, $qry);

shell_exec('rm -R ../../uploads/admin/testcases/'.$pid);

$qry = "DELETE FROM Todo WHERE Problem_Id = '{$pid}';";
mysqli_query($con, $qry);

?>