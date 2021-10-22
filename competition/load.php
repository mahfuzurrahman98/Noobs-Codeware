<?php

include '../connection.php';
include 'security.php';

$tit = $_POST['tit'];
$stat = $_POST['stat'];
$page = $_POST['page'];
$lim = 3;
$off = ($page - 1) * $lim;
$qry = '';
//Query writing
$qry = "SELECT Id, Title, Start_Time, Finish_Time FROM User_Contest WHERE Title LIKE '%{$tit}%' AND Contestants LIKE '%/{$_SESSION["Username"]}/%'";
echo '<script>
	console.log("'.$qry.'");
</script>';
//Calculate running time
if ($stat == 'Ended') {
    $qry .= " AND Finish_Time < CURRENT_TIMESTAMP";
}
else if ($stat == 'Running') {
    $qry .= " AND CURRENT_TIMESTAMP >= Start_Time AND CURRENT_TIMESTAMP <= Finish_Time";
}
else if ($stat == 'Featured') {
    $qry .= " AND Start_Time > CURRENT_TIMESTAMP";
}
else {
    $qry .= "";
}

$qry .= " ORDER BY Start_Time DESC LIMIT {$lim} OFFSET {$off};";
$res = mysqli_query($con, $qry);

if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $id = $row['Id'];
        $tit = $row['Title'];
        $stym = $row['Start_Time'];
        $etym = $row['Finish_Time'];
        ?>
        <tr>
            <td>A</td>
            <td>B</td>
            <td>C</td>
        </tr>
    <?php }
} ?>

<script>
    console.log("<?php echo $qry; ?>");
</script>