<?php
include '../connection.php';
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    exit('<h1>Invalid page request</h1>');
}

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

$sub_id = $_POST['sub_id'];
$qry = "SELECT Source_Code FROM Submission WHERE Sub_Id = {$sub_id};";
$res = mysqli_query($con, $qry);
while ($row = mysqli_fetch_assoc($res)) { 
	$code = $row['Source_Code'];
}
?>

<div class="mb-3">
    <a href="../submission/show.php?sub=<?php echo $sub_id; ?>">#view in a separate page</a>
</div>
<div class="shadow shadow-lg bg-light p-3">
	<?php echo highlightText($code); ?>
</div>