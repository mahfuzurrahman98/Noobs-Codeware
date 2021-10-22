<?php

include '../connection.php';
include 'security.php';

if (!isset($_GET['y'])) {
    $y = 'f';
}
else {
    $y = $_GET['y'];
    if ($y != 'f' && $y != 'r' && $y != 'e') {
        $y = 'f';
    }
}
?>

<script> var xy = 1; </script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contests-Codeware</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include 'nav_bar.php'; ?>
    <div class="container-fluid">
        <div class="row my-5 mx-lg-5">
            <div class="col-12 col-lg-7">
                <h1 class="text-success text-center text-lg-left">Contest</h1>
            </div>
            <div class="col-12 col-lg-5">
                <input type="text" id="tit" class="form-control form-control-lg" placeholder="Search Contest" onkeyup="filterData()" style="border-radius: 25px;">
            </div>
        </div>
        <nav class="my-5 prb_info_tab mx-3 mx-lg-5">
            <div class="row px-3 py-1 shadow shadow-lg bg-light rounded text-center justify-content-center">
                <a class="col-12 col-lg-2 nav-link <?php if ($y == 'f'){echo 'tab_active';} ?>"
                    href="index.php?y=f" role="tab"><b>Featured</b></a>
                <a class="col-12 col-lg-2 nav-link <?php if ($y == 'r'){echo 'tab_active';} ?>"
                    href="index.php?y=r" role="tab"><b>Running</b></a>
                <a class="col-12 col-lg-2 nav-link <?php if ($y == 'e'){echo 'tab_active';} ?>"
                    href="index.php?y=e" role="tab"><b>Ended</b></a>
            </div>
        </nav>
        <table class="table table-light table-hover table-striped mb-5 h5 bg-light" style="border-radius: 15px; padding: 5px;">
            <thead>
                <tr class="trow">
                    <td class="px-3"><b>Title</b></td>
                    <td class="px-3"><b>Start</b></td>
                    <td class="px-3"><b>End</b></td>
                </tr>
            </thead>
            <tbody class="show"></tbody>
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

            $(".show").html('<tr><td></td><td>Processing.....</td><td></td></tr>');
            $.ajax({
                url: "load.php",
                method: "POST", 
                data: {
                    title: $("#tit").val(),
                    y: "<?php echo $y; ?>",
                    page: xy
                },
                success: function(response) {
                    console.log('len: ' + response.length);
                    if (response.length == 0) {
                        $("#Next").attr('class', 'page-item disabled');
                        $(".trow").html('');
                        $(".show").html('<div class="h1 my-5 text-center text-danger">No results found!</div>');
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