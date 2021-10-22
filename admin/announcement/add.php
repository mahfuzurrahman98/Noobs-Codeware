<?php

include '../../connection.php';
include 'security.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add announcement</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/sidebar.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="container-fluid">        
        <div class="mt-5">
            <h2 class="text-center text-success">Add an announcement</h2>
            <form class = "shadow-lg p-3 bg-light rounded my-3" action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                <div class="form-group">
                    <label><b>Title:</b></label>
                    <input type="text" name="up_tit" class="form-control" id="X1" placeholder="Enter the title" required>
                </div>
                <div class="form-group">
                    <label><b>Description:</b></label>
                    <textarea name="desc" class="form-control mb-2" id="Article_editor"></textarea>
                </div>
                <button type="submit" name="pst" class="btn btn-success"><b>Post</b></button>
            </form>
            <?php
            if (isset($_POST['pst'])) {
                $up_tit = $_POST['up_tit'];
                $desc = $_POST['desc'];
                $auth = $_SESSION['Username'];

                if (strlen($desc) == 0) {
                    echo '<script>
                        alert("You left input fields blank!");
                    </script>';
                }

                else {
                    $qry = "INSERT INTO _Update(Title, Description, Author) VALUES('{$up_tit}', '{$desc}', '{$auth}');";
                    mysqli_query($con, $qry) or die('Inserting Announcement Failed!');
                    echo '<script>
                        window.history.replaceState(null, null, window.location.href);
                        alert("Announcement uploaded successfully!");
                        window.location.reload();
                    </script>';
                }
            }
            ?>
        </div>
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