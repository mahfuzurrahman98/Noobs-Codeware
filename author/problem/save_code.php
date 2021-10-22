<?php

include '../../connection.php';
include 'security.php';

$id = $_POST['pid'];
$code = mysqli_real_escape_string($con, $_POST['code']);
$lang = $_POST['lang'];

$qry = "UPDATE User_Problem SET Judges_Sol_Lang = '{$lang}', Judges_Solution = '{$code}' WHERE Id = '{$id}';";
$res = mysqli_query($con, $qry) or die("Code saving failed!");

?>