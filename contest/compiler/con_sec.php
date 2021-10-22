<?php

$con = mysqli_connect("localhost", "root", "Password@9859", "Noobs_Codeware") or die("Connection failed: " . mysqli_connect_error());
session_start();
if (!isset($_SESSION["Username"])) {
	header("Location: login.php");
}

?>