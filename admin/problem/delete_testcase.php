<?php

include '../../connection.php';
include 'security.php';

$pid = $_POST['pid'];
$tc_id = $_POST['tcid'];

?>

<form action="delete_testcase.php" method="POST">
    <input type="hidden" name="pid2" value="<?php echo $pid; ?>">
    <input type="hidden" name="tc_id2" value="<?php echo $tc_id; ?>">
    <h5 class="mb-4 text-center">Do you really want to delete the testcase?</h5>
    <div class="row">
        <div class="col-6">
        	<button type="submit" name="yes" class="btn btn-danger"><b>Yes</b></button></div>
        <div class="col-6 text-right">
        	<button type="button" class="btn btn-dark" data-dismiss="modal"><b>No</b></button>
        </div>
    </div>
</form>

<?php

if (isset($_POST['yes'])) {

    $pid2 = $_POST['pid2'];
    $tc_id2 = $_POST['tc_id2'];

    unlink('../../uploads/admin/testcases/'.$pid2.'/input/'.$tc_id2);
    unlink('../../uploads/admin/testcases/'.$pid2.'/output/'.$tc_id2);
    header("Location: testcases.php?id={$pid2}");
}

?>