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
    <title>Tutorail-Codeware</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include 'nav_bar.php'; ?>
    <div class="container-fluid">
        <div class="text-center my-5">
            <span class="text-dark"><i class="fas fa-book fa-2x"></i></span>
            <span class="text-success font-weight-bold h3"> Tutorials</span>
        </div>
        <div class="row">
            <div class="col-12 col-lg-4 row px-5">
                <div class="col-12 form-group">
                    <label><b><i class="fas fa-search"></i> Title:</b></label>
                    <input type="text" id="tit" class="form-control" placeholder="Tutorial Title" onkeyup="filterData()">
                </div>
                <div class="col-12 form-group">
                    <label><b><i class="fas fa-search"></i> Category:</b></label>
                    <select class="form-control" id="cat" onchange="filterData()">
                        <option selected value="All">All</option>
                        <option value="Algorithm">Algorithm</option>
                        <option value="Data Structure">Data Structure</option>
                        <option value="Graph Theory">Graph Theory</option>
                        <option value="Dynamic Programming">Dynamic Programming</option>
                        <option value="Greedy">Greedy</option>
                        <option value="Game Theory">Game Theory</option>
                        <option value="OJ Problems Editorial">OJ Problems Editorial</option>
                        <option value="Programming Language">Programming Language</option>
                        <option value="Computer Science">Computer Science</option>
                        <option value="Science & Technology">Science & Technology</option>
                        <option value="Number Theory">Number Theory</option>
                        <option value="Combinatorics">Combinatorics</option>
                        <option value="Geomeatry">Geomeatry</option>
                        <option value="Math">Math</option>
                        <option value="Statistics">Statistics</option>
                        <option value="Numerical Analysis">Numerical Analysis</option>
                        <option value="Tools & Tips">Tools & Tips</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="col-12 form-group">
                    <label><b><i class="fas fa-search"></i> Author:</b></label>
                    <input type="text" id="auth" class="form-control" placeholder="Tutorial Author" onkeyup="filterData()">
                </div>
            </div>
            
            <div class="col-12 col-lg-8">
                <table class="table bg-light rounded">
                    <tbody class="show">

                    </tbody>
                </table>
            </div>           
        </div>
        <div class="my-5 justify-content-center d-flex">
            <ul class="pagination shadow shadow-lg bg-light">
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
                    category: $("#cat").val(),
                    author: $("#auth").val(),
                    page: xy
                },
                success: function(response) {
                    if (response.length == 0) {
                        $("#Next").attr('class', 'page-item disabled');
                        $(".show").html('<div class="h1 my-5 text-center ml-lg-5 text-lg-left text-danger">No results found!</div>')
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