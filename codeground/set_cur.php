<?php

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    exit('<h1>Invalid page request</h1>');
}

include '../connection.php';
include 'security.php';

$uid = $_SESSION["Id"];

$lang = $_POST['lang'];
$code = $_POST['code'];
$code = str_replace('\n', '\\\\n' ,$code);
$code = str_replace('\t', '\\\\t' ,$code);
$code = str_replace('\r', '\\\\r' ,$code);
$input = $_POST['input'];
$theme = $_POST['theme'];
$font = $_POST['font'];
$tab= $_POST['tab'];

$qry = "UPDATE IDE SET 
	Language = '{$lang}',
	Source_Code = '{$code}',
	Input = '{$input}',
	Theme = '{$theme}',
	Font_Size = '{$font}',
	Tab_Width = '{$tab}'
	WHERE User_Id = {$uid};
";

mysqli_query($con, $qry);

?>