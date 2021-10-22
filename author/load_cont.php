<?php

include '../connection.php';
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    exit('<h1>Invalid page request</h1>');
}

$judg = $_SESSION['Username'];
$tit = $_POST['tit'];
$stat = $_POST['stat'];
$page = $_POST['page'];
$lim = 3;
$off = ($page - 1) * $lim;
$qry = '';
//Query writing
$qry = "SELECT Id, Title, Start_Time, Finish_Time FROM User_Contest WHERE Title LIKE '%{$tit}%' AND Judges LIKE '%/{$judg}/%'";

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
?>


<?php
if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $id = $row['Id'];
        $tit = $row['Title'];
        $stym = $row['Start_Time'];
        $etym = $row['Finish_Time'];
        ?>
        <tr>
            <td><a href="contest/overview.php?id=<?php echo $id; ?>" class="h5"> <?php echo $tit; ?> </a></td>
            <td> <?php echo $stym; ?> </td>
            <td>
                <?php
                if (strtotime($stym) > time()) {
                    echo 'Featured';
                }
                else if (strtotime($stym) <= time() AND time() <= strtotime($etym)) {
                    echo 'Running';
                }
                else if (strtotime($etym) < time()) {
                    echo 'Ended';
                }
                ?>
            </td>
            <td><a href="contest/setting.php?id=<?php echo $id; ?>" class="h5"> <i class="fas fa-cog"></i> </a></td>
        </tr>
    <?php }
} ?>

<script>
    console.log("<?php echo $qry; ?>");
</script>