<?php

include '../../connection.php';
if (!isset($_SESSION["Username"])) {
    header("Location: ../../login.php");
    exit();
}

$tim = microtime(true);
$unm = $_SESSION["Username"];
$pid = $_POST['pid'];
$ptit = $_POST['ptit'];
$lang = $_POST['language'];
$code = $_POST['code'];
$fs = 0;

$code = str_replace('\n', '\\\\n' ,$code);
$code = str_replace('\r', '\\\\r' ,$code);
$code = str_replace('\t', '\\\\t' ,$code);

//Insert into submission table
$qry = "INSERT INTO Submission(Problem_Id, Problem_Title, Username, Source_Code, Verdict, Language, Time, Memory, Source_Size, Sub_Time) VALUES('{$pid}', '{$ptit}', '{$unm}', '{$code}', 'In queue', '{$lang}', 0.00, 0.00, 0.00, {$tim});";
mysqli_query($con, $qry);

$qry = "SELECT Sub_Id FROM Submission WHERE Sub_Time = {$tim};";
$res = mysqli_query($con, $qry);

echo mysqli_fetch_assoc($res)['Sub_Id'];

?>