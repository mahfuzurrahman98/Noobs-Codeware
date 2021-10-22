<?php

include '../connection.php';
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    exit('<h1>Invalid page request</h1>');
}

$ann_id = $_POST['ann_id'];

$qry = "SELECT Ques FROM Clarifi_Comment WHERE Cmnt_Id = {$ann_id};";
$res = mysqli_query($con, $qry);

while ($row = mysqli_fetch_assoc($res)) {
	$Ques = $row['Ques'];
}

echo $Ques;

?>