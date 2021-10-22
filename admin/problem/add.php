<?php 

include '../../connection.php';
include 'security.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Problem</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <link rel="stylesheet" href="../../css/select2.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/sidebar.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="container-fluid">
        <div class="mt-5">
            <h2 class="text-center text-success mb-3">Add a problem</h2>
            <p class="shadow shadow-lg alert alert-warning rounded">By default, the problem will be hidden, be sure to turn on the switch to show in the archive.</p>
            <div class = "shadow-lg p-3 bg-light rounded mb-4">
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label><b>Title:</b></label>
                        <input type="text" class="form-control" id="tit" placeholder="Enter the title">
                    </div>
                    <div class="col-lg-6 mt-3 mt-lg-0">
                        <label><b>Difficulty:</b></label>
                        <select class="form-control" id="dif">
                            <option value="Simple">Simple</option>
                            <option value="Easy">Easy</option>
                            <option value="Medium">Medium</option>
                            <option value="Moderate">Moderate</option>
                            <option value="Hard">Hard</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label><b>Statement:</b></label>
                    <textarea class="form-control mb-2" placeholder="Write the statement" id="stat"></textarea>
                </div>
                <div class="form-group">
                    <label><b>Input Format:</b></label>
                    <textarea class="form-control mb-2" placeholder="Write the input format" id="ipf"></textarea>
                </div>
                <div class="form-group">
                    <label><b>Output Format:</b></label>
                    <textarea class="form-control mb-2" placeholder="Write the output format" id="opf"></textarea>
                </div>
                <div class="form-group">
                    <label"><b>Constraints:</b></label>
                    <textarea class="form-control mb-2" placeholder="Write the constrints" id="cons"></textarea>
                </div>                
                <div class="form-group">
                    <label><b>Notes:</b></label>
                    <textarea class="form-control mb-2" placeholder="Write notes or explanations" id="notes"></textarea>
                </div>
                <div class="form-group">
                    <label><b>Tags:</b></label>
                    <select id="tg" class="form-control mul-select" multiple="true" style="width:100%;">
                        <?php include '../../tags.php'; ?>
                    </select>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label><b>Problem Setter: (<span class="text-danger">Enter username if registered</span>)</b></label>
                        <input type="text" class="form-control" id="auth"
                            placeholder="Enter The problem setter's name">
                    </div>
                    <div class="col-lg-6 mt-3 mt-lg-0">
                        <label><b>Testcase Contributor: (<span class="text-danger">Enter username if registered</span>)</b></label>
                        <input type="text" class="form-control" id="tcc"
                            placeholder="Enter the test case contributor's name">
                    </div>
                </div>
                <div class="custom-control custom-switch my-3 h5">
                    <input type="checkbox" class="custom-control-input" id="archive" checked-data-toggle="toggle" data-on="show" data-off="hide" style="color: green; width: 5px;">
                    <label class="custom-control-label" id="archive" for="archive" value="hide">Hidden from archive (Switch to show)</label>
                </div>
                <button class="btn btn-success" data-toggle="modal" data-target="#addtest" onclick="addData()"><b>Add</b></button>
            </div>
        </div>
    </div>
    <div class="modal fade" data-backdrop="static" id="addtest" tabindex="-1" role="dialog" aria-labelledby="addtestLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Message</h5>
                    <button type="button" class="text-dark btn btn-sm" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body xyz text-center">
            
                </div>
            </div>
        </div>
    </div>
    <script src="../../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="../../js/select2.js" defer></script>
    <script src="../../ckeditor/ckeditor.js"></script>
    <script src="../../ckfinder/ckfinder.js"></script>
    <script src="../../js/sidebar.js"></script>
    <script>
        var tag_arr_js = [''];
        $(document).ready(function(){
            $(".mul-select").select2({
                placeholder: "Add Tags",
                tokenSeparators: ['/',',',';'," "] 
            });

            $('#archive').change(function() {
                if ($(this).prop('checked')) {
                    $('#archive').val("show");
                    $('label#archive').text('Shown in archive (Switch to hide)');
                }
                else {
                    $('#archive').val("hide");
                    $('label#archive').text('Hidden from archive (Switch to show)');
                }
            });
        });

        CKFinder.setupCKEditor(CKEDITOR.replace('stat'));
        CKFinder.setupCKEditor(CKEDITOR.replace('ipf'));
        CKFinder.setupCKEditor(CKEDITOR.replace('opf'));
        CKFinder.setupCKEditor(CKEDITOR.replace('cons'));
        CKFinder.setupCKEditor(CKEDITOR.replace('notes'));

        function addData() {
            tag_arr_js = tag_arr_js.concat($("#tg").val());
            console.log(tag_arr_js);
            $.ajax({
                url: "set.php",
                method: "POST",
                data: {
                    tit: $('#tit').val(),
                    stat: CKEDITOR.instances['stat'].getData(),
                    dif: $('#dif').val(),
                    cons: CKEDITOR.instances['cons'].getData(),
                    ipf: CKEDITOR.instances['ipf'].getData(),
                    opf: CKEDITOR.instances['opf'].getData(),
                    note: CKEDITOR.instances['notes'].getData(),
                    tags: tag_arr_js,
                    auth: $('#auth').val(),
                    tcc: $('#tcc').val(),
                    arch: $('#archive').val()
                },
                success: function(response) {
                    tag_arr_js = [''];
                    $('.xyz').html(response);
                }
            });
        }
    </script>
</body>
</html>