<?php

include '../../connection.php';
include 'security.php';

$tid = $_GET['id'];
$qry_tut = "SELECT * FROM Tutorial WHERE Id = $tid;";
$res_tut = mysqli_query($con, $qry_tut) or die("Query Failed1!");

while ($row = mysqli_fetch_assoc($res_tut)) {
	$tut_tit = $row['Title'];
	$tut_content = $row['Content'];
	$tut_auth = $row['Author'];
	$tut_cat = $row['Category'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tutorial</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <link rel="stylesheet" href="../../css/select2.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/sidebar.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="contain">    
        <div class="mt-5">
            <h2 class="text-center text-success">Edit this tutorial</h2>
            <form class = "shadow-lg p-3 bg-light rounded my-3 mx-2" action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                <div class="row">
                    <div class="form-group col-12 col-md-4">
                        <label><b>Edit Title:</b></label>
                        <input type="text" name="new_tit" pattern="[-'_A-Za-z 0-9]+" title="Only alphanumeric, hyphen, underscore and single qoutes are allowed" class="form-control" value="<?php echo $tut_tit; ?>" required>
                    </div>
                    <div class="form-group col-12 col-md-4">
                        <label><b>Edit Category:</b></label>
                        <select class="form-control" name="tut_cat">
                            <option selected value="<?php echo $tut_cat; ?>"><?php echo $tut_cat; ?></option>
                            <option value="Algorithm">Algorithm</option>
                            <option value="Data Structure">Data Structure</option>
                            <option value="Graph Theory">Graph Theory</option>
                            <option value="Dynamic Programming">Dynamic Programming</option>
                            <option value="Greedy">Greedy</option>
                            <option value="Game Theory">Game Theory</option>
                            <option value="OJ Problems Editorial">OJ Problems Editorial</option>
                            <option value="Programming Language">Programming Language</option>
                            <option value="Computer Science">Computer Science</option>
                            <option value="Science & Technology">Science & Technology</option>
                            <option value="Number Theory">Number Theory</option>
                            <option value="Combinatorics">Combinatorics</option>
                            <option value="Geomeatry">Geomeatry</option>
                            <option value="Math">Math</option>
                            <option value="Statistics">Statistics</option>
                            <option value="Numerical Analysis">Numerical Analysis</option>
                            <option value="Tools & Tips">Tools & Tips</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-4">
                        <label><b>Edit Author:</b></label>
                        <input type="text" name="tut_auth" pattern="[A-Z a-z0-9]+" title="Only alphanumeric characters are allowed" class="form-control" value="<?php echo $tut_auth; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label><b>Edit Description:</b></label>
                    <textarea name="tut_content" class="form-control" id="xyz"><?php echo $tut_content; ?></textarea>
                </div>
                <button type="submit" name="pub" class="btn btn-success mt-2"><b>Update</b></button>
            </form>
            <?php
            if (isset($_POST['pub'])) {
                $new_tit = trim(mysqli_real_escape_string($con, $_POST['new_tit']));
                $tut_auth = trim(mysqli_real_escape_string($con, $_POST['tut_auth']));
                $tut_cat = $_POST['tut_cat'];
                $tut_content = $_POST['tut_content'];

                $qry = "SELECT Id FROM Tutorial WHERE Title = '{$new_tit}';";
                $res = mysqli_query($con, $qry) or die('Selection failed!');

                if (mysqli_num_rows($res) > 0 && $new_tit != $tut_tit) {
                    echo '<script>
                    alert("Title already exists, try again!");
                    </script>';
                }
                else if (rtrim($tut_content == '')) {
                    echo '<script>
                    alert("Tutorial description field is blank, try again!");
                    </script>';
                }
                else {
                    $qry = "UPDATE Tutorial SET Title = '{$new_tit}', Content = '{$tut_content}', Author = '{$tut_auth}', Category = '{$tut_cat}' WHERE Id = {$tid};";
                    mysqli_query($con, $qry) or die('Updation failed!');

                    echo '<script>
                        alert("Tutorial updated successfully!");
                    </script>';
                }
                echo '<script>
                    if (window.history.replaceState) {
                        window.history.replaceState(null, null, window.location.href);
                    }
                    window.location.reload();
                </script>';
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
        CKFinder.setupCKEditor(CKEDITOR.replace('xyz'));
    </script>
</body>

</html>