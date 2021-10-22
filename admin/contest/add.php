<?php

include '../../connection.php';
include 'security.php';

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
    <link rel="stylesheet" href="../../css/sidebar.css">
</head>

<body>
    <?php include 'sidebar.php';?>
    <div class="container-fluid">
        <div class="my-5">
            <h1 class="text-success text-center my-3">Create contest</h1>
        </div>
        <div class="shadow bg-white rounded p-3">
            <h3 class="text-success text-center">Basic Info</h3>
            <div class="row p-2">
                <div class="col-12 form-group">
                    <label><b>Title:</b></label>
                    <input type="text" class="form-control" id="tit" placeholder="Contest's title" >
                </div>
                <div class="col-12 col-lg-4 form-group">
                    <label><b>Start Time:</b></label>
                    <input type="datetime-local" class="form-control" id="stym" >
                </div>
                <div class="col-12 col-lg-4 form-group">
                    <label><b>Freeze Time:</b></label>
                    <input type="datetime-local" class="form-control" id="ftym" >
                </div>
                <div class="col-12 col-lg-4 form-group">
                    <label><b>End Time:</b></label>
                    <input type="datetime-local" class="form-control" id="etym" >
                </div>
                <div class="col-12 form-group">
                    <label><b>Contest Description:</b></label>
                    <textarea class="form-control" id="xyz"></textarea>
                </div>
                <div class="col-12 form-group">
                    <label><b>Contest Rules:</b></label>
                    <textarea class="form-control" id="zyx"></textarea>
                </div>
                <div class="col-12 form-group">
                    <label><b>Author:</b></label>
                    <textarea class="form-control" id="auth" placeholder="In case of multiple authors, separate using forward slash /"></textarea>
                </div>
            </div>
        </div>

        <div class="mt-5 mx-lg-5 bg-white rounded p-3">
            <div class="text-center text-success">
                <h3><b>Problemset</b></h3>
            </div>
            <div id="Problemset" class="px-lg-5">
                <div id="ProblemDiv1">
                    <div class="row mt-3">
                        <div class="col-1">
                            <b>A:</b>
                        </div>
                        <div class="col-7">
                            <input type="text" id="prb1" class="form-control form-control-lg bg-dark text-white" placeholder="Enter the problem id" >
                        </div>
                        <div class="col-3">
                            <input type="text" id="scr1" class="form-control form-control-lg bg-dark text-white" value="1" placeholder="Score" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3 text-right">
                <button class="mx-1 btn btn-primary rounded-circle" id="addProblem"><b><i class="fas fa-plus" data-toggle="tooltip" title="Add another problem"></i></b></button>
                <button class="mx-1 btn btn-danger rounded-circle" id="rmvLast"><b><i class="fas fa-trash" data-toggle="tooltip" title="Remove the last problem"></i></b></button>
            </div>
        </div>
        <div class="mt-3 mb-5 text-center">
            <button class="btn btn-lg btn-success" id="set" data-toggle="modal" data-target="#set_cont"><b>Set Contest</b></button>
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
    </div>
    <script src="../../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="../../js/sidebar.js" type="text/javascript"></script>
    <script src="../../ckeditor/ckeditor.js"></script>
    <script src="../../ckfinder/ckfinder.js"></script>
    <script type="text/javascript">
        CKFinder.setupCKEditor(CKEDITOR.replace('xyz'));
        CKFinder.setupCKEditor(CKEDITOR.replace('zyx'));

        $(document).ready(function() {
            var counter = 2;
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
                            '<input type="text" id="prb' + counter + '"' + 'class="form-control form-control-lg bg-dark text-white" placeholder="Enter the problem id" >'+
                        '</div>'+
                        '<div class="col-3">'+
                            '<input type="text" id="scr' + counter + '"' + ' class="form-control form-control-lg bg-dark text-white" value="1" placeholder="Score" >'+
                        '</div>'+
                    '</div>'
                );

                newProblemDiv.appendTo("#Problemset");
                counter++;
            });

            $("#rmvLast").click(function () {
                if(counter == 2) {
                    $('#set_cont').modal('toggle');
                    $('.mdl_msg').html(
                        `<h4 class="text-danger mb-3">Contest should have at least one problem!</h4>
                        <button class="btn btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>`
                    );
                }
                else {
                    counter--;
                    $("#ProblemDiv" + counter).remove();
                }
            });


            $("#set").click(function() {
                var problems = '', scores = '';
                for(i = 1; i < counter; i++) {
                    problems += $('#prb' + i).val().trim() + ' ';
                    scores += $('#scr' + i).val().trim() + ' ';
                }
                var form_data = new FormData();
                form_data.append('title', $("#tit").val());
                form_data.append('start', $("#stym").val());
                form_data.append('end', $("#etym").val());
                form_data.append('frz', $("#ftym").val());
                form_data.append('desc', CKEDITOR.instances['xyz'].getData());
                form_data.append('rule', CKEDITOR.instances['zyx'].getData());
                form_data.append('probs', problems);
                form_data.append('scores', scores);
                form_data.append('author', $("#auth").val());

                console.log('prb: ', problems);
                $.ajax({
                    url: "set.php",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function(response) {
                        console.log(response);
                        $('.mdl_msg').html(response);
                    }
                });
            });
        });
    </script>
</body>

</html>