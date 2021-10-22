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
		<title>Register-Codeware</title>
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="fontawesome/css/all.css">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
			
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	        <a class="navbar-brand ml-2 mr-auto" href="index.php">
	            <span class="text-white"><b><span class="text-success">Noobs </span>Codeware</b></span>
	        </a>
	        <a href="login.php" class="btn btn-sm btn-success">
	            <span class="text-white ">Login</span>
	        </a>
		</nav>

		<div class="contain">
			<div class="reg_page mx-lg-5 mb-5">
				<h1 class="text-success text-center mt-5"><b>Get Registered</b></h1>
				<h6 class="text-muted text-center mb-4">Sign up with your details</h6>
				<div class="mb-5 px-3 px-lg-5 py-5 mx-lg-5 shadow-lg bg-white rounded">
					<form class ="px-lg-3" action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
						<div class="form-group text-success h5">
							<label><b>Full Name</b></label>
							<input type="text" name="name" class="form-control" pattern="[A-Z a-z]+" title="Only alphabets" placeholder="Enter Your Full Name" required>
						</div>
						<div class="form-group text-success h5">
							<label><b>Email Address</b></label>
							<input type="email" name="email" class="form-control" placeholder="Enter Your Email" required>
						</div>
						<div class="form-group text-success h5">
							<label><b>Enter a Username</b></label>
							<input type="text" name="username" class="form-control" pattern="[A-Za-z_0-9]+" title="Only alphanumeric and underscore are allowed" placeholder="*Required when login" required>
						</div>
						<div class="form-group text-success h5">
							<label><b>Enter a Password</b></label>
							<input type="password" name="pwd1" class="form-control" placeholder="*Required when login" required>
						</div>
						<div class="form-group text-success h5">
							<label><b>Re enter the password</b></label>
							<input type="password" name="pwd2" class="form-control" placeholder="*Required when login" required>
						</div>
						<div class="reg_btn mt-4 justify-content-center justify-content-lg-start">
							<button type="submit" name="signup" class="btn btn-success"><b>Sign Up</b></button>
						</div>
						<p class="mt-3">Already have an account? <a href="login.php">Login.</a></p>
					</form>
				</div>
			</div>
			<?php 
			if (isset($_POST['signup'])) {
	        	$name = trim($_POST['name']);
	        	$email = trim($_POST['email']);
	        	$username = $_POST['username'];
	        	$password1 = $_POST['pwd1'];
	        	$password2 = $_POST['pwd2'];
	        		        	
	        	$qry_em = "SELECT Id FROM User WHERE Email = '{$email}';";
	        	$res_em = mysqli_query($con, $qry_em) or die("Query Failed!");
	        	$qry_unm = "SELECT Id FROM User WHERE Username = '{$username}';";
	        	$res_unm = mysqli_query($con, $qry_unm) or die("Query Failed!");

	        	if (mysqli_num_rows($res_em) > 0) {
	        		echo "<script>alert('Email already exists, try again!')</script>";
	        	}
	        	else if (mysqli_num_rows($res_unm) > 0) {
	        		echo "<script>alert('Username already exists, try again!')</script>";
	        	}
	        	else if ($password1 != $password2) {
	        		echo "<script>alert('Password does not match, try again!')</script>";
	        	}
	        	else {
					$qry = "INSERT INTO User(Name, Email, Username, Password, CF_Handle, UVa_Handle) VALUES('{$name}', '{$email}', '{$username}', '{$password1}', '{$username}', '{$username}');";
	        		/*echo '<script>
						if (window.history.replaceState) {
							window.history.replaceState(null, null, window.location.href);
						}
						window.location.reload();
					</script>';*/
	        		mysqli_query($con, $qry) or die('Registration Failed');
	        		//header("Location: login.php");
	        	}
	        }
			
			?>
		</div>
		<script src="js/jquery-3.6.0.js" type="text/javascript"></script>
		<script src="js/bootstrap.bundle.js" type="text/javascript"></script>
	</body>
</html>