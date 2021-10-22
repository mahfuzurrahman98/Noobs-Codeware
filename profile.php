<?php 

include 'connection.php';
include 'security.php';

if (!isset($_GET['user'])) {
    exit('No such pages found!');
}

$prof_unm = $_GET['user'];
$reg_dt = date('M j Y', strtotime($_SESSION['Reg_Time']));
$qry = "SELECT * From User WHERE Username = '{$prof_unm}';";
$res = mysqli_query($con, $qry) or exit('<h1>No such users found!</h1>');

if (mysqli_num_rows($res) == 0) {
    exit('<h1>No such users found!</h1>');
}

while ($row = mysqli_fetch_assoc($res)) {
	$_Name = $row['Name'];
	$prof_pic = $row['Profile_Picture'];
	$_Email = $row['Email'];
	$_Institute = $row['Institute'];
	$cfh = $row['CF_Handle'];
	$uh = $row['UVa_Handle'];
	$about = $row['About'];
	$reg_dt = date('M j Y', strtotime($row['Reg_Time']));
}
$cur_file = "uploads/user/profile_picture/{$prof_pic}";
$uv_id = load('uname2uid', $uh);
$cf_link = "https://codeforces.com/profile/" . $cfh;
$uva_link = "https://uhunt.onlinejudge.org/id/" . $uv_id;
$you = TRUE;
if ($_SESSION['Username'] != $prof_unm) {
	$you = FALSE;
}

$qry_flw = "SELECT * FROM Friend WHERE _user = '{$_SESSION['Username']}' AND Followed = '{$prof_unm}';";
$res_flw = mysqli_query($con, $qry_flw) or die("Query Follower Failed!");

function load($node, $arguments = array()) {
    $arrContextOptions = array(
        "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false,
        ),
    );
    $source = 'https://uhunt.onlinejudge.org/api/';

    if (is_array($arguments) === false) {
        $arguments = array($arguments);
    }
    if (empty($arguments)) {
        $response = file_get_contents($source . $node);
    } else {
        foreach ($arguments as &$argument) {
            if (is_array($argument)) {
                $argument = implode(',', $argument);
            }
        }
        $response = file_get_contents($source . $node . '/' . implode('/', $arguments), false, stream_context_create($arrContextOptions));
    }
    return json_decode($response, true);
}

$qry = "SELECT DISTINCT Problem_Title FROM Submission WHERE Username = '{$prof_unm}';";
$res = mysqli_query($con, $qry);
$Try = mysqli_num_rows(mysqli_query($con, $qry));

$qry = "SELECT DISTINCT Problem_Title FROM Submission WHERE Verdict = 'Accepted' AND Username = '{$prof_unm}';";
$res = mysqli_query($con, $qry);
$Solve = mysqli_num_rows(mysqli_query($con, $qry));

$qry = "SELECT * FROM Submission WHERE Username = '{$prof_unm}' AND Verdict LIKE 'Comp%';";
$res = mysqli_query($con, $qry);
$CE = mysqli_num_rows(mysqli_query($con, $qry));

$qry = "SELECT * FROM Submission WHERE Username = '{$prof_unm}' AND Verdict LIKE 'RE%';";
$res = mysqli_query($con, $qry);
$RE = mysqli_num_rows(mysqli_query($con, $qry));

$qry = "SELECT * FROM Submission WHERE Username = '{$prof_unm}' AND Verdict LIKE 'MLE%';";
$res = mysqli_query($con, $qry);
$MLE = mysqli_num_rows(mysqli_query($con, $qry));

$qry = "SELECT * FROM Submission WHERE Username = '{$prof_unm}' AND Verdict LIKE 'TLE%';";
$res = mysqli_query($con, $qry);
$TLE = mysqli_num_rows(mysqli_query($con, $qry));

$qry = "SELECT * FROM Submission WHERE Username = '{$prof_unm}' AND Verdict LIKE 'WA%';";
$res = mysqli_query($con, $qry);
$WA = mysqli_num_rows(mysqli_query($con, $qry));

