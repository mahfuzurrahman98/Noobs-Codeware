<?php 
include '../../connection.php';
include 'security.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Tutorial</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <?php include 'nav_bar.php'; ?>
    <div class="container-fluid">
        <div class="mt-5">
            <h2 class="text-center text-success mb-3">Add a tutorial</h2>
            <form class = "shadow-lg p-3 bg-light rounded mb-4" action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                <div class="row">
                    <div class="form-group col-12 col-md-6">
                        <label><b>Title:</b></label>
                        <input type="text" name="tut_tit" class="form-control" pattern="[-'"_A-Za-z 0-9]+" title="Only alphanumeric, hyphen, underscore and qoutes are allowed" placeholder="Enter the title" required>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label><b>Category:</b></label>
                        <select class="form-control" name="tut_cat">
                            <option selected value="Algorithm">Algorithm</option>
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
                </div>
                <div class="form-group">
                    <label><b>Description:</b></label>
                    <textarea name="tut_content" class="form-control" id="xyz" required></textarea>
                </div>
                <button type="submit" name="pub" class="btn btn-success mt-2"><b>Publish</b></button>
            </form>

            <?php
            if (isset($_POST['pub'])) {
                $tut_tit = trim(mysqli_real_escape_string($con, $_POST['tut_tit']));
                $tut_auth = $_SESSION['Username'];
                $tut_cat = $_POST['tut_cat'];
                $tut_content = $_POST['tut_content'];

                $qry = "SELECT Id FROM Tutorial WHERE Title = '{$tut_tit}';";
                $res = mysqli_query($con, $qry) or die('Selection failed!');

                if (mysqli_num_rows($res) > 0) {
                    echo '<script>
                        alert("Title already exists, try again!");
                    </script>';
                }
                else if (trim($tut_content == '')) {
                    echo '<script>
                        alert("Tutorial description field is blank, try again!");
                    </script>';
                }
                else {
                    $qry = "INSERT INTO Tutorial(Title, Content, Author, Category, Approved) VALUES('{$tut_tit}', '{$tut_content}', '{$tut_auth}', '{$tut_cat}', 0);";
                    $res = mysqli_query($con, $qry) or die('Insertion failed!');

                    echo '<script>
                        alert("Tutorial uploaded successfully!");
                        window.history.replaceState(null, null, window.location.href);
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
    <script>
        CKFinder.setupCKEditor(CKEDITOR.replace('xyz'));
    </script>
</body>

</html>