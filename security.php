<?php

define('noob', true);

if (!isset($_SESSION["Username"])) {
	header("Location: login.php");
}

?>