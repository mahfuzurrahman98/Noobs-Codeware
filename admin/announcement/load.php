<?php

include '../../connection.php';
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    die('<h1>Invalid page request</h1>');
}

$tit = $_POST['title'];
$auth = $_POST['author'];
$page = $_POST['page'];
$lim = 5;
$off = ($page - 1) * $lim;
$qry = '';

if ($tit == 'All' OR $tit == '') {
    $tit = '%';
}
if ($auth == 'All' OR $auth == '') {
    $auth = '%';
}

$qry = "SELECT * FROM _Update WHERE Title LIKE '%{$tit}%' AND Author LIKE '%{$auth}%' LIMIT {$lim} OFFSET {$off};";
$res = mysqli_query($con, $qry);
?>

<thead>
    <td><b>Title</b></td>
    <td><b>Author</b></td>
</thead>
<tbody>
<?php if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $up_id = $row['Id'];
        $up_tit = $row['Title'];
        $up_auth = $row['Author']; ?>
        <tr>
            <td><a href="../../update.php?id=<?php echo $up_id; ?>" class="h5"> <?php echo $up_tit; ?> </a></td>
            <td> <?php echo $up_auth; ?> </td>
            <td><a class="btn btn-sm btn-primary" href="edit.php?id=<?php echo $up_id; ?>"><i class="far fa-edit"></i></a></td>
            <td><button data-toggle="modal" class="btn btn-sm btn-danger dltbtn" data-target="#dlt_ann" data-id="<?php echo $up_id; ?>"><i class="far fa-trash-alt"></i></button></td>

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
                aid: x
            },
            success: function(response) {
                window.location.reload();
            }
        });
    }
</script>
