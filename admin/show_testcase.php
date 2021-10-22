<?php

include '../connection.php';
include 'security.php';

$sno = $_POST['sno'];
$pid = $_POST['pid'];
$tc_id = $_POST['tcid'];

$cur_inp = file_get_contents('../uploads/admin/testcases/'.$pid.'/input/'.$tc_id);
$cur_out = file_get_contents('../uploads/admin/testcases/'.$pid.'/output/'.$tc_id);

?>

<div>
    <div class="row">
        <div class="col-11"><h3 class="text-center"><b>Testcase <?php echo $sno; ?> </b></h3></div>
        <div class="col-1 text-right">
            <a href="javascript:void(0)" class="text-danger" data-dismiss="modal"><b><i class="fas fa-times"></i></b></a>
        </div>
    </div>
    <div class="form-group">
        <label><b>Input:</b></label>
        <textarea name="tc_inp2" class="form-control mb-2" rows="7" disabled><?php echo $cur_inp; ?></textarea>
    </div>
    <div class="form-group">
        <label><b>Output:</b></label>
        <textarea name="tc_out2" class="form-control mb-2" rows="7" disabled><?php echo $cur_out; ?></textarea>
    </div>
    
    </div>
</div>