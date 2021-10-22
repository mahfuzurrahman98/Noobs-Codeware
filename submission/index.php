<?php

include '../connection.php';
include 'security.php';

?>

<script> var xy = 1; </script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission-Codeware</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include 'nav_bar.php'; ?>
    <div class="container-fluid">
		<h2 class="mt-4 mb-3 text-center text-success"><b>Live Status</b></h2>
        <div class="Filter">
            <div class="row p-2">
				<div class="col-3 form-group">
                    <label><b>Title:</b></label>
                    <input type="text" id="tit" class="form-control form-control-sm" placeholder="Problem Title" onkeyup="filterData()">
                </div>
                <div class="col-3 form-group">
                    <label><b>Username:</b></label>
                    <input id="unm" class="form-control form-control-sm" list="usr" placeholder="Username" onkeyup="filterData()"></label>
					<datalist id="usr">
						<option selected value="All">
						<option value="My Only">
						<option value="Friends Only">
					</datalist>
                </div>
				<div class="col-3 form-group">
					<label><b>Verdict:</b></label>
					<select id="ver" class="form-control form-control-sm" onchange="filterData()">
						<option selected value="%">All</option>
						<option value="Accepted">Accepted</option>
						<option value="WA">Wrong Answer</option>
                        <option value="TLE">Time Limit Exceeded</option>
                        <option value="MLE">Memory Limit Exceeded</option>
						<option value="RE">Runtime Error</option>
						<option value="Compilation Error">Compilation Error</option>
					</select>
				</div>
                <div class="col-3 form-group">
					<label><b>Language:</b></label>
					<select id="lang" class="form-control form-control-sm" onchange="filterData()">
                        <option selected value="%">All</option>
						<option value="C">C</option>
						<option value="C++">C++</option>
                        <option value="Java">Java</option>
						<option value="Python">Python</option>
					</select>
				</div>
            </div>
        </div>
        
        <table class="table table-sm table-hover table-striped p-2 mb-5">
            <thead>
                <tr class="trow">
                    <td><b>Submission</b></td>
                    <td><b>Problem</b></td>
                    <td><b>Username</b></td>
                    <td><b>Verdict</b></td>
                    <td><b>Language</b></td>
                    <td><b>Time</b></td>
                    <td><b>Memory</b></td>
                    <td><b>When</b></td>
                </tr>
            </thead>
            <tbody class="show">

            </tbody>
        </table>

        <div class="modal fade" data-backdrop="static" id="show_code" tabindex="-1" role="dialog" aria-labelledby="addtestLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Submission</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body xyz">
                
                    </div>
                </div>
            </div>
        </div>

        <div class="my-5 justify-content-center d-flex">
            <ul class="pagination shadow shadow-lg bg-light">
                <li id="Prev" class="page-item"><button data-id="prv" class="page-link">Prev</button></li>
                <li class="page-item disabled"><button id="cur_pg" class="page-link text-success">1</button></li>
                <li id="Next" class="page-item"><button data-id="nxt" class="page-link">Next</button></li>
            </ul>
        </div>
        <?php include 'footer.php'; ?>
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
            console.log('xy: ', xy);
            if (xy == 1) {
                $("#Prev").attr('class', 'page-item disabled');
            }
            else {
                $("#Prev").attr('class', 'page-item');
            }

            $(".show").html(
                '<tr class="h4 text-secondary">' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td>Processing.....</td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                '</tr>'
            );
            $.ajax({
                url: "load.php",
                method: "POST",
                data: {
                    username: $("#unm").val(),
                    title: $("#tit").val(),
                    verdict: $("#ver").val(),
                    language: $("#lang").val(),
                    page: xy
                },
                success: function(response) {
                    if (response.length < 600) {
                        $("#Next").attr('class', 'page-item disabled');
                        $(".trow").html('');
                        $(".show").html('<div class="h1 my-5 text-center text-danger">No results found!</div>');
                    }
                    else {
                        $(".show").html(response);
                        $("#Next").attr('class', 'page-item');
                    }
                }
            });
        }
        $(document).ready(function() {
            loadData();
        });
    </script>
</body>

</html>