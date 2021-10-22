<?php

include '../../connection.php';
include 'security.php';

$pid = $_GET['id'];
$qry_prb = "SELECT * FROM Problem WHERE Id = '{$pid}';";
$res_prb = mysqli_query($con, $qry_prb) or die("Query Failed1!");

$qry_tag = "SELECT * FROM Problem_Tags";
$res_tag = mysqli_query($con, $qry_tag);
$tag_tab = [];

while ($row = mysqli_fetch_assoc($res_tag)) {
    $tag_tab[] = $row['Name'];
}

while ($row = mysqli_fetch_assoc($res_prb)) {
    //$tit = preg_replace('/\s+/', ' ' , $row['Title']);
	$tit = $row['Title'];
    $dif = $row['Difficulty'];
    $tag_arr = explode(' ', $row['Tags']);
	$stat = $row['Statement'];
	$cons = $row['Constraints'];
	$ipf = $row['Input_Format'];
    $outf = $row['Output_Format'];
	$samp_tst = explode(' ', $row['Sample_Test']);
	$auth = $row['Author'];
	$tcc = $row['TC_Contributor'];
    $note = $row['Notes'];
	$arch = $row['Archive'];
}

function make_id($st) {
    $s = "";
    for ($i = 0; $i < strlen($st); $i++) {
        if ($st[$i] == ' ') {
            $s .= '-';
        }
        else if (($st[$i] >= 'a' && $st[$i] <= 'z') || ($st[$i] >= 'A' && $st[$i] <= 'Z')) {
            $s .= strtolower($st[$i]);
        }
        else if ($st[$i] >= '0' && $st[$i] <= '9') {
            $s .= $st[$i];
        }
    }
    return $s;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Problem</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <link rel="stylesheet" href="../../css/select2.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/sidebar.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="container-fluid">
        <nav class="mx-5 prb_info_tab">
            <div class="row p-2 shadow-lg rounded text-center justify-content-center mt-5 mb-5">
                <a class="col-12 my-1 col-lg-3 mx-2 my-lg-0 nav-link tab_active"
                    href="details.php?id=<?php echo $pid; ?>" role="tab"><b>Details</b></a>
                <a class="col-12 my-1 col-lg-3 mx-2 my-lg-0 nav-link"
                    href="testcases.php?id=<?php echo $pid; ?>" role="tab"><b>Testcases</b></a>
            </div>
        </nav>
        <div class="mt-5">
            <div class="shadow-lg p-3 bg-light rounded mb-4">
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label><b>Edit Title:</b></label>
                        <input type="text" id="tit" value="<?php echo $tit; ?>"
                            class="form-control" placeholder="Enter the title">
                    </div>
                    <div class="col-lg-6 mt-3 mt-lg-0">
                        <label><b>Edit Difficulty:</b></label>
                        <select class="form-control" id="dif">
                            <option <?php if ($dif == 'Simple') { echo 'selected'; } ?> value="Simple">Simple</option>
                            <option <?php if ($dif == 'Easy') { echo 'selected'; } ?> value="Easy">Easy</option>
                            <option <?php if ($dif == 'Medium') { echo 'selected'; } ?> value="Medium">Medium</option>
                            <option <?php if ($dif == 'Moderate') { echo 'selected'; } ?> value="Moderate">Moderate</option>
                            <option <?php if ($dif == 'Hard') { echo 'selected'; } ?> value="Hard">Hard</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label><b>Edit Statement:</b></label>
                    <textarea id="stat" class="form-control mb-2" style="font-family: Ubuntu;"><?php echo $stat; ?></textarea>
                </div>
                <div class="form-group">
                    <label><b>Edit Input Format:</b></label>
                    <textarea id="ipf" class="form-control mb-2"><?php echo $ipf; ?></textarea>
                </div>
                <div class="form-group">
                    <label><b>Edit Output Format:</b></label>
                    <textarea id="opf" class="form-control mb-2"><?php echo $outf; ?></textarea>
                </div>
                <div class="form-group">
                    <label><b>Edit Constraints:</b></label>
                    <textarea id="cons" class="form-control mb-2"><?php echo $cons; ?></textarea>
                </div>
                <div class="form-group">
                    <label><b>Edit Notes:</b></label>
                    <textarea id="notes" class="form-control mb-2"><?php echo $note; ?></textarea>
                </div>
                <div class="form-group">
                    <label><b>Tags:</b></label>
                    <select id="tg" class="form-control mul-select w-100" multiple="true">
                        <?php
                        foreach ($tag_tab as $x) {
                            $opt = "<option ";
                            if (in_array($x, $tag_arr)) {
                                $opt .= "selected ";
                            }
                            $opt .= "value=\"".$x."\">".$x."</option>";
                            echo $opt;
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label><b>Edit Problem Setter: (<span class="text-danger">Enter username if registered</span>)</b></label>
                        <input type="text" id="auth" class="form-control" value="<?php echo $auth; ?>">
                    </div>
                    <div class="col-lg-6 mt-3 mt-lg-0">
                        <label><b>Edit Testcase Contributor: (<span class="text-danger">Enter username if registered</span>)</b></label>
                        <input type="text" id="tcc" class="form-control" value="<?php echo $tcc; ?>">
                    </div>
                </div>
                <div class="custom-control custom-switch my-3 h5">
                    <input type="checkbox" class="custom-control-input" id="archive" checked-data-toggle="toggle" data-on="show" data-off="hide" <?php if ($arch == 'show') {echo 'checked';} ?>>
                    <label class="custom-control-label" id="archive" for="archive" value="<?php echo $arch_stat; ?>">
                        <?php 
                            if ($arch == 'show') {
                                echo "Shown in archive (Switch to hide)";
                            }
                            else {
                                echo "Hidden from archive (Switch to show)";
                            }
                        ?>
                    </label>
                </div>
                <button class="btn btn-success" data-toggle="modal" data-target="#msg_modal" onclick="updateData()"><b>Update</b></button>
            </div>
        </div>
    </div>
    <div class="modal fade" data-backdrop="static" id="msg_modal" tabindex="-1" role="dialog" aria-labelledby="msg_modalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body xyz text-center p-3">
                    
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
        $(document).ready(function() {
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

        function updateData() {
            tag_arr_js = tag_arr_js.concat($("#tg").val());
            console.log(tag_arr_js);
            $.ajax({
                url: "upd.php",
                method: "POST",
                data: {
                    id: "<?php echo $pid; ?>",
                    tit: $('#tit').val(),
                    prev_tit: "<?php echo $tit; ?>",
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