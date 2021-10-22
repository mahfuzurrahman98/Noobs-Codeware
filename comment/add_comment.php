<?php

include '../connection.php'; 
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    exit('<h1>Invalid page request</h1>');
}

$comment_content = trim(mysqli_real_escape_string($con, $_POST['comment_content']));
$user_nm = $_POST['user'];
$origin = $_POST['origin'];
$origin_id = $_POST['origin_id'];
$img_path = $_POST['img_path'];

if ($comment_content != '') {
	$qry_add = "INSERT INTO Comment(Content, _user, Origin, Origin_Id) VALUES('{$comment_content}', '{$user_nm}', '{$origin}', '{$origin_id}');";
	$res_add = mysqli_query($con, $qry_add) or die('Insertion Failed!');
}
include 'load_comment.php';

?>