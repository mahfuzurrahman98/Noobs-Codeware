<?php

include '../connection.php';
include 'security.php';

if (!isset($_GET['sub'])) {
    exit('No such page found!');
}

$sub = $_GET['sub'];
$qry = "SELECT * FROM Submission WHERE Sub_Id = {$sub};";
$res = mysqli_query($con, $qry) or exit('No such submissions found');

if (mysqli_num_rows($res) == 0) {
    exit('No such submissions found');
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission-Codeware</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<?php include 'nav_bar.php'; ?>
<div class="container-fluid">
    <table class="table table-hover table-sm table-light my-5">
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
    <p class="h4 font-weight-bold text-muted">Source Code</p>
    <div class="shadow shadow-lg bg-light p-3 mb-5">
        <?php echo highlightText($src_code); ?>
    </div>
    <?php include 'footer.php';?>
</div>
<script src="../js/jquery-3.6.0.js" type="text/javascript"></script>
<script src="../js/bootstrap.bundle.js" type="text/javascript"></script>
</body>
</html>
