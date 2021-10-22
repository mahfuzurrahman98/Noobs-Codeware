<?php

include '../../connection.php';
include 'security.php';

$tit = $_POST['title'];
$cat = $_POST['category'];
$auth = $_POST['author'];
$page = $_POST['page'];
$lim = 5;
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

$qry = "SELECT * FROM Tutorial WHERE Title LIKE '%{$tit}%' AND Category LIKE '{$cat}' AND Author LIKE '%{$auth}%' LIMIT {$lim} OFFSET {$off};";
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
            <td><a href="../../tutorial/show.php?id=<?php echo $tid; ?>" class="h5"> <?php echo $ttit; ?> </a></td>
            <td> <?php echo $tcat; ?> </td>
            <td> <?php echo $tauth; ?> </td>
            <td><a class="btn btn-sm btn-primary" href="edit.php?id=<?php echo $tid; ?>"><i class="far fa-edit"></i></a></td>
            <td><button data-toggle="modal" class="btn btn-sm btn-danger dltbtn" data-target="#dlt_tut" data-id="<?php echo $tid; ?>"><i class="far fa-trash-alt"></i></button></td>

        </tr>
    <?php }
} ?>
</tbody>

<script>
    var x = -1;
    $(".dltbtn").click(function() {
        x = $(this).attr('data-id');
        console.log(x);
    })

    function del() {
        $.ajax({
            url: "delete.php",
            method: "POST",
            data: {
                tid: x
            },
            success: function(response) {
                window.location.reload();
            }
        });
    }
</script>
