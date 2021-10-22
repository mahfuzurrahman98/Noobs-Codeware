<?php

include '../connection.php';
include 'security.php';

if (!isset($_GET['id'])) {
    exit('No such page found!');
}
$tid = $_GET['id'];
$unm = $_SESSION['Username'];
$qry_tut = "SELECT * FROM Tutorial WHERE Id = $tid AND Approved = 'No';";
$res_tut = mysqli_query($con, $qry_tut) or exit('<h1>No such tutorials found</h1>');
if (mysqli_num_rows($res_tut) == 0) {
    exit('No such tutorial found!');
}

while ($row = mysqli_fetch_assoc($res_tut)) {
    $tut_tit = $row['Title'];
    $tut_content = $row['Content'];
    $tut_auth = $row['Author'];
    $tut_cat = $row['Category'];
    $tut_tym = $row['Added_Time'];
}

$qry_author = "SELECT Username FROM User WHERE Username = '{$tut_auth}';";
$res_author = mysqli_query($con, $qry_author);

$author_nm = '';
if (mysqli_num_rows($res_author) > 0) {
    $row = mysqli_fetch_assoc($res_author);
    $author_nm = $row['Username'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tut_tit; ?></title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/sidebar.css">
</head>

<body>
    <?php include 'sidebar.php';?>
    <div class="container-fluid">
        <div class="mt-5 mx-lg-5">
            <h3 class="my-3 mt-3"><b> <?php echo $tut_tit ?></b> </h3>
            <div class="row">
                <div class="col-8">
                    <?php
                    echo 'Category: ' . $tut_cat . '<br>';
                    echo 'Requested By: ';
                    if ($author_nm) {
                        echo '<a href="../profile.php?user=' . $tut_auth . '">' . $tut_auth . '</a>';
                    }
                    else {
                        echo $tut_auth;
                    }
                    ?>
                    <div>Requested On: <?php echo date('M j Y, g:i A', strtotime($tut_tym)); ?></span></div>
                </div>
                <div class="col-4 text-right">
                    <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                        <button type="submit" name="app" class="btn btn-success my-1">Approve</button>
                        <button type="submit" name="rmv" class="btn btn-danger">Decline</button>
                    </form>
                </div>
            </div>
            <div class="shadow bg-light rounded p-4 mt-3 mb-5">
                <?php echo $tut_content; ?>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['app'])) {
        $qry = "UPDATE Tutorial SET Approved = 'Yes' WHERE Id = {$tid};";
        mysqli_query($con, $qry);
        echo '<script>
            window.history.replaceState(null, null, "index.php?id=t");
            window.location.reload();
        </script>';
    }
    if (isset($_POST['rmv'])) {
        $qry = "DELETE FROM Tutorial WHERE Id = {$tid};";
        mysqli_query($con, $qry);
        echo '<script>
            window.history.replaceState(null, null, "index.php?id=t");
            window.location.reload();
        </script>';
    }
    ?>
    
    <script src="../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="../js/sidebar.js" type="text/javascript"></script>
</body>

</html>