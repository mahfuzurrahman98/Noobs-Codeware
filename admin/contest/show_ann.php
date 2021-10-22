<?php

include '../../connection.php';
include 'security.php';

$ann_id = $_POST['ann_id'];

$qry = "SELECT Ques FROM Clarifi_Comment WHERE Cmnt_Id = {$ann_id};";
$res = mysqli_query($con, $qry);

while ($row = mysqli_fetch_assoc($res)) {
	$Ques = $row['Ques'];
}

echo $Ques;

?>