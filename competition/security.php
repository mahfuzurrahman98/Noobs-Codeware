<?php

if (!isset($_SESSION["Username"])) {
	header("Location: ../login.php");
}

?>