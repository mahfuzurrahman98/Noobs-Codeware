<?php

include '../connection.php';
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    die('<h1>Invalid page request</h1>');
}

$tit = $_POST['title'];
$cat = $_POST['category'];
$auth = $_POST['author'];
$page = $_POST['page'];
$lim = 3;
$off = ($page - 1) * $lim;
$qry = '';

if ($tit == 'All' OR $tit == '') {
    $tit = '%';
}
if ($cat == 'All') {
    $cat = '%';
}
if ($auth == 'All' OR $auth == '') {
    $auth = '%';
}

$qry = "SELECT * FROM Tutorial WHERE Approved = 'No' AND Title LIKE '%{$tit}%' AND Category LIKE '{$cat}' AND Author LIKE '%{$auth}%' LIMIT {$lim} OFFSET {$off};";
$res = mysqli_query($con, $qry);

?>

<thead>
    <td><b>Title</b></td>
    <td><b>Category</b></td>
    <td><b>Author</b></td>
</thead>
<tbody>
<?php
if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $tid = $row['Id'];
        $ttit = $row['Title'];
        $tcat = $row['Category'];
        $tauth = $row['Author']; ?>
        <tr>
            <td> <?php echo $ttit; ?></td>
            <td> <?php echo $tcat; ?> </td>
            <td> <?php echo $tauth; ?> </td>
            <td><a class="btn btn-sm btn-primary" href="view_tut.php?id=<?php echo $tid; ?>" target="-blank"><i class="fas fa-eye"></i></a></td>

        </tr>
    <?php }
} ?>
</tbody>