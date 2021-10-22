<?php

include '../connection.php';
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    exit('<h1>Invalid page request</h1>');
}

$tit = trim(mysqli_real_escape_string($con, $_POST['title']));
$cat = $_POST['category'];
$stat = $_POST['status'];
$page = $_POST['page'];
$lim = 3;
$off = ($page - 1) * $lim;

$qry = '';
$qry = "SELECT * FROM Tutorial WHERE Author = '{$_SESSION["Username"]}' AND Normal_User = 'Yes' AND Title LIKE '%{$tit}%' AND Category LIKE '{$cat}' AND Approved LIKE '%{$stat}%' ";

if ($stat == 'Requested') {
    $qry .= "'No'";
}
else if ($stat == 'Approved') {
    $qry .= "'Yes'";
}
$qry .= " LIMIT {$lim} OFFSET {$off};";
echo 'Q: '.$qry;
$res = mysqli_query($con, $qry);

?>

<thead>
    <td><b>Title</b></td>
    <td><b>Category</b></td>
    <td><b>Status</b></td>
</thead>
<tbody>
<?php
if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $tid = $row['Id'];
        $ttit = $row['Title'];
        $tcat = $row['Category'];
        $app = $row['Approved']; ?>
        <tr>
            <td><a href="tutorial/show.php?id=<?php echo $tid; ?>" target="-blank"><?php echo $ttit; ?></a></td>
            <td> <?php echo $tcat; ?> </td>
            <td>
                <?php
                if ($app = 'Yes') {
                    echo 'Archived';
                }
                else {
                    echo 'Pending';
                }
                ?>
            </td>

        </tr>
    <?php }
} ?>
</tbody>