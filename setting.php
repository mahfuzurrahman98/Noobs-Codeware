<?php

include 'connection.php';
include 'security.php';

$prof_pic = $_SESSION['Profile_Picture'];
$nm = $_SESSION['Name'];
$em = $_SESSION['Email'];
$u_nm = $_SESSION['Username'];
$institute = $_SESSION['Institute'];
$cfh = $_SESSION['CF_Handle'];
$uh = $_SESSION['UVa_Handle'];
$about = $_SESSION['About'];

$cur_file = "uploads/user/profile_picture/$prof_pic";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upate Profile-Codeware</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
    textarea {
        resize: none;
    }
    </style>
</head>

<body>

    <?php include 'nav_bar.php'; ?>
    <div class="container-fluid">
        <h1 class="text-success text-center mt-5"><b>Update Information</b></h1>
        <div class="text-center mt-5">
        <?php
        if (is_null($prof_pic)) {
            echo '<i class="fas fa-user-circle fa-8x"></i>';
        }
        else {
            echo '<img class="image_prof img rounded-circle" src="'.$cur_file.'" alt="">';
        }
        ?>
        </div>
        <form class="mt-3" action="<?php $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
            <div class="justify-content-center d-flex">
                <div class="form-group">
                    <input type="file" name="pic_file" class="form-control-file" id="Xx4">
                </div>
            </div>
            <div class="form-group justify-content-center d-flex">
                <button type="submit" name="btn_upd_pic" class="btn btn-success"><b>Update</b></button>
            </div>
        </form>
        <?php
        if (isset($_POST['btn_upd_pic'])) {
            if (isset($_FILES['pic_file'])) {
                $fname = $_FILES['pic_file']['name'];
                $ftmp = $_FILES['pic_file']['tmp_name'];
                $ftyp = $_FILES['pic_file']['type'];
                $fext = strtolower(substr($fname, strrpos($fname, '.')  + 1));
                echo $fname; echo '<br>'; echo $ftmp;
                if ($fext == 'jpg' OR $fext == 'jpeg' OR $fext == 'png') {
                    //first delete current file
                    if(!is_null($prof_pic)) {
                        unlink($cur_file);
                    }
                    
                    move_uploaded_file($ftmp, "uploads/profile_picture/" . $fname);
                    echo $qry_pic = "UPDATE User SET Profile_Picture = '{$fname}' WHERE Id = {$_SESSION['Id']};";
                    mysqli_query($con, $qry_pic) or die('Picture Update Failed!');
                    echo '<script>
                        if (window.history.replaceState) {
                            window.history.replaceState(null, null, window.location.href);
                        }
                        alert("Picture updated successfully!");
                    </script>';
                    //session_unset();
                    session_destroy();
                    echo '<script>window.location.reload();</script>';
                }
                else {
                    echo '<script>
                        if (window.history.replaceState) {
                            window.history.replaceState(null, null, window.location.href);
                        }
                        alert("Only JPG, JPEG, PNG are allowed to upload!");
                        window.location.reload();
                    </script>';
                }
            }
        }
        ?>
        <div class="p-2 mb-5 shadow-lg">
            <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><b>Full Name:</b></label>
                        <input type="text" name="name" value="<?php echo ($nm) ?>" class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <label><b>Email Address:</b></label>
                        <input type="email" name="email" value="<?php echo ($em) ?>" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                     <b>Username</b> (<span class="text-danger">changing not allowed</span>)</label>
                        <input type="text" name="username" value="<?php echo ($u_nm) ?>" class="form-control disabled"
                     disabled>
                    </div>
                    <div class="col-md-6 form-group">
                        <label><b>Institute:</b></label>
                        <input type="text" name="inst" value="<?php echo ($institute) ?>" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><b>UVa Handle:</b></label>
                        <input type="text" name="uva" value="<?php echo ($uh) ?>" class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <label><b>Codeforces Handle:</b></label>
                        <input type="text" name="cf" value="<?php echo ($cfh) ?>" class="form-control">
                    </div>
                    <div class="col form-group">
                        <label for="text"><b>About Yourself:</b></label> (<span class="mt-1 " id="count_message"></span>)
                        <textarea class="form-control" id="text" name="abt" maxlength="255" rows="3"><?php echo $about;?></textarea>
                    </div>
                </div>
                <div class="mt-1 justify-content-center justify-content-lg-start">
                    <button type="submit" name="upd_info" class="btn btn-success"><b>Update</b></button>
                </div>
            </form>
        </div>

        <div class="p-2 shadow-lg">
            <h3 class="text-primary text-center mb-5"><b>Password Change</b></h3>
            <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST" class="row">
                <div class="col-md-5 form-group">
                    <label><b>Enter the old password</b></label>
                    <input type="password" name="old_pass" class="form-control" placeholder="*****">
                </div>
                <div class="col-md-5 form-group">
                    <label><b>Enter a new password</b></label>
                    <input type="password" name="new_pass" class="form-control" placeholder="*****">
                </div>

                <div class="col-md-2 mt-md-4 mt-1 justify-content-center justify-content-lg-start">
                    <button type="submit" name="upd_pass" class="btn btn-sm btn-success"><b>Update</b></button>
                </div>
            </form>
        </div>
        <?php
        if (isset($_POST['upd_info'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $inst = $_POST['inst'];
            $cf = $_POST['cf'];
            $uva = $_POST['uva'];            
            $abt = $_POST['abt'];


            $qry_info = "UPDATE User SET 
                Name = '{$name}', 
                Email = '{$email}',
                Institute = '{$inst}', 
                CF_Handle = '{$cf}', 
                UVa_Handle = '{$uva}',
                About = '{$abt}'
                WHERE Username = '{$u_nm}';
            ";
            mysqli_query($con, $qry_info);

            echo '<script>
                if (window.history.replaceState) {
                    window.history.replaceState(null, null, window.location.href);
                }
                window.location.reload();
            </script>';
            session_unset();
            session_destroy();
        }
        if (isset($_POST['upd_pass'])) {
            $old_pass = $_POST['old_pass'];
            $new_pass = $_POST['new_pass'];

            $qry_pass = "SELECT Id FROM User WHERE Username = '{$u_nm}' AND Password = '{$old_pass}';";
            $res_pass = mysqli_query($con, $qry_pass) or die("Query Failed!");

            if (mysqli_num_rows($res_pass) > 0) {
                $qry_pass2 = "UPDATE User SET Password = '{$new_pass}' WHERE Username = '{$u_nm}';";
                mysqli_query($con, $qry_pass2);
                session_unset();
                session_destroy();
                echo "<script>
					if (window.history.replaceState) {
                        window.history.replaceState(null, null, window.location.href);
                        window.location.reload();
                        window.location.href = 'logout.php';
                        alert('Password updated successfully! Please login again.');
					}
				</script>";
            } 
            else {
                echo '<script>alert("Password not matched!")</script>';
            }
        }
        ?>
    
        <?php include 'footer.php'; ?>
    </div>
    <script src="js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="js/nav_bar.js" type="text/javascript"></script>
    <script>
        var text_max = 255;
        $('#count_message').html('0 / ' + text_max );
        $('#text').keyup(function() {
            var text_length = $('#text').val().length;
            var text_remaining = text_max - text_length;
            $('#count_message').html(text_length + ' / ' + text_max);
        });
    </script>
</body>

</html>