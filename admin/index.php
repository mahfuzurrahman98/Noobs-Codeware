<?php

include '../connection.php';
include 'security.php';

if (!isset($_GET['id'])) {
    $id = 'p';
}
else {
    $id = $_GET['id'];
    if ($id != 't') {
        $id = 'p';
    }
}

$qry = "SELECT Id FROM Problem;";
$tot_prb = mysqli_num_rows(mysqli_query($con, $qry));

$qry = "SELECT Id FROM Contest;";
$tot_cont = mysqli_num_rows(mysqli_query($con, $qry));

$qry = "SELECT Sub_Id FROM Submission;";
$tot_sub = mysqli_num_rows(mysqli_query($con, $qry));

$qry = "SELECT Id FROM Tutorial;";
$tot_tut = mysqli_num_rows(mysqli_query($con, $qry));

//my contribution
$qry = "SELECT Id FROM Problem WHERE Author = '{$_SESSION["Username"]}';";
$my_prb = mysqli_num_rows(mysqli_query($con, $qry));

$qry = "SELECT Sub_Id FROM Submission WHERE Username = '{$_SESSION["Username"]}';";
$my_sub = mysqli_num_rows(mysqli_query($con, $qry));

$qry = "SELECT Id FROM Contest WHERE Author LIKE '%/{$_SESSION["Username"]}/%';";
$my_cont = mysqli_num_rows(mysqli_query($con, $qry));

$qry = "SELECT Id FROM Tutorial WHERE Author = '{$_SESSION["Username"]}';";
$my_tut = mysqli_num_rows(mysqli_query($con, $qry));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/select2.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="container-fluid">
        <div class="contents mt-5">
            <h1 class="text-center mb-3"><b><u>Noob's Dashboard</u></b></h1>
            <div class="row justify-content-center px-3">
                <div class="text-center col-12 col-lg-5 my-3 mx-3 px-2 py-4 shadow-lg bg-warning round-b">
                    <i class="fas fa-code-branch fa-5x"></i>
                    <h2 class=""><b>Problems</b></h2>
                    <p class="h3">Total: <?php echo $tot_prb; ?></p>
                    <p class="mt-3 h5 text-white">My contributions: <?php echo $my_prb; ?></p>
                </div>

                <div class="text-center col-12 col-lg-5 my-3 mx-3 px-2 py-4 shadow-lg bg-success round-b">
                    <i class="fas fa-file-upload fa-5x"></i>
                    <h2 class=""><b>Submissions</b></h2>
                    <p class="h3">Total: <?php echo $tot_sub; ?></p>
                    <p class="mt-3 h5 text-white">My submissions: <?php echo $my_sub; ?></p>
                </div>

                <div class="text-center col-12 col-lg-5 my-3 mx-3 px-2 py-4 shadow-lg bg-purple round-b">
                    <i class="fas fa-trophy fa-5x"></i>
                    <h2 class=""><b>Contests</b></h2>
                    <p class="h3">Total: <?php echo $tot_cont; ?></p>
                    <p class="mt-3 h5 text-white">My contributions: <?php echo $my_cont; ?></p>
                </div>

                <div class="text-center col-12 col-lg-5 my-3 mx-3 px-2 py-4 shadow-lg bg-gray round-b">
                    <i class="fas fa-chalkboard fa-5x"></i>
                    <h2 class=""><b>Tutorials</b></h2>
                    <p class="h3">Total: <?php echo $tot_tut; ?></p>
                    <p class="mt-3 h5 text-white">My contributions: <?php echo $my_tut; ?></p>
                </div>
            </div>
        </div>

        <h2 class="my-5 mb-3 text-center"><b>User Request</b></h2>

        <nav class="mx-5 prb_info_tab shadow shadow-lg rounded ">
            <div class="row p-2 text-center bg-light justify-content-center mt-5 mb-5">
                <a href="index.php?id=p" class="nt col-12 my-1 col-lg-3 mx-2 my-lg-0 nav-link" role="tab" id="prb"><b>Problem</b></a>
                <a href="index.php?id=t" class="nt col-12 my-1 col-lg-3 mx-2 my-lg-0 nav-link" role="tab" id="tut"><b>Tutorial</b></a>
            </div>
        </nav>
        
        <div class="show_cont">
            <?php
            if ($id == 'p') {
                include 'req_prb.php';
            }
            else {
                include 'req_tut.php';
            }
            ?>
        </div>
    </div>
    
    <script src="../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="../js/sidebar.js" type="text/javascript"></script>

    <script>
        var track = '', flag = '';
        $(document).ready(function() {

            track = "<?php echo $id; ?>";
            if (track == 'p') {
                flag = 'prb';
                $('#prb').addClass('tab_active');
            }
            else {
                flag = 'tut';
                $('#tut').addClass('tab_active');
            }
        });
    </script>

</body>

</html>