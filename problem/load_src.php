<?php

include '../connection.php';
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    exit('<h1>Invalid page request</h1>');
}

$sub_id = $_POST['sub_id'];
$tag = $_POST['tag'];
$qry = '';
$msg = '';

if ($tag == 'fastest') { //Measure of execution time
	$qry = "SELECT * FROM Submission WHERE Sub_Id = '{$sub_id}' AND Verdict = 'Accepted' ORDER BY Time ASC LIMIT 1;";
    $msg = 'fastest solution in terms of execution time';
}
else if ($tag == 'slowest') { //Measure of execution time
	$qry = "SELECT * FROM Submission WHERE Sub_Id = '{$sub_id}' AND Verdict = 'Accepted' ORDER BY Time DESC LIMIT 1;";
    $msg = 'slowest solution in terms of execution time';
}
else if ($tag == 'lightest') { //Measure of memory consumption
	$qry = "SELECT * FROM Submission WHERE Sub_Id = '{$sub_id}' AND Verdict = 'Accepted' ORDER BY Memory ASC LIMIT 1;";
    $msg = 'lightest solution in terms of memory consumtion';
}
else if ($tag == 'haviest') { //Measure of memory consumption
	$qry = "SELECT * FROM Submission WHERE Sub_Id = '{$sub_id}' AND Verdict = 'Accepted' ORDER BY Memory DESC LIMIT 1;";
    $msg = 'heaviest solution in terms of memory consumtion';
}
else if ($tag == 'shortest') { //Measure of source file size
	$qry = "SELECT * FROM Submission WHERE Sub_Id = '{$sub_id}' AND Verdict = 'Accepted' ORDER BY Source_Size ASC LIMIT 1;";
    $msg = 'shortest solution in terms of source file size';
}
else if ($tag == 'longest') { //Measure of source file size
	$qry = "SELECT * FROM Submission WHERE Sub_Id = '{$sub_id}' AND Verdict = 'Accepted' ORDER BY Source_Size DESC LIMIT 1;";
    $msg = 'longest solution in terms of source file size';
}
else if ($tag == 'earliest') { //Measure of submission time
	$qry = "SELECT * FROM Submission WHERE Sub_Id = '{$sub_id}' AND Verdict = 'Accepted' ORDER BY Sub_Time ASC LIMIT 1;";
    $msg = 'earliest solution that was accepted';
}
$res = mysqli_query($con, $qry);

function highlightText($text) {
    $text = trim($text);
    $text = highlight_string("<?php " . $text, true);  // highlight_string() requires opening PHP tag or otherwise it will not colorize the text
    $text = trim($text);
    $text = preg_replace("|^\\<code\\>\\<span style\\=\"color\\: #[a-fA-F0-9]{0,6}\"\\>|", "", $text, 1);  // remove prefix
    $text = preg_replace("|\\</code\\>\$|", "", $text, 1);  // remove suffix 1
    $text = trim($text);  // remove line breaks
    $text = preg_replace("|\\</span\\>\$|", "", $text, 1);  // remove suffix 2
    $text = trim($text);  // remove line breaks
    $text = preg_replace("|^(\\<span style\\=\"color\\: #[a-fA-F0-9]{0,6}\"\\>)(&lt;\\?php&nbsp;)(.*?)(\\</span\\>)|", "\$1\$3\$4", $text);  // remove custom added "<?php "

    return $text;
}

?>
<table class="table table-sm p-2">
    <div class="mb-3">
        <a href="../submission/show.php?sub=<?php echo $sub_id; ?>">#view in a separate page</a>
    </div>
    <thead>
        <tr class="text-muted">
            <td><b>User</b></td>
            <td><b>Language</b></td>
            <td><b>Time</b></td>
            <td><b>Memory</b></td>
            <td><b>Source</b></td>
            <td><b>When</b></td>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($res)) { 
        	$code = $row['Source_Code'];
        	?>
            <tr>
	            <td><?php echo $row['Username']; ?></td>
	            <td><?php echo $row['Language']; ?></td>
	            <td><?php echo sprintf('%0.2f', ($row['Time'])).' sec'; ?></td>
	            <td><?php echo sprintf('%0.2f', ($row['Memory'] / 1024)).' MB'; ?></td>
	            <td><?php echo sprintf('%0.2f', ($row['Source_Size'] / 1024)).' KB'; ?></td>
	            <td><?php echo date('Y-m-d H:i', $row['Sub_Time']); ?></td>
            </tr>
        <?php } ?>

    </tbody>
</table>
<button class="btn btn-sm btn-success">Accepted</button> <span class="text-muted"> <?php echo $msg; ?></span>
<div class="shadow shadow-lg bg-light p-3">
	<?php echo highlightText($code); ?>
</div>