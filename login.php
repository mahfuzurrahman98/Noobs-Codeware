<?php
include 'connection.php';
if (isset($_SESSION["Username"])) {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login-Codeware</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand ml-2 mr-auto" href="index.php">
            <span class="text-white"><b><span class="text-success">Noobs </span>Codeware</b></span>
        </a>
        <a href="register.php" class="btn btn-sm btn-success">
            <span class="text-white ">Register</span>
        </a>
    </nav>
    <div class="container-fluid">
        <h1 class="h1 text-success text-center my-5"><b>Login to Enter</b></h1>

        <div class="row px-3 px-lg-5">

            <div class="col d-none d-lg-block d-xl">
                <img src="images/login_pic.png" class="w-75 h-75">
            </div>
            <div class="col-12 col-lg-6 mb-5 px-3 px-lg-5 py-4 shadow-lg bg-white rounded">
                <?php
                if (isset ($_GET['error'])) {
                    echo ('<div class="shadow shadow-lg alert alert-danger text-center">Login Failed! Incorrect Username or Password!</div>');
                }
                ?>
                <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                    <div class="form-group text-success h5">
                        <label for="X1"><b>Username:</b></label>
                        <input type="text" name="username" class="form-control" id="X1" pattern="[A-Za-z_0-9]+" title="Only alphanumeric and underscore are allowed" placeholder="Enter Username" required>
                    </div>
                    <div class="form-group text-success h5">
                        <label for="X2"><b>Password:</b></label>
                        <input type="password" name="password" class="form-control" id="X2" placeholder="Enter Password" required>
                    </div>
                    <!--<div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Remember me</label>
                    </div>-->
                    <div class="mt-3 d-flex justify-content-center justify-content-lg-start">
                        <button class="btn btn-success" type="submit" name="login">Login</button>
                    </div>
                    <p class="mt-3 text-center text-lg-left">Haven't registered yet? <a href="register.php">Sign Up.</a></p>
                    <p class="mt-3 text-center text-lg-left"> <a href="#" class="text-danger" data-toggle="modal" data-target="#reset_pass">Forgot password?</a></p>
                </form>
            </div>
        </div>
        <?php
        if (isset($_POST['login'])) {
        	$username = mysqli_real_escape_string($con, $_POST['username']);
        	$password = mysqli_real_escape_string($con, $_POST['password']);
        	$qry = "SELECT * FROM User WHERE (Username = '{$username}' OR Email = '{$username}') AND Password = '{$password}';";
        	$res = mysqli_query($con, $qry) or die("Query Failed!");
            
        	if (mysqli_num_rows($res) > 0) {
        		while ($row = mysqli_fetch_assoc($res)) {
        			session_start();
        			$_SESSION['Username'] = $row['Username'];
                    $_SESSION['Name'] = $row['Name'];
                    $_SESSION['Email'] = $row['Email'];
                    $_SESSION['Profile_Picture'] = $row['Profile_Picture'];
                    $_SESSION['Institute'] = $row['Institute'];
                    $_SESSION['CF_Handle'] = $row['CF_Handle'];
                    $_SESSION['UVa_Handle'] = $row['UVa_Handle'];
        			$_SESSION['Role'] = $row['Role'];
        			$_SESSION['About'] = $row['About'];
                    $_SESSION['Reg_Time'] = $row['Reg_Time'];
        			$_SESSION['Notification_Seen'] = $row['Notification_Seen'];
                    header("Location: index.php");
        		}
        	}
        	else {
                header('Location: login.php?error');
            }
        }
        ?>
        <div class="modal fade" data-keyboard="false" data-backdrop="static" id="reset_pass" tabindex="-1"
            role="dialog" aria-labelledby="upd_updinfoLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="upd_updinfoLabel">Reset Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body rounded">
                        <form class = "rounded mb-4" action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                            <div class="form-group">
                                <label for="X11"><b>Email:</b></label>
                                <input type="text" name="reset_em" class="form-control" id="X11" placeholder="Enter your email" required="">
                            </div>
                            <div class="form-group">
                                <label for="X21"><b>Username:</b></label>
                                <input type="text" name="reset_unm" class="form-control" id="X21" placeholder="Enter your username" required="">
                            </div>
                            <div class="mt-3 d-flex justify-content-center justify-content-lg-start">
                                <button type="submit" name="reset_btn" class="btn btn-success center"><b>Reset</b></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <script src="js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="js/bootstrap.bundle.js" type="text/javascript"></script>
</body>

</html>
