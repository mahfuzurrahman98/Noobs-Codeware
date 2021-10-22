<?php

$participant = $_SESSION['Username'];
$part_val_qry = "SELECT * FROM User_Contest WHERE Id = '{$id}' AND Contestants LIKE '%/{$participant}/%';";
echo '<script>
	console.log("'.$part_val_qry.'");
</script>';
$part_val_res = mysqli_query($con, $part_val_qry);
if (mysqli_num_rows($part_val_res) == 0) {
	exit('Invalid page request');
}

?>
<script>
	console.log("<?php echo $part_val_qry; ?>");
</script>