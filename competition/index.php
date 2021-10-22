<?php
include '../connection.php'; 
include 'security.php';
//include 'participant_validate.php';
?>

<script>
    var xy = 1;
    var tag_arr = [];
</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contest-Admin Panel</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container-fluid">
        <?php include 'nav_bar.php'; ?>
        <div class="mt-5 mx-lg-5">
            <form class="row p-2">
                <div class="col-8 form-group">
                    <label><b><i class="fas fa-search"></i> Title:</b></label>
                    <input type="text" id="tt" class="form-control form-control-sm" placeholder="Enter contest title" onkeyup="filterData()">
                </div>
                <div class="col-4 form-group">
                    <label><b><i class="fas fa-search"></i> Status:</b></label>
                    <select id="st" class="form-control form-control-sm" onchange="filterData()">
                        <option value="%">All</option>
                        <option value="Featured">Featured</option>
                        <option value="Running">Running</option>
                        <option value="Ended">Ended</option>
                    </select>
                </div>
            </form>

            <table class="table table-light table-hover table-striped mb-5 h5 bg-light" style="border-radius: 15px; padding: 5px;">
                <thead>
                    <tr class="trow">
                        <td class="px-3"><b>Title</b></td>
                        <td class="px-3"><b>Start</b></td>
                        <td class="px-3"><b>End</b></td>
                    </tr>
                </thead>
                <tbody class="show">

                </tbody>
            </table>

            <div class="mb-5 justify-content-center d-flex">
                <ul class="pagination">
                    <li id="Prev" class="page-item"><button data-id="prv" class="page-link">Prev</button></li>
                    <li><button data-id="1" class="page-link">1</button></li>
                    <li><button data-id="2" class="page-link">2</button></li>
                    <li><button data-id="3" class="page-link">3</button></li>
                    <li><button class="btn btn-light">...</button></li>
                    <li id="Next" class="page-item"><button data-id="nxt" class="page-link">Next</button></li>
                </ul>
            </div>
        </div>
    </div>
    <script src="../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="../js/sidebar.js" type="text/javascript"></script>
    
    <script>
        $(document).ready(function(){
            loadData();
        });
        $(".page-link").click(function() {
            var z = $(this).attr('data-id');
            if (z == "prv") { xy--; }
            else if (z == "1") { xy = 1; }
            else if (z == "2") { xy = 2; }
            else if (z == "3") { xy = 3; }
            else if (z == "nxt") { xy++; }
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

            $(".show").html('Processing.....')
            $.ajax({
                url: "load.php",
                method: "POST",
                data: {
                    tit: $("#tt").val(),
                    stat: $("#st").val(),
                    page: xy
                },
                success: function(response) {
                    //console.log(title, ' | ', diff, ' | ', tags);
                    // if (response.length < 600) {
                    //     //console.log('len: ' + response.length);
                    //     $("#Next").attr('class', 'page-item disabled');
                    //     $(".trow").html('');
                    //     $(".show").html('<div class="h1 my-5 text-center text-danger">No result found!</div>');
                    // }
                    // else {
                         $(".show").html(response)
                         console.log('len: ' + response.length);
                    //     $("#Next").attr('class', 'page-item');
                    // }
                }
            });
        }
    </script>
</body>
</html>