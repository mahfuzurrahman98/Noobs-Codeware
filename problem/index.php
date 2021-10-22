<?php
include '../connection.php'; 
include 'security.php';
?>

<script>
	var xy = 1;
	var tag_arr = [];
</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problemset-Codeware</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/select2.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include 'nav_bar.php'; ?>
    <div class="container-fluid">
        <div class="text-success text-center mt-5 mb-3">
            <h3><b>Noobs Problemset</b></h3>
        </div>
        <div class="row p-2">
    		<div class="col-12 col-lg-4 mb-3 mb-lg-0">
				<div class="shadow-lg bg-light text-center rounded p-2 mb-3">
					<?php include 'last_unsolved.php'; ?>
				</div>
				<div class="bg-light px-2 rounded">
    				<?php include 'filter_problem.php'; ?>
				</div>
    		</div>
    		<div class="col-12 col-lg-8">
                <div class="text-right">
                    <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                        <span class="shadow-lg bg-light p-2 rounded-pill"><button class="btn btn-warning btn-sm rounded-pill" type="submit" name="rand_one"><b>Pick</b></button> <span class="text-secondary">a random one</span></span>
                    </form>
                    <?php if (isset($_POST['rand_one'])) {
                        $qry_rand = "SELECT Id FROM Problem ORDER BY RAND() LIMIT 1;";
                        $res_rand = mysqli_query($con, $qry_rand);
                        while ($row = mysqli_fetch_assoc($res_rand)) {
                            $rand_id = $row['Id'];
                        }
                        echo '<script>window.history.replaceState(null, null, window.location.href)</script>';
                        echo '<script>window.location.href="details.php?id='.$rand_id.'"</script>';
                        echo '<script>window.location.reload()</script>';
                    }
                    ?>
                </div>
    			<table class="table table-hover justify-content-center bg-light rounded">
                    <thead>
                        <tr class="text-muted">
                            <td><b>Title</b></td>
                            <td><b>Difficulty</b></td>
                            <td><b>Acceptance</b></td>
                            <td><b>Tried</b></td>
                        </tr>
                    </thead>
    				<tbody class="show">
    					
    				</tbody>
    			</table>
                <div class="text-right">
                    <a href="../rank.php"><u>See ranklist</u></a>
                </div>
    		</div>
        </div>
        <div class="my-5 justify-content-center d-flex">
            <ul class="pagination shadow shadow-lg bg-light">
                <li id="Prev" class="page-item"><button data-id="prv" class="page-link">Prev</button></li>
                <li class="page-item disabled"><button id="cur_pg" class="page-link text-success">1</button></li>
                <li id="Next" class="page-item"><button data-id="nxt" class="page-link">Next</button></li>
            </ul>
        </div>
        <?php include '../footer.php'; ?>
    </div>
    <script src="../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="../js/select2.js" type="text/javascript"></script>
    <script>
        $(document).ready(function(){
            $(".mul-select").select2({
                placeholder: "Search and select",
                tokenSeparators: ['/',',',';'," "] 
            });
            loadData();
        });
        $(".page-link").click(function() {
            var z = $(this).attr('data-id');
            if (z == "prv") { xy--; }
            else if (z == "nxt") { xy++; }
            $('#cur_pg').html(xy);
            loadData();
        });
        function filterData() {
            xy = 1;
            loadData();
        }
        function loadData() {
            if (xy == 1) {
                $("#Prev").attr('class', 'page-item disabled');
            }
            else {
                $("#Prev").attr('class', 'page-item');
            }

            $(".show").html('<?php
                echo '<tr class="text-dark text-center">';
                    echo '<td class="h3">Pr</td>';
                    echo '<td class="h3">oce</td>';
                    echo '<td class="h3">ss</td>';
                    echo '<td class="h3">ing</td>';
                echo '</tr>';
            ?>');
            tg_arr = $("#tg").val();
            tg_arr.push('%');
            $.ajax({
                url: "load.php",
                method: "POST",
                data: {
                    title: $("#tt").val(),
		    		diff: $("#df").val(),
		    		status: $("#st").val(),
		    		tags: tg_arr,
		    		sort: $("#srt").val(),
                    page: xy
                },
                success: function(response) {
                    if (response.length < 300) {
                        $("#Next").attr('class', 'page-item disabled');$(".show").html(
                            '<tr class="text-danger text-center">' +
                            '<td>No</td>' +
                            '<td>results</td>' +
                            '<td>are</td>' +
                            '<td>found</td>' +
                            '</tr>'
                        );
                    }
                    else {
                         $(".show").html(response)
                         $("#Next").attr('class', 'page-item');
                    }
                }
            });
        }
    </script>
</body>

</html>