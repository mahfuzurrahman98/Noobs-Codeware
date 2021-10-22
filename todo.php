<?php
include 'connection.php';
include 'security.php';
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Todo-Codeware</title>
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="fontawesome/css/all.css">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<?php include 'nav_bar.php'; ?>
		<div class="contain">
			<div class="border border-grey my-5">
				<div class="nxt-prblm-slv p-2">

					<h3 class="mt-2 mb-5 text-dark text-center"><i class="fas fa-th-list"></i> <span class="text-success">TODO <span class="text-dark">List</span></span></h3>
					<?php
					$qry_todo = "SELECT * FROM Todo WHERE _user = '{$_SESSION['Username']}';";
					$res_todo = mysqli_query($con, $qry_todo) or die("Query Failed!");
					if (mysqli_num_rows($res_todo) == 0) {
						echo '<h5 class="mt-2 mb-5 text-center text-danger">No problems in the list</h5>';
					}
					else { ?>
					<table class="table table-hover table-striped">
						<thead>
							<tr>
								<td><b>Title</b></td>
								<td><b>When Added</b></td>
							</tr>
						</thead>
						<tbody>
						<?php
						while ($row = mysqli_fetch_assoc($res_todo)) {
							$who = $row['_user'];
							$prb_id = $row['Problem_Id'];
							$prb_tit = $row['Problem_Title'];
							$prb_tim = $row['Added_Time'];
							
							echo '<tr>';
								echo '<td>' . $prb_tit . '</td>';
								echo '<td>' . $prb_tim . '</td>';
								echo '<td>
									<form action="'.$_SERVER['PHP_SELF'].'" method="POST">
										<a type="button" class="btn btn-sm mx-1 btn-success" href="problem/details.php?id=' . $prb_id. '">Solve</a>
										<input type="hidden" name="uid" value="'.$who.'">
										<input type="hidden" name="ptit" value="'.$prb_tit.'">
										<button type="submit" name="rm" class="btn btn-sm mx-1 btn-danger">Remove</button>
									</form>
								</td>';
							echo '</tr>';
						}
						?>
						
						</tbody>
					</table>
				<?php } ?>
				</div>
			</div>
			<?php
			if (isset($_POST['rm'])) {
				$uid = $_POST['uid'];
				$ptit = $_POST['ptit'];
	            $qry_rm = "DELETE FROM Todo WHERE _user = '{$uid}' AND Problem_Title = '{$ptit}';";
	            $res_rm = mysqli_query($con, $qry_rm);
	            echo '<script>
	            if (window.history.replaceState) {
	                window.history.replaceState(null, null, window.location.href);
	            }
	            window.location.reload();
	            </script>';
        	}
			?>
		</div>
		<script src="js/jquery-3.6.0.js" type="text/javascript"></script>
		<script src="js/bootstrap.bundle.js" type="text/javascript"></script>
		<script src="js/nav_bar.js" type="text/javascript"></script>
	</body>
</html>