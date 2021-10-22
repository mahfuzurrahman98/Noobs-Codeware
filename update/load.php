<?php

include '../connection.php';

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    die('Invalid page request');
}

$tit = trim(mysqli_real_escape_string($con, $_POST['title']));
$page = $_POST['page'];
$lim = 5;
$off = ($page - 1) * $lim;
$qry = '';

if ($tit == 'All' OR $tit == '') {
    $tit = '%';
}

$qry = "SELECT * FROM _Update WHERE Title LIKE '%{$tit}%' ORDER BY Added_Time DESC LIMIT {$lim} OFFSET {$off};";
$res = mysqli_query($con, $qry);

if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $id = $row['Id'];
        $tit = $row['Title'];
        $desc = $row['Description'];
        $auth = $row['Author'];
        $tym = $row['Added_Time']; ?>
        
        <tr class="my-2">
            <td>
                <a class="text-success h4" href="show.php?id=<?php echo $id; ?>"><?php echo $tit;?></a>
                <span>by </span>
                <span><a href="../profile.php?user=<?php echo $auth; ?>"><?php echo $auth;?></a> on</span>
                <span class="text-danger"> <?php echo date(" M j Y g:i A", strtotime($tym)); ?></span>
                <div class="mt-1">
                    <?php echo substr($desc, 0, 150) . '...'; ?>
                </div>
            </td>
        </tr>
<?php
    }
}
?>
