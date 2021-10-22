<?php

include '../../connection.php';
include 'security.php';

$clar_id = $_POST['clar_id'];

$qry = "SELECT Problem, Ques, _user, Replied FROM Clarifi_Comment WHERE Cmnt_Id = {$clar_id};";
$res = mysqli_query($con, $qry);

while ($row = mysqli_fetch_assoc($res)) {
	$Problem = $row['Problem'];
	$Ques = $row['Ques'];
	$_user = $row['_user'];
	$Replied = $row['Replied'];
}

?>

<span class="h5">
	<span class="text-danger"><?php echo $Problem.'. '; ?></span>
	<?php echo nl2br($Ques); ?>
</span>
<span>
	@<a href="../../profile.php?user=<?php echo $_user; ?>"><?php echo $_user; ?></a>
</span>

<?php

if ($Replied == 'yes') {
	$qry = "SELECT Ans FROM Clarifi_Reply WHERE Against = {$clar_id};";
	$res = mysqli_query($con, $qry);
	echo '<div class="mt-3">&nbsp&nbsp&nbsp&nbsp' . nl2br(mysqli_fetch_assoc($res)['Ans']) . '</div>';
}
else { ?>
	<form class="mt-3" action="reply.php" method="POST">
		<input type="hidden" name="clar_id" value="<?php echo $clar_id; ?>">
        <div class="form-group text-success h5">
            <textarea name="announce" class="form-control" rows="10" required=""></textarea>
        </div>
        <button type="submit" class="btn btn-success" name="rply"><b>Clarifly</b></button>
    </form>
<?php } ?>