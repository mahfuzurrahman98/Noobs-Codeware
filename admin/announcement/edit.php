<?php

include '../../connection.php';
include 'security.php';

$up_id = $_GET['id'];
$qry_upd = "SELECT * FROM _Update WHERE Id = $up_id;";
$res_upd = mysqli_query($con, $qry_upd) or die("Query Failed!");

while ($row = mysqli_fetch_assoc($res_upd)) {
	$upd_tit = $row['Title'];
	$upd_desc = $row['Description'];
	$upd_auth = $row['Author'];
	$upd_tym = $row['Added_Time'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/sidebar.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="container-fluid">
        <div class="mt-5">
            <h2 class="text-center text-success">Update the announcement</h2>
            <form class = "shadow p-3 bg-light rounded my-3" action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                <div class="form-group">
                    <label><b>Title:</b></label>
                    <input type="text" name="up_tit2" value="<?php echo $upd_tit ?>" class="form-control" placeholder="Enter the title">
                </div>
                <div class="form-group">
                    <label><b>Description:</b></label>
                    <textarea name="desc2" class="form-control mb-2" placeholder="Write the descriptions" rows="10" cols="25" id="Article_editor"><?php echo nl2br($upd_desc) ?></textarea>
                </div>
                <button type="submit" name="upd_ann" class="btn btn-success"><b>Update</b></button>
            </form>
        </div>

        <?php
        if(isset($_POST['upd_ann'])) {
            $up_tit = $_POST['up_tit2'];
            $desc = $_POST['desc2'];
            $auth = $_SESSION['Username'];
            
            $qry_upd = "UPDATE _Update SET Title = '{$up_tit}', Description = '{$desc}' WHERE _Update.Id = $up_id;";
            mysqli_query($con, $qry_upd); 
            echo '<script>
                window.history.replaceState(null, null, window.location.href);
                alert("Announcement updated successfully!");
                window.location.reload();
            </script>';
        }
        ?>
    </div>
    
    <script src="../../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="../../ckeditor/ckeditor.js"></script>
    <script src="../../ckfinder/ckfinder.js"></script>
    <script src="../../js/sidebar.js"></script>
    <script>
        CKFinder.setupCKEditor(CKEDITOR.replace('Article_editor'));
    </script>
</body>

</html>