$qry = "SELECT * FROM Submission WHERE Username = '{$prof_unm}' AND Verdict LIKE 'Acc%';";
$res = mysqli_query($con, $qry);
$Acc = mysqli_num_rows(mysqli_query($con, $qry));

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>@<?php echo $prof_unm; ?></title>
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="fontawesome/css/all.css">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<?php include 'nav_bar.php'; ?>
		<div class="container-fluid">
				<div class="col-12 mt-0">
				<?php
				if ($_SESSION['Role'] == 1 AND $you) {
					echo('<div class="text-center alert alert-warning mt-3">You are an admin, To manage go to ' . '<a href = "Admin/index.php">Admin Panel</a></div>');
				}	
				?>
				</div>
			<div class="row mt-3 mx-1 mx-lg-3 shadow-lg bg-white rounded py-3">
				<div class="col-12 col-lg-6 text-center">
					<?php
					if (is_null($prof_pic)) {
						echo '<i class="fas fa-user-circle fa-8x"></i>';
					}
					else {
						echo '<img class="image_prof img rounded-circle" src="'.$cur_file.'" alt="">';
					}
					?>
					<h4 class="text-center mt-1"><?php echo($_Name); ?></h4>
					<h5 class="text-muted text-center">@<?php echo($prof_unm); ?></h5>
				</div>
				<div class="col-12 col-lg-6">
					<h5><b>About:</b></h5>
					<?php echo $about; ?>
				</div>
			</div>
			<div class="row my-5">
				<div class="col-12 col-lg-5">
					<div class="shadow-lg bg-white rounded p-3">
						<h3>Info</h3><hr>
						<b>Registered on:</b> <?php echo $reg_dt;?> <br>
						<b>Email:</b> <?php echo($_Email); ?><br>
						<b>Institute:</b> <?php echo($_Institute); ?><br>
						<b>Codeforces Handle:</b> <?php echo "<a href='$cf_link' target = 'blank' class='text-primary'>$cfh</a>"; ?>
						<br>
						<b>UVa Handle:</b> <?php echo "<a href='$uva_link' target = 'blank' class='text-primary'>$uh</a>"; ?><br><br>
						<?php if ($you) { ?>
						<a href="setting.php" class="btn btn-sm btn-success">Update</a>
						<?php } if (!$you) {?>
						<div class="mt-1">
							<?php if (mysqli_num_rows($res_flw) == 0) { ?>
							<form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
								<button type="submit" name="flw" class="btn btn-success"><b>Follow</b></button>
							</form>
							<?php } else { ?>
								<form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
								<button type="submit" name="unflw" class="btn btn-danger"><b>Unfollow</b></button>
								</form>
							<?php } ?>
                    	</div>
						<?php } ?>
					</div>
					<div class="mt-2">
						<?php if (!$you) { ?>
						<p><a href="oj_stats.php?user=<?php echo $prof_unm; ?>">See</a> the performence statistics of <?php echo $_Name; ?> on Codeforces & UVa.</p>
						<?php } else {?>
						<p><a href="friends.php">Check</a> your followers & the people you follow.</p>
						<?php } ?>
					</div>
				</div>
				<div class="col-12 col-lg-7">
					<div class="text-center bg-light p-3 h4">
						<?php echo 'Tried: ' . $Try . '  |   Solved: ' . $Solve; ?>
					</p>
					<div id="chart_div"></div>
				</div>
			</div>

			<?php
			if (isset($_POST['flw'])) {
				$qry_flw_upd = "INSERT INTO Friend(_user, Followed) VALUES('{$_SESSION['Username']}', '{$prof_unm}');";
				mysqli_query($con, $qry_flw_upd);
				echo '<script>
				if (window.history.replaceState) {
					window.history.replaceState(null, null, window.location.href);
				}
				window.location.reload();
			</script>';
			}
			if (isset($_POST['unflw'])) {
				$qry_unflw_upd = "DELETE FROM Friend WHERE (_user = '{$_SESSION['Username']}' AND Followed = '{$prof_unm}');";
				mysqli_query($con, $qry_unflw_upd);
				echo '<script>
				if (window.history.replaceState) {
					window.history.replaceState(null, null, window.location.href);
				}
				window.location.reload();
			</script>';
			}
			?>
		</div>
		<?php include 'footer.php'; ?>
		<script src="js/jquery-3.6.0.js" type="text/javascript"></script>
		<script src="js/bootstrap.bundle.js" type="text/javascript"></script>
		<script src="js/nav_bar.js" type="text/javascript"></script>
		<script src = "https://www.gstatic.com/charts/loader.js"></script>
	    <script type="text/javascript">
	        google.charts.load('current', {'packages':['corechart']});
	        google.charts.setOnLoadCallback(drawChart);
	        function drawChart() {
	            var data = new google.visualization.DataTable();
	            data.addColumn('string', 'Topping');
	            data.addColumn('number', 'Slices');
	            data.addRows([
	                ['Runtime Error', <?php echo $RE; ?>],
	                ['Wrong Answer', <?php echo $WA; ?>],
	                ['Compilation Error', <?php echo $CE; ?>],
	                ['Accepted', <?php echo $Acc; ?>],
	                ['Time Limit Exceeded', <?php echo $TLE; ?>],
	                ['Memory Limit Exceeded', <?php echo $MLE; ?>]
	            ]);

	            var options = {height: 450};
	            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
	            chart.draw(data, options);
	        }
	        $(window).resize(function(){
	            drawChart();
	        });
	    </script>
	</body>
</html>