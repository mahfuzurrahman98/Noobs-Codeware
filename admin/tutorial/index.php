<?php

include '../../connection.php';
include 'security.php';

$qry_up = "SELECT * FROM Tutorial;";
$res_up = mysqli_query($con, $qry_up) or die("Query Failed!");

?>
<script>var xy = 1;</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/sidebar.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="container-fluid">
        <div class="mt-5 mx-lg-5">
            <div class="row my-3">
                <div class="col-6 text-left">
                    <h3 class="text-success">Tutorial</h3>
                </div>
                <div class="col-6 text-right">
                    <a class="btn btn-primary btn-sm" href="add.php"><b><i class="fas fa-plus"></i></b> Write new</a>
                </div>
            </div>
            <div class="Filter">
                <div class="row p-2">
                    <div class="col-4 form-group">
                        <label><b><i class="fas fa-search"></i> Title:</b></label>
                        <input type="text" id="tit" class="form-control form-control-sm" placeholder="Tutorial Title" onkeyup="filterData()">
                    </div>
                    <div class="col-4 form-group">
                        <label><b><i class="fas fa-search"></i> Category:</b></label>
                        <select class="form-control form-control-sm" id="cat" onchange="filterData()">
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
                    <div class="col-4 form-group">
                        <label><b><i class="fas fa-search"></i> Author:</b></label>
                        <input type="text" id="auth" class="form-control form-control-sm" placeholder="Tutorial Author" onkeyup="filterData()">
                    </div>
                </div>
            </div>
            <div class="shadow-lg bg-light p-3 rounded">
                <table class="table table-sm show">
                    
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
        
        <div class="modal fade" data-keyboard="false" data-backdrop="static" id="dlt_tut" tabindex="-1"
            role="dialog" aria-labelledby="upd_updinfoLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content p-3">
                    <div class="modal-body text-center">
                        Are you sure want to delete this tutorial?
                    </div>
                    <div class="row px-2 mt-2">
                        <div class="col-6"><button class="btn btn-danger" onclick="del()">Yes</button></div>
                        <div class="col-6 text-right"><button class="btn btn-success" data-dismiss="modal" aria-label="Close">No</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="../../js/sidebar.js"></script>
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

            $(".show").html('<div class="h3 my-5 text-center text-dark">Processing.....</div>');
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
                    if (response.length < 550) {
                        console.log('len: ' + response.length);
                        $("#Next").attr('class', 'page-item disabled');
                        $(".show").html('<div class="h1 my-5 text-center text-danger">No result found!</div>');
                    }
                    else {
                        $(".show").html(response)
                        console.log('len: ' + response.length);
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