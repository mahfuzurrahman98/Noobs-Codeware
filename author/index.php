<?php

include '../connection.php';
include 'security.php';

if (!isset($_GET['id'])) {
    $id = 'p';
}
else {
    $id = $_GET['id'];
    if ($id != 't' && $id != 'c') {
        $id = 'p';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Author's Dashboard</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/select2.css">
</head>

<body>
    <?php include 'nav_bar.php' ?>
    <div class="container-fluid">
        <h1 class="text-success text-center my-5"><b>Author's Dashboard</b></h1>
        <div class="contents mt-5 mx-3 mx-lg-0">
            <div class="row justify-content-center">
                <div class="text-center col-12 col-lg-3 my-2 mx-5 p-3 shadow-lg bg-light rounded">
                    <i class="fas fa-code-branch fa-5x"></i>
                    <h1 class=""><b>Problems</b></h1>
                    <p class="h3">Total: 4</p>
                    <button class="add_btn mt-2 btn btn-success" data-toggle="modal" data-target="#add" id="add_prb">Set Problem</button>

                </div>

                <div class="text-center col-12 col-lg-3 my-2 mx-5 p-3 shadow-lg bg-light rounded">
                    <i class="fas fa-trophy fa-5x"></i>
                    <h1 class=""><b>Contests</b></h1>
                    <p class="h3">Total: 3</p>
                    <button class="add_btn mt-2 btn btn-success" data-toggle="modal" data-target="#add" id="add_cnt">Set Contest</button>
                </div>

                <div class="text-center col-12 col-lg-3 my-2 mx-5 p-3 shadow-lg bg-light rounded">
                    <i class="fas fa-chalkboard fa-5x"></i>
                    <h1 class=""><b>Tutorials</b></h1>
                    <p class="h3">Total: 3</p>
                    <a href="tutorial/add.php" class="mt-2 btn btn-success">Set Tutorial</a>
                </div>
            </div>
        </div>
        
        <nav class="mx-5 prb_info_tab fub">
            <div class="row p-2 shadow-lg bg-light rounded text-center justify-content-center mt-5 mb-5">
                <a href="index.php?id=p" class="nt col-12 my-1 col-lg-3 mx-2 my-lg-0 nav-link" role="tab" id="prb"><b>Problem</b></a>
                <a href="index.php?id=c" class="nt col-12 my-1 col-lg-3 mx-2 my-lg-0 nav-link" role="tab" id="cont"><b>Contest</b></a>
                <a href="index.php?id=t" class="nt col-12 my-1 col-lg-3 mx-2 my-lg-0 nav-link" role="tab" id="tut"><b>Tutorial</b></a>
            </div>
        </nav>

        <div class="show_content">
            <?php
            if ($id == 'p') {
                include 'my_prb.php';
            }
            else if ($id == 'c') {
                include 'my_cont.php';
            }
            else {
                include 'my_tut.php';
            }
            ?>
        </div>

        <div class="modal fade" data-backdrop="static" id="add" tabindex="-1" role="dialog" aria-labelledby="addtestLabel" aria-hidden="true">
            <div class="mdl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="text-dark btn btn-sm" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body xyz">
                        
                    </div>
                </div>
            </div>
        </div>
        <?php include '../footer.php'; ?>
    </div>
    
    <script src="../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="../js/select2.js" type="text/javascript"></script>

    <script>
        var track = '', flag = '';
        $(document).ready(function() {
            
            track = "<?php echo $id; ?>";
            console.log('track: ', track);
            if (track == 'p') {
                flag = 'prb';
                $('#prb').addClass('tab_active');
            }
            else if (track == 'c') {
                flag = 'tut';
                $('#cont').addClass('tab_active');
            }
            else {
                flag = 'tut';
                $('#tut').addClass('tab_active');
            }
            

            $(".add_btn").click(function() {
                y = $(this).attr('id');
                console.log('ccc: ', y);

                if (y == 'add_prb') {
                    $('.mdl').attr('class', 'mdl modal-dialog modal-dialog-centered');
                    $('.modal-title').html('Create new problem');
                    $.ajax({
                        url: "add_prb.php",
                        method: "POST",
                        success: function(response) {
                            $('.xyz').html(response);
                        }
                    });
                }
                else {
                    $('.modal-title').html('Set new contest');
                    $('.mdl').attr('class', 'mdl modal-dialog modal-lg modal-dialog-centered');
                    $.ajax({
                        url: "add_cont.php",
                        method: "POST",
                        success: function(response) {
                            $('.xyz').html(response);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>