<?php

include '../../connection.php';
include 'security.php';

$id = $_GET['id'];

$qry = "SELECT Title, Description, Problems, Start_Time, Finish_Time FROM Contest WHERE Id = '{$id}';";
$res = mysqli_query($con, $qry);
while ($row = mysqli_fetch_assoc($res)) {
    $tit = $row['Title'];
    $probs = explode(' ', $row['Problems']);
    $desc = $row['Description'];
    $beg_tym = $row['Start_Time'];
    $end_tym = $row['Finish_Time'];
}

?>
<script> var xy = 1; </script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status-Codeware</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/sidebar.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <input type="hidden" id="beg_tym_id" value="<?php echo $beg_tym; ?>">
    <input type="hidden" id="end_tym_id" value="<?php echo $end_tym; ?>">
    <div class="container-fluid">
        <div class="text-center">
            <h1 class="text-center text-dark mt-5"><?php echo $tit; ?></h1>
            <div id="status"></div>
            <div id="show_clock" class="h6"></div>
        </div>
        <nav class="my-5 prb_info_tab fub mx-3 mx-lg-5">
            <div class="row px-3 py-1 shadow-lg rounded text-center justify-content-center">
                <a class="col-12 col-lg-2 nav-link"
                    href="overview.php?id=<?php echo $id; ?>" role="tab"><b>Overview</b></a>
                <a class="col-12 col-lg-2 nav-link"
                    href="standing.php?id=<?php echo $id; ?>" role="tab"><b>Standing</b></a>
                <a class="col-12 col-lg-2 nav-link tab_active"
                    href="submission.php?id=<?php echo $id; ?>" role="tab"><b>Submission</b></a>
                <a class="col-12 col-lg-2 nav-link"
                    href="clarification.php?id=<?php echo $id; ?>" role="tab"><b>Clarification</b></a>
            </div>
        </nav>
        <div class="Filter">
            <div class="row p-2">
				<div class="col-3 form-group">
                    <label><b>Title:</b></label>
                    <input type="text" id="tit" class="form-control form-control-sm" placeholder="Problem Title" onkeyup="filterData()">
                </div>
                <div class="col-3 form-group">
                    <label><b>Username:</b></label>
                    <input id="unm" class="form-control form-control-sm" list="usr" placeholder="Username" onkeyup="filterData()"></label>
					<datalist id="usr">
						<option selected value="All">
						<option value="My Only">
						<option value="Friends Only">
					</datalist>
                </div>
				<div class="col-3 form-group">
					<label><b>Verdict:</b></label>
					<select id="ver" class="form-control form-control-sm" onchange="filterData()">
						<option selected value="All">All</option>
						<option value="Accepted">Accepted</option>
						<option value="Wrong Answer">Wrong Answer</option>
                        <option value="Time Limit Exceeded">Time Limit Exceeded</option>
                        <option value="Memory Limit Exceeded">Memory Limit Exceeded</option>
						<option value="Runtime Error">Runtime Error</option>
						<option value="Compilation Error">Compilation Error</option>
					</select>
				</div>
                <div class="col-3 form-group">
					<label><b>Language:</b></label>
					<select id="lang" class="form-control form-control-sm" onchange="filterData()">
                        <option selected value="All">All</option>
						<option value="C">C</option>
						<option value="C++">C++</option>
						<option value="Java">Java</option>
					</select>
				</div>
            </div>
        </div>
        
        <table class="table table-sm table-hover table-striped p-2 mb-5">
            <thead>
                <tr class="trow">
                    <td><b>Submission</b></td>
                    <td><b>Problem</b></td>
                    <td><b>Username</b></td>
                    <td><b>Verdict</b></td>
                    <td><b>Language</b></td>
                    <td><b>Time</b></td>
                    <td><b>Memory</b></td>
                    <td><b>When</b></td>
                </tr>
            </thead>
            <tbody class="show">

            </tbody>
        </table>

        <div class="modal fade" data-backdrop="static" id="show_code" tabindex="-1" role="dialog" aria-labelledby="addtestLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Submission</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body xyz">
                
                    </div>
                </div>
          </div>
        </div>

        <div class="mb-5 justify-content-center d-flex">
            <ul class="pagination">
                <li id="Prev" class="page-item"><button data-id="prv" class="page-link">Prev</button></li>
                <li><button data-id="1" class="page-link">1</button></li>
                <li><button data-id="2" class="page-link">2</button></li>
                <li><button data-id="3" class="page-link">3</button></li>
                <li><button class="btn btn-light">...</button></li>
                <li id="Next" class="page-item"><button data-id="nxt" class="page-link">Next</button></li>
            </ul>
        </div>
    </div>

    <script src="../../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="../../js/sidebar.js" type="text/javascript"></script>
    <script src="validate.js" type="text/javascript"></script>
    <script>
        $(".page-link").click(function() {
            var z = $(this).attr('data-id');
            if (z == "prv") { xy--; }
            else if (z == "1") { xy = 1; }
            else if (z == "2") { xy = 2; }
            else if (z == "3") { xy = 3; }
            else if (z == "nxt") { xy++; }
            loadData();
        });
        function filterData() {
            xy = 1;
            loadData();
        }
        function loadData() {
            console.log('xy: ', xy);
            if (xy == 1) {
                $("#Prev").attr('class', 'page-item disabled');
            }
            else {
                $("#Prev").attr('class', 'page-item');
            }

            $(".show").html('Processing.....')
            $.ajax({
                url: "load_sub.php",
                method: "POST",
                data: {
                    id: "<?php echo $id; ?>",
                    username: $("#unm").val(),
                    title: $("#tit").val(),
                    verdict: $("#ver").val(),
                    language: $("#lang").val(),
                    page: xy
                },
                success: function(response) {
                    // if (response.length < 100) {
                    //     //console.log('len: ' + response.length);
                    //     $("#Next").attr('class', 'page-item disabled');
                    //     $(".trow").html('');
                    //     $(".show").html('<div class="h1 my-5 text-center text-danger">No result found!</div>');
                    // }
                    //else {
                        $(".show").html(response)
                        //console.log('len: ' + response.length);
                        $("#Next").attr('class', 'page-item');
                    //}
                }
            })
        }
        loadData();
    </script>
</body>

</html>