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

$qry = "SELECT * FROM Submission WHERE Sub_Id = $sub_id;";
$res = mysqli_query($con, $qry);

?>

<table class="table table-sm p-2">
    <div class="mb-3">
        <a href="show.php?sub=<?php echo $sub_id; ?>">#view in a separate page</a>
    </div>
    <thead>
        <tr class="text-muted">
            <td><b>Author</b></td>
            <td><b>Verdict</b></td>
            <td><b>Language</b></td>
            <td><b>Time</b></td>
            <td><b>Memory</b></td>
            <td><b>Source</b></td>
            <td><b>When</b></td>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
            <td><?php echo $row['Username']; ?></td>
            <?php $acc_class = ''; if ($row['Verdict'] == 'Accepted') {$acc_class = 'text-success';} ?>
            <td class="<?php echo $acc_class; ?>"><?php echo $row['Verdict'];?></td>
            <td><?php echo $row['Language']; ?></td>
            <td><?php echo sprintf('%0.2f', ($row['Time'])).' sec'; ?></td>
            <td><?php echo sprintf('%0.2f', ($row['Memory'] / 1024)).' MB'; ?></td>
            <td><?php echo sprintf('%0.2f', ($row['Source_Size'] / 1000)).' KB'; ?></td>
            <td><?php echo date('Y-m-d H:i:s', $row['Sub_Time']); ?></td>
            </tr>
        <?php $src_code = $row['Source_Code'];} ?>
    </tbody>
</table>
<hr class="bg-dark">
<div class="shadow shadow-lg bg-light p-3">
	<?php echo highlightText($src_code); ?>
</div>