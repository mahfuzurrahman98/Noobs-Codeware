<?php

if ($_SESSION['Role'] == 0) {
    header("Location: ../../index.php");
}
if (!isset($_SESSION['Username'])) {
    header("Location: ../../login.php");
}

?>