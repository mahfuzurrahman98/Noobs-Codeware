<?php

include '../connection.php';
include 'security.php';

$unm = $_GET['user'];
$you = TRUE;
$f_cf = 1;
$f_uv = 1;

if ($_SESSION['Username'] != $unm) {
    $you = FALSE;
}

$qry = "SELECT Name, Uva_Handle, CF_Handle FROM User WHERE Username = '{$unm}';";
$res = mysqli_query($con, $qry) or die("Query Failed!");

while ($row = mysqli_fetch_assoc($res)) {
    $u_UVa_Handle= $row['Uva_Handle'];
    $u_CF_Handle = $row['CF_Handle'];
    $u_Name = $row['Name'];
}

//Uva Part
include 'get_uva.php';

//CF Part
include 'get_cf.php';

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OJ Stats-Codeware</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
    .uv {
        color: brown;
    }
    .cf_rr {
        color : black;
    }
    .cf {
        color: rgb(186, 140, 16);
    }
    .project-tab #tabs {
        background: #007b5e;
        color: #eee;
    }

    .project-tab #tabs h6.section-title {
        color: #eee;
    }

    .project-tab #tabs .nav-tabs .nav-item.show .nav-link,
    #nav-cf-tab {
        color: #89970d;
        background-color: transparent;
        font-size: 16px;
        font-weight: bold;
    }
    #nav-uva-tab {
        color: #81320e;
        background-color: transparent;
        font-size: 16px;
        font-weight: bold;
    }

    .nav-tabs .nav-link.tab_active {
        color: #387506;
        background-color: transparent;
        border-bottom: 3px solid !important;
        font-size: 16px;
        font-weight: bold;
    }
    .project-tab .nav-link {
        border: 1px solid transparent;
        border-top-left-radius: .25rem;
        border-top-right-radius: .25rem;
        color: #067515;
        font-size: 16px;
        font-weight: 600;
    }

    .project-tab .nav-link:hover {
        border: none;
    }

    .project-tab thead {
        background: #f3f3f3;
        color: #333;
    }

    .project-tab a {
        text-decoration: none;
        color: #333;
        font-weight: 600;
    }
    </style>
</head>

<body>
    <?php include '../nav_bar.php'; ?>
    <div class="container-fluid">
        <?php
        if ($you) {
            echo '<h3 class="text-center text-primary font-weight-bold mb-1 mt-3">My Statistics</h3>';
        }
        else {
            echo '<h3 class="text-center text-primary font-weight-bold mb-1 mt-3">' . $u_Name . '</h3>';
        }
        ?>
        <div class="project-tab">
            <nav class="mx-5">
                <div class="row p-2 shadow-lg rounded bg-light text-center nav nav-tabs justify-content-center mt-5 mb-5" id="nav-tab" role="tablist">
                    <a class="col-12 my-1 col-lg-3 mx-2 my-lg-0 nav-link tab_active" id="nav-uva-tab" data-toggle="tab"
                        href="#nav-details" role="tab" aria-controls="nav-details"
                        aria-selected="true"><b>Uva</b></a>
                    <a class="col-12 my-1 col-lg-3 mx-2 my-lg-0 nav-link" id="nav-cf-tab" data-toggle="tab"
                        href="#nav-subs" role="tab" aria-controls="nav-subs" aria-selected="false"><b>Codeforces</b></a>
                </div>
            </nav>
            <div class="tab-content mb-5" id="nav-tabContent">
                <div class="tab-pane fade show " id="nav-details" role="tabpanel">
                <?php
                if ($f_uv == 1) {
                    $file_uv = file_get_contents('uva_stat.php');
                    $content_uv = eval("?>$file_uv");
                    echo $content_uv;
                }
                else {
                    if ($you) {
                        $up = '<a href="setting.php" class="btn btn-success ml-2" role="button" aria-pressed="true">Update</a>';
                        echo '<div class="alert alert-danger">Your UVa username is either invalid or not added. Please update your profile' . $up . '</div>';
                    }
                    else {
                        echo '<div class="alert alert-danger">UVa username is either invalid or not provided.</div>';
                    }
                }
                ?>
                </div>
                
                <div class="tab-pane" id="nav-subs" role="tabpanel">
                <?php
                if ($f_cf == 1) {
                    $file_cf = file_get_contents('cf_stat.php');
                    $content_cf = eval("?>$file_cf");
                    echo $content_cf;
                }
                else {
                    if ($you) {
                        $up = '<a href="setting.php" class="btn btn-success ml-2" role="button" aria-pressed="true">Update</a>';
                        echo '<div class="alert alert-danger">Your UVa username is either invalid or not added. Please update your profile' . $up . '</div>';
                    }
                    else {
                        echo '<div class="alert alert-danger">Codeforces username is either invalid or not provided.</div>';
                    }
                }
                echo '<div class="mb-5"></div>';
                ?>
                </div>
            </div>
            <?php include '../footer.php'; ?>
        </div>
               
        <script src="../js/jquery-3.6.0.js" type="text/javascript"></script>
        <script src="../js/bootstrap.bundle.js" type="text/javascript"></script>
    </div>
    
</body>
</html>