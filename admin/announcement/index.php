<?php

include '../../connection.php';
include 'security.php';

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
                    <h3 class="text-success">Announcement</h3>
                </div>
                <div class="col-6 text-right">
                    <a class="btn btn-primary btn-sm" href="add.php"><b><i class="fas fa-plus"></i></b> Post new</a>
                </div>
            </div>
            <div class="Filter">
                <div class="row p-2">
                    <div class="col-6 form-group">
                        <label><b><i class="fas fa-search"></i> Title:</b></label>
                        <input type="text" id="tit" class="form-control form-control-sm" placeholder="Announcement Title" onkeyup="filterData()">
                    </div>
                    <div class="col-6 form-group">
                        <label><b><i class="fas fa-search"></i> Author:</b></label>
                        <input type="text" id="auth" class="form-control form-control-sm" placeholder="Announcement Author" onkeyup="filterData()">
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

        <div class="modal fade" data-keyboard="false" data-backdrop="static" id="dlt_ann" tabindex="-1"
            role="dialog" aria-labelledby="upd_updinfoLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content p-3">
                    <div class="modal-body text-center">
                        Are you sure want to delete this announcement?
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
            console.log('xy: ', xy);
            if (xy == 1) {
                $("#Prev").attr('class', 'page-item disabled');
            }
            else {
                $("#Prev").attr('class', 'page-item');
            }

            $(".show").html('Processing.....')
            $.ajax({
                url: "load.php",
                method: "POST",
                data: {
                    title: $("#tit").val(),
                    author: $("#auth").val(),
                    page: xy
                },
                success: function(response) {
                    if (response.length < 650) {
                        //console.log('len: ' + response.length);
                        $("#Next").attr('class', 'page-item disabled');
                        $(".show").html('<div class="h1 my-5 text-center text-danger">No result found!</div>')
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