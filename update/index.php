<?php
include '../connection.php';
include 'security.php';
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

?>

<script>var xy = 1;</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Updates-Codeware</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include 'nav_bar.php'; ?>
    <div class="container-fluid">
        <div class="row my-5 mx-lg-5">
            <div class="col-12 col-lg-7">
                <h1 class="text-primary text-center text-lg-left">Updates</h1>
            </div>
            <div class="col-12 col-lg-5">
                <input type="text" id="tit" class="form-control form-control-lg" placeholder="Search..." onkeyup="filterData()" style="border-radius: 25px;">
            </div>
        </div>

        <div class="px-0 px-lg-5">
            <table class="table bg-light table-hover rounded">
                <tbody class="show">

                </tbody>
            </table>
        </div>

        <div class="my-5 justify-content-center d-flex">
            <ul class="pagination shadow shadow-lg rounded-pill">
                <li id="Prev" class="page-item"><button data-id="prv" class="page-link">Prev</button></li>
                <li class="page-item disabled"><button id="cur_pg" class="page-link text-success">1</button></li>
                <li id="Next" class="page-item"><button data-id="nxt" class="page-link">Next</button></li>
            </ul>
        </div>
        <?php include '../footer.php'; ?>
    </div>
    <script src="../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script>
        $(".page-link").click(function() {
            var z = $(this).attr('data-id');
            if (z == "prv") { xy--; }
            else if (z == "nxt") { xy++; }
            $('#cur_pg').html(xy);
            loadData();
        });
        function filterData() {
            xy = 1;
            loadData();
        }
        function loadData() {
            if (xy == 1) {
                $("#Prev").attr('class', 'page-item disabled');
            }
            else {
                $("#Prev").attr('class', 'page-item');
            }

            $(".show").html('<h1 class="text-center mt-2">Processing...</h1>');

            $.ajax({
                url: "load.php",
                method: "POST",
                data: {
                    title: $("#tit").val(),
                    page: xy
                },
                success: function(response) {
                    if (response.length == 0) {
                        $("#Next").attr('class', 'page-item disabled');
                        $(".show").html('<div class="h1 my-5 text-center text-danger">No results found!</div>')
                    }
                    else {
                        $(".show").html(response)
                        $("#Next").attr('class', 'page-item');
                    }
                }
            })
        }
        $(document).ready(function() {
            loadData();
        });
    </script>
</body>

</html>