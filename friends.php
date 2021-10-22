<?php

include 'connection.php';
include 'security.php';

$nm = $_SESSION['Name'];
$unm = $_SESSION['Username'];

$qry_follower = "SELECT _user FROM Friend WHERE Followed = '{$unm}';";
$res_follower = mysqli_query($con, $qry_follower) or die("Query1 Failed!");

$qry_following = "SELECT User.Username FROM Friend JOIN User ON Friend.Followed = User.Id AND Friend.User_Id = {$_SESSION['Username']};";
$qry_following = "SELECT Followed FROM Friend WHERE _user = '{$unm}';";
$res_following = mysqli_query($con, $qry_following) or die("Query2 Failed!");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends-Codeware</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
    	.dv {
    		border-radius: 20px;
    	}
    </style>
</head>

<body>
	<?php include 'nav_bar.php'; ?>
    <div class="container-fluid">       
        <div class="row mb-5">
            <div class="col-12 col-md-6 mt-5">
                <div class="dv shadow-lg bg-white p-3 mx-3 mx-lg-5">
	                <table class="table table-hover table-sm text-center">
                		<h3 class="text-center text-success mb-3"><b>My Followers</b></h3>
						<tbody>
							<?php
							if (mysqli_num_rows($res_following) > 0) {
								while ($row = mysqli_fetch_assoc($res_following)) {
									$my_following = $row['Followed'];
	                                
									echo '<tr>';
	                                echo '<td><h5>'. '<a href="profile.php?user=' . $my_following . '">' . $my_following . '</a>'. '</h5></td>';
									echo '</tr>';
								}
							}
							?>
						</tbody>
					</table>
				</div>
            </div>

            <div class="col-12 col-md-6 mt-5">
                <div class="dv shadow-lg bg-white p-3 mx-3 mx-lg-5">
	                <table class="table table-hover table-sm text-center">
						<tbody>
                			<h3 class="text-center text-success mb-3"><b>My Followings</b></h3>
							<?php
							if (mysqli_num_rows($res_follower) > 0) {
								while ($row = mysqli_fetch_assoc($res_follower)) {
								$my_follower = $row['_user'];
	                                
									echo '<tr>';
	                                echo '<td><h5>'. '<a href="profile.php?user=' . $my_follower . '">' . $my_follower . '</a>'. '</h5></td>';
									echo '</tr>';
								}
							}
							?>
						</tbody>
					</table>
				</div>
            </div>
        </div>
    
        <?php include 'footer.php'; ?>
    </div>
    <script src="js/jquery-3.6.0.js" type="text/javascript"></script>
	<script src="js/bootstrap.bundle.js" type="text/javascript"></script>
	<script src="js/nav_bar.js" type="text/javascript"></script>
</body>

</html>