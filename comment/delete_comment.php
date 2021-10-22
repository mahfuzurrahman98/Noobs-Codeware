<?php

include '../connection.php';
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    exit('<h1>Invalid page request</h1>');
}

$comment_id = $_POST['comment_id'];
$user_nm = $_POST['user'];
$origin = $_POST['origin'];
$origin_id = $_POST['origin_id'];
$img_path = $_POST['img_path'];

$qry_del = "DELETE FROM Comment WHERE Id = '{$comment_id}';";
$res_del = mysqli_query($con, $qry_del) or die('Deletion Failed!');

include 'load_comment.php';

?>