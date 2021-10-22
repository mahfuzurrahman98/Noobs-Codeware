<?php

include '../../connection.php';
include 'security.php';

if (!isset($_GET['id'])) {
    exit('No such page found!');
}
$tid = $_GET['id'];
$unm = $_SESSION['Username'];
$qry_tut = "SELECT * FROM Tutorial WHERE Id = $tid;";
$res_tut = mysqli_query($con, $qry_tut) or exit('No such tutorial found!');
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
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-9">
                <div class="mt-5">
                    <h3 class="my-3 mt-3"><b> <?php echo $tut_tit ?></b> </h3>
                    <div class="row">
                        <div class="col-12"><?php echo 'Category: ' . $tut_cat . '<br>'; ?></div>
                        <div class="col-12">
                            <i class="fas fa-user-secret"></i>
                            <?php
                            echo 'Author: ';
                            if ($author_nm) {
                                echo '<a href="../../profile.php?user=' . $tut_auth . '">' . $tut_auth . '</a>';
                            }
                            else {
                                echo $tut_auth . '<br>';
                            }
                            ?>
                        </div>
                        <div class="col-12">
                            <div><i class="far fa-calendar-alt"></i> <span class="text-info">
                                    <?php echo date('M j Y, g:i A', strtotime($tut_tym)); ?></span></div>
                        </div>
                    </div>
                    <div class="shadow bg-light rounded p-4 mt-3 mb-5">
                        <?php echo $tut_content; ?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3 mt-lg-5 text-center">
                <div class="p-3 my-3 rounded bg-primary"><a class="text-white font-weight-bold btn btn-lg" href="edit.php?id=<?php echo $tid; ?>">Edit</a></div>
                <div class="p-3 my-3 rounded bg-danger"><button class="text-white font-weight-bold btn btn-lg" data-toggle="modal" data-target="#dlt_tut">Delete</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" data-keyboard="false" data-backdrop="static" id="dlt_tut" tabindex="-1"
        role="dialog" aria-labelledby="upd_updinfoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content p-3">
                <div class="modal-body text-center">
                    Are you sure want to delete this tutorial?
                </div>
                <form class="row px-2 mt-2" ction="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                    <div class="col-6"><button class="btn btn-danger" type="submit" name="yes">Yes</button></div>
                    <div class="col-6 text-right"><button class="btn btn-success" data-dismiss="modal" aria-label="Close">No</button></div>
                </form>
            </div>
        </div>
    </div>

    <?php
        if (isset($_POST['yes'])) {
            $qry = "DELETE FROM Tutorial WHERE Id = {$tid};";
            mysqli_query($con, $qry);
            $qry = "DELETE FROM Comment WHERE Origin = 'tutorial' AND Origin_Id = {$tid};";
            mysqli_query($con, $qry);
            echo '<script>
                window.history.replaceState(null, null, "../");
                window.location.reload();
                alert("Tutorial deleted successfully!");
            </script>';
        }
    ?>

    <script src="../../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="../../js/nav_bar.js" type="text/javascript"></script>
</body>

</html>