<?php
include 'keep_secure.php';
$nm = $_SESSION['Name'];
$em = $_SESSION['Email'];
$u_nm = $_SESSION['Username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact-Codeware</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <div class="contain">
        <?php include 'nav_bar.php';?>
        <div class="update_profile_page">
            <h1 class="text-primary text-center mt-5"><b>Contact Us</b></h1>
            <div class="mb-5 px-5 py-5 mx-lg-5 shadow-lg bg-white rounded">
                <?php
                if (isset ($_GET['error'])) {
                    echo ('<div class="alert alert-danger text-center">Empty fields! Enter again!</div>');
                }
                if(isset($_GET['success']))
                {
                    echo '<div class="alert alert-success">Your Message Has Been Sent!</div>';
                }
                ?>
                <form action="contact_process.php" method="POST">
                    <div class="form-group">
                        <label for="X1"><b>Full Name:</b></label>
                        <input type="text" name="name" value="<?php echo ($nm) ?>" class="form-control" id="X1" disabled>
                    </div>
                    <div class="form-group">
                        <label for="X2"><b>Username</b></label>
                        <input type="text" name="username" value="<?php echo ($u_nm) ?>" class="form-control"
                            id="X2" disabled>
                    </div>
                    <div class="form-group">
                        <label for="X3"><b>Email Address:</b></label>
                        <input type="email" name="email" value="<?php echo ($em) ?>" class="form-control" id="X3" disabled>
                    </div>
                    <div class="form-group">
                        <label for="X4"><b>Subject</b></label>
                        <input type="text" name="subj" class="form-control" placeholder="About What?" id="X4">
                    </div>
                    <div class="form-group">
                        <label for="X5"><b>Your Message:</b></label>
                        <textarea name="msg" class="form-control mb-2" placeholder="Write The Message" id="X5"></textarea>
                    </div>
                    <div class="reg_btn mt-4 justify-content-center justify-content-lg-start">
                        <button type="submit" name="btn-send" class="btn btn-success"><b>Send</b></button>
                    </div>
                </form>
            </div>
        </div>     

        <?php include 'footer.php';?>
    </div>
    <script src="jquery/jquery-3.6.0.slim.min.js" type="text/javascript"></script>
	<script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
</body>

</html>