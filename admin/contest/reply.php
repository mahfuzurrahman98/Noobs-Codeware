<?php

include '../../connection.php';
include 'security.php';

if (isset($_POST['rply'])) {
    $clar_id = $_POST['clar_id'];
    $announce = $_POST['announce'];

    $qry = "INSERT INTO Clarifi_Reply(Against, Ans) VALUES({$clar_id}, '{$announce}');";
    mysqli_query($con, $qry);

    $qry = "UPDATE Clarifi_Comment SET replied = 'yes' WHERE Cmnt_Id = {$clar_id};";
    mysqli_query($con, $qry);
}

?>