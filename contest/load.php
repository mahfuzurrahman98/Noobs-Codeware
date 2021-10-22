<?php

include '../connection.php';
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    exit('<h1>Invalid page request</h1>');
}

$title = trim($_POST['title']);
$y = $_POST['y'];
$page = $_POST['page'];
$lim = 3;
$off = ($page - 1) * $lim;
$qry = '';

if ($title == '' || $title == '') {
    $title = '%';
}

$qry = "SELECT * FROM Contest WHERE Title LIKE '%{$title}%'";

if ($y == 'e') {
    $qry .= " AND Finish_Time < CURRENT_TIMESTAMP";
}
else if ($y == 'r') {
    $qry .= " AND CURRENT_TIMESTAMP >= Start_Time AND CURRENT_TIMESTAMP <= Finish_Time";
}
else {
    $qry .= " AND Start_Time > CURRENT_TIMESTAMP";
}

$qry .= " ORDER BY Start_Time DESC LIMIT {$lim} OFFSET {$off};";
$res = mysqli_query($con, $qry);

while ($row = mysqli_fetch_assoc($res)) { ?>
    <tr>
        <td class="px-3"><a href="overview.php?id=<?php echo $row['Id']; ?>"><?php echo $row['Title']; ?></a></td>
        <td class="px-3"><?php echo date(" M j Y, g:i A", strtotime($row['Start_Time'])); ?></td>
        <td class="px-3"><?php echo date(" M j Y, g:i A", strtotime($row['Finish_Time'])); ?></td>
    </tr>
<?php } ?>