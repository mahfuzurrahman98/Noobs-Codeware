<?php

include '../../connection.php';
include 'security.php';

$sno = $_POST['sno'];
$pid = $_POST['pid'];
$tc_id = $_POST['tcid'];

$cur_inp = file_get_contents('../../uploads/user/testcases/'.$pid.'/input/'.$tc_id);
$cur_out = file_get_contents('../../uploads/user/testcases/'.$pid.'/output/'.$tc_id);

?>

<form action="show_edit_testcase.php" method="POST">
    <div class="row">
        <div class="col-11"><h3 class="text-center"><b>Testcase <?php echo $sno; ?> </b></h3></div>
        <div class="col-1 text-right">
            <a href="javascript:void(0)" class="text-danger" data-dismiss="modal"><b><i class="fas fa-times"></i></b></a>
        </div>
    </div>
    <div class="form-group">
        <label><b>Input:</b></label>
        <textarea name="tc_inp2" class="form-control mb-2" rows="7"><?php echo $cur_inp; ?></textarea>
    </div>
    <div class="form-group">
        <label><b>Output:</b></label>
        <textarea name="tc_out2" class="form-control mb-2" rows="7"><?php echo $cur_out; ?></textarea>
    </div>
    <input type="hidden" name="pid2" value="<?php echo $pid; ?>">
    <input type="hidden" name="tc_id2" value="<?php echo $tc_id; ?>">
    <button type="submit" name="updtst" class="btn btn-success"><b>Update</b></button>
    
    </div>
</form>

<?php

if (isset($_POST['updtst'])) {
    $upd_inp = $_POST['tc_inp2'];
    $upd_out = $_POST['tc_out2'];
    $pid2 = $_POST['pid2'];
    $tc_id2 = $_POST['tc_id2'];

    file_put_contents('../../uploads/user/testcases/'.$pid2.'/input/'.$tc_id2, $upd_inp);
    file_put_contents('../../uploads/user/testcases/'.$pid2.'/output/'.$tc_id2, $upd_out);
    header("Location: testcases.php?id={$pid2}");
}

?>