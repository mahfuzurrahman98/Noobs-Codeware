<?php

include '../../connection.php';
include 'security.php';

$id = $_GET['id'];
$qry = "SELECT * From User_Contest WHERE Id = '{$id}';";
$res = mysqli_query($con, $qry) or die('Errorrrrr');

while($row = mysqli_fetch_assoc($res)) {
    $title = $row['Title'];
    $desc = $row['Description'];
    $rule = $row['Rules'];
    $start_tym = gmdate('Y-m-d\TH:i:s', strtotime($row['Start_Time']));
    $end_tym = gmdate('Y-m-d\TH:i:s', strtotime($row['Finish_Time']));
    $freeze_tym = gmdate('Y-m-d\TH:i:s', strtotime($row['Freeze_Time']));
    $problems = explode(' ', $row['Problems']);
    $scores = explode(' ', $row['Scores']);
    $judges = $row['Judges'];
    $contestants = $row['Contestants'];
}   

$prb_num = 'A';
$prb_count = count($problems) + 1;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <?php include 'nav_bar.php';?>
    <div class="container-fluid">
        <div class="my-5">
            <h2 class="text-success text-center my-3">Settings - <?php echo $title; ?></h2>
        </div>
        <div class="alert alert-warning">In case you don't want freeze the rank list after certain time, keep the freeze time same as finish time.</div>
        <div class="shadow bg-white rounded p-3">
            <h3 class="text-success text-center">Basic Info</h3>
            <form class="row p-2">
                <div class="col-12 form-group">
                    <label><b>Title:</b></label>
                    <input type="text" class="form-control" id="tit" value="<?php echo $title; ?>">
                </div>
                <div class="col-12 col-lg-4 form-group">
                    <label><b>Start Time:</b></label>
                    <input type="datetime-local" class="form-control" id="stym" value="<?php echo $start_tym; ?>">
                </div>
                <div class="col-12 col-lg-4 form-group">
                    <label><b>End Time:</b></label>
                    <input type="datetime-local" class="form-control" id="etym" value="<?php echo $end_tym; ?>">
                </div>
                <div class="col-12 col-lg-4 form-group">
                    <label><b>Rank Freeze Time:</b></label>
                    <input type="datetime-local" class="form-control" id="ftym" value="<?php echo $freeze_tym; ?>">
                </div>
                <div class="col-12 form-group">
                    <label><b>Edit Description:</b></label>
                    <textarea class="form-control" id="xyz"><?php echo $desc; ?></textarea>
                </div>
                <div class="col-12 form-group">
                    <label><b>Edit Rules:</b></label>
                    <textarea class="form-control" id="zyx"><?php echo $rule; ?></textarea>
                </div>
                <div class="col-12 form-group">
                    <label><b>Edit Judges:</b></label>
                    <input type="text" class="form-control" id="judg" value="<?php echo substr(substr($judges, 1), 0, -1); ?>">
                </div>
                <div class="col-12 form-group">
                    <label><b>Edit Contestants:</b></label>
                    <textarea class="form-control" id="contestants"><?php echo substr(substr($contestants, 1), 0, -1); ?></textarea>
                </div>
            </form>
        </div>

        <div class="mt-5 mx-lg-5 bg-white rounded p-3">
            <div class="text-center text-success">
                <h3><b>Problemset</b></h3>
            </div>
            <div id="Problemset" class="px-lg-5">
            <?php for ($i = 0; $i < count($problems); $i++) { ?>
                <div id="ProblemDiv<?php echo $i + 1; ?>">
                    <div class="row mt-3">
                        <div class="col-1">
                            <b><?php echo $prb_num; $prb_num++; ?>:</b>
                        </div>
                        <div class="col-7">
                            <input type="text" id="prb<?php echo $i + 1; ?>" class="form-control form-control-lg bg-dark text-white" value="<?php echo $problems[$i]; ?>" placeholder="Enter the problem id" required>
                        </div>
                        <div class="col-3">
                            <input type="text" id="scr<?php echo $i + 1; ?>" class="form-control form-control-lg bg-dark text-white" value="<?php echo $scores[$i]; ?>" placeholder="Score" required>
                        </div>
                    </div>
                </div>
            <?php } ?>
            </div>
            <div class="mt-3 text-right">
                <button class="mx-1 btn btn-primary btn-lg rounded-pill" id="addProblem" data-toggle="tooltip" title="Add another problem">
                    <b><i class="fas fa-plus"></i></b>
                </button>
                <button class="mx-1 btn btn-danger btn-lg rounded-pill" id="rmvLast" data-toggle="tooltip" title="Remove the last problem">
                    <b><i class="fas fa-trash"></i></b>
                </button>
            </div>
        </div>
        <div class="mt-3 mb-5 text-center">
            <button class="btn btn-lg btn-success" id="set" data-toggle="modal" data-target="#set_cont"><b>Update Contest</b></button>

        <div class="my-5 text-center">
            <hr>
            <div class="mt-5 h5 alert alert-danger">In case this contest is unnecessary now or created for testing purposes, you can delete it.
                <button class="ml-1 btn btn-sm btn-danger" data-toggle="modal" data-target="#dlt_cont"><b>Delete Contest</b></button>
            </div>
        </div>
            
        </div>
        <div class="modal fade" data-backdrop="static" id="set_cont" tabindex="-1" role="dialog" aria-labelledby="addtestLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Message</h5>
                        <button type="button" class="text-dark btn btn-sm" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body mdl_msg text-center">
                
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" data-backdrop="static" id="dlt_cont" tabindex="-1" role="dialog" aria-labelledby="addtestLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete this contest</h5>
                        <button type="button" class="text-dark btn btn-sm" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="my-3 text-center h4">
                            <b>Are you sure?</b>
                        </div>
                        <form class="row" action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                            <div class="col-6 text-left">
                                <button class="btn btn-danger" type="submit" name="dlt_cont_btn">Yes</button>
                            </div>
                            <div class="col-6 text-right">
                                <button class="btn btn-success" type="button" data-dismiss="modal">No</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
        <?php include '../../footer.php'; ?>
    </div>

    <?php
    if (isset($_POST['dlt_cont_btn'])) {
        $qry = "DELETE FROM Contest WHERE Id = '{$id}';";
        mysqli_query($con, $qry);

        $qry = "DELETE FROM Contest_Submission WHERE Contest_Id = '{$id}';";
        mysqli_query($con, $qry);

        echo "<script>
            window.history.replaceState(null, null, window.location.href);
            window.location.reload();
            alert('Contest deleted successfully!');
            window.location.href = 'index.php';
        </script>";
    }
    ?>

    <script src="../../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="../../js/sidebar.js" type="text/javascript"></script>
    <script src="../../ckeditor/ckeditor.js"></script>
    <script src="../../ckfinder/ckfinder.js"></script>
    <script type="text/javascript">
        CKFinder.setupCKEditor(CKEDITOR.replace('xyz'));
        CKFinder.setupCKEditor(CKEDITOR.replace('zyx'));
        $(document).ready(function() {
            var counter = <?php echo $prb_count; ?> ;
            console.log('counter_pre:', counter);
            $("#addProblem").click(function () {
                if(counter > 12) {
                    alert("Maximum 12 problems are allowed");
                    return false;
                }

                var newProblemDiv = $(document.createElement('div')).attr("id", 'ProblemDiv' + counter);
                newProblemDiv.after().html(
                    '<div class="row mt-3">'+
                        '<div class="col-1">'+ 
                            '<b>' + String.fromCharCode(64 + counter) + ':</b>' +
                        '</div>'+
                        '<div class="col-7">'+
                            '<input type="text" id="prb' + counter + '"' + 'class="form-control form-control-lg bg-dark text-white" placeholder="Enter the problem id" required>'+
                        '</div>'+
                        '<div class="col-3">'+
                            '<input type="text" id="scr' + counter + '"' + ' class="form-control form-control-lg bg-dark text-white" value="1" placeholder="Score" required>'+
                        '</div>'+
                    '</div>'
                );

                newProblemDiv.appendTo("#Problemset");
                counter++;
            });

            $("#rmvLast").click(function () {
                if(counter == 2) {
                    alert("Contest should have at least one problem");
                    return false;
                }
                counter--;
                $("#ProblemDiv" + counter).remove();

            });

            $("#set").click(function() {
                console.log('counter:', counter);
                var problems = '', scores = '';
                var flag = true;
                for(i = 1; i < counter; i++) {
                    if ($('#prb' + i).val() == '' || $('#scr' + i).val() == '') {
                        flag = false;
                    }
                    problems = problems + $('#prb' + i).val().trim() + ' ' ;
                    scores = scores + $('#scr' + i).val().trim() + ' ';
                }
                problems = problems.trim();
                scores = scores.trim();

                console.log('problems:', problems);
                if (flag) {
                    $.ajax({
                        url: "upd.php",
                        method: "POST",
                        data: {
                            id: "<?php echo $id; ?>",
                            title: $("#tit").val(),
                            prev_title: "<?php echo $title; ?>",
                            start: $("#stym").val(),
                            end: $("#etym").val(),
                            freeze: $("#ftym").val(),
                            desc: CKEDITOR.instances['xyz'].getData(),
                            rule: CKEDITOR.instances['zyx'].getData(),
                            probs: problems,
                            scores: scores,
                            judges: $("#judg").val(),
                            contestants: $("#contestants").val()
                        },
                        success: function(response) {
                            console.log(response);
                            $('.mdl_msg').html(response);
                        }
                    });
                }
                else {
                    $('.mdl_msg').html('<h4 class="text-danger mb-3">Any of the problems or scores field is empty</h4><button class="btn btn btn-danger" data-dismiss="modal"aria-label="Close">Close</button>');
                }
            });
        });
    </script>
</body>

</html>