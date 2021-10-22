<?php 

include '../connection.php'; 
include 'security.php';

if (!isset($_GET['id'])) {
    exit('No such page found!');
}

$No_Submission = FALSE;
$No_Accepted = FALSE;
$pid = $_GET['id'];
$unm = $_SESSION['Username'];
$qry = "SELECT Title FROM Problem WHERE Id = '{$pid}';";
$res = mysqli_query($con, $qry) or exit('No such problem found!');

if (mysqli_num_rows($res) == 0) {
    exit('No such problem found!');
}
$tit = mysqli_fetch_assoc($res)['Title'];

$qry = "SELECT * FROM Submission WHERE Problem_Title = '{$tit}';";
$res = mysqli_query($con, $qry);
if (mysqli_num_rows($res) == 0) {
    $No_Submission = TRUE;
}
else {
    $qry = "SELECT * FROM Problem_Statistics WHERE P_Id = '{$pid}';";
    $res = mysqli_query($con, $qry);
    $row = mysqli_fetch_assoc($res);
    $Sub = $row['No_Of_Sub'];
    $Try = $row['No_Of_User'];
    $CE = $row['No_Of_CE'];
    $RE = $row['No_Of_RE'];
    $TLE = $row['No_Of_TLE'];
    $MLE = $row['No_Of_MLE'];
    $WA = $row['No_Of_WA'];
    $Acc = $row['No_Of_Acc'];
    $Solve = $row['No_Of_Solve'];

    if ($Acc == 0) {
        $No_Accepted = TRUE;
    }
    else {
        //Earliest
        $qry_early = "SELECT * FROM Submission WHERE Problem_Title = '{$tit}' AND Verdict = 'Accepted' ORDER BY Sub_Time ASC LIMIT 1;";
        $res_early = mysqli_query($con, $qry_early);
        while ($row = mysqli_fetch_assoc($res_early)) {
            $early_sub_id = $row['Sub_Id'];
            $early_sub_tym = $row['Sub_Time'];
            $early_sub_unm = $row['Username'];
        }

        //Shortest
        $qry_short = "SELECT * FROM Submission WHERE Problem_Title = '{$tit}' AND Verdict = 'Accepted' ORDER BY Source_Size ASC LIMIT 1;";
        $res_short = mysqli_query($con, $qry_short);
        while ($row = mysqli_fetch_assoc($res_short)) {
            $short_sub_id = $row['Sub_Id'];
            $short_size = $row['Source_Size'];
            $short_sub_unm = $row['Username'];
        }

        //Longest
        $qry_long = "SELECT * FROM Submission WHERE Problem_Title = '{$tit}' AND Verdict = 'Accepted' ORDER BY Source_Size DESC LIMIT 1;";
        $res_long = mysqli_query($con, $qry_long);
        while ($row = mysqli_fetch_assoc($res_long)) {
            $long_sub_id = $row['Sub_Id'];
            $long_size = $row['Source_Size'];
            $long_sub_unm = $row['Username'];
        }

        //Fastest
        $qry_fast = "SELECT * FROM Submission WHERE Problem_Title = '{$tit}' AND Verdict = 'Accepted' ORDER BY Time ASC LIMIT 1;";
        $res_fast = mysqli_query($con, $qry_fast);
        while ($row = mysqli_fetch_assoc($res_fast)) {
            $fast_sub_id = $row['Sub_Id'];
            $fast_tym = $row['Time'];
            $fast_sub_unm = $row['Username'];
        }

        //Slowest
        $qry_slow = "SELECT * FROM Submission WHERE Problem_Title = '{$tit}' AND Verdict = 'Accepted' ORDER BY Time DESC LIMIT 1;";
        $res_slow = mysqli_query($con, $qry_slow);
        while ($row = mysqli_fetch_assoc($res_slow)) {
            $slow_sub_id = $row['Sub_Id'];
            $slow_tym = $row['Time'];
            $slow_sub_unm = $row['Username'];
        }

        //Lightest
        $qry_light = "SELECT * FROM Submission WHERE Problem_Title = '{$tit}' AND Verdict = 'Accepted' ORDER BY Memory ASC LIMIT 1;";
        $res_light = mysqli_query($con, $qry_light);
        while ($row = mysqli_fetch_assoc($res_light)) {
            $light_sub_id = $row['Sub_Id'];
            $light_mem = sprintf('%0.2f', $row['Memory'] / 1024);
            $light_sub_unm = $row['Username'];
        }

        //Heaviest
        $qry_heavy = "SELECT * FROM Submission WHERE Problem_Title = '{$tit}' AND Verdict = 'Accepted' ORDER BY Memory DESC LIMIT 1;";
        $res_heavy = mysqli_query($con, $qry_heavy);
        while ($row = mysqli_fetch_assoc($res_heavy)) {
            $heavy_sub_id = $row['Sub_Id'];
            $heavy_mem = sprintf('%0.2f', $row['Memory'] / 1024);
            $heavy_sub_unm = $row['Username'];
        }
    }
}

$qry_mysub = "SELECT * FROM Submission WHERE Username = '{$unm}' AND Problem_Title = '{$tit}' ORDER BY Sub_Time DESC;";
$my_sub = mysqli_query($con, $qry_mysub);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics-<?php echo $tit; ?></title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include 'nav_bar.php'; ?>
    <div class="container-fluid">
        <nav class="mx-5 prb_info_tab">
            <div class="row p-2 shadow shadow-lg bg-light rounded text-center justify-content-center mt-5 mb-5">
                <a class="col-12 my-1 col-lg-3 mx-2 my-lg-0 nav-link"
                    href="details.php?id=<?php echo $pid; ?>" role="tab"><b>Details</b></a>
                <a class="col-12 my-1 col-lg-3 mx-2 my-lg-0 nav-link tab_active"
                    href="statistics.php?id=<?php echo $pid; ?>" role="tab"><b>Statistics</b></a>
                <a class="col-12 my-1 col-lg-3 mx-2 my-lg-0 nav-link"
                    href="discussion.php?id=<?php echo $pid; ?>" role="tab"><b>Disscussion</b></a>
            </div>
        </nav>
        <?php if($No_Submission) { ?>
            <h2 class="text-center text-danger">No Submission Yet</h2>
        <?php } else{ ?>

            <div class="bg-light rounded pb-3 mb-5">
                <div class="row">
                    <div class="col-12 col-lg-6 text-center mt-5">
                        <h3> <span class="text-primary">Total submission:</span> <?php echo $Sub; ?></h3>
                        <h3> <span class="text-success"> Total accepted:</span> <?php echo $Acc; ?></h3>
                        <h3> <span class="text-primary">No. of users tried:</span> <?php echo $Try; ?></h3>
                        <h3> <span class="text-success"> No. of users succed:</span> <?php echo $Solve; ?></h3>
                    </div>
                    <div class="col-12 col-lg-6  text-center mt-5">
                        <?php include 'sol_comp.php'; ?>
                    </div>
                </div>
                <div class="px-lg-5">
                    <div id="chart_div"></div>
                </div>
                <?php if (mysqli_num_rows($my_sub) == 0) { ?>
                    <h2 class="text-center text-danger">You have no submission yet</h2>
                <?php } else { ?>
                    <div class="text-center">
                        <h3 class="text-dark mb-3 bg-light rounded-pill p-2"><b>My Submissions</b></h3>
                        <table class="table table-sm p-2">
                            <thead>
                                <tr class="text-muted">
                                    <td><b>Verdict</b></td>
                                    <td><b>Language</b></td>
                                    <td><b>Time</b></td>
                                    <td><b>Memory</b></td>
                                    <td><b>Source</b></td>
                                    <td><b>When</b></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($my_sub)) { ?>
                                    <tr>
                                    <?php
                                        $ver = $row['Verdict'];
                                        $ver_class = ''; 
                                        if (substr($ver, 0, 1) == 'C') {$ver_class = 'ver-ce';}
                                        else if (substr($ver, 0, 1) == 'R') {$ver_class = 'ver-re';}
                                        else if (substr($ver, 0, 1) == 'T') {$ver_class = 'ver-tle';}
                                        else if (substr($ver, 0, 1) == 'M') {$ver_class = 'ver-mle';}
                                        else if (substr($ver, 0, 1) == 'W') {$ver_class = 'ver-wa';}
                                        else if (substr($ver, 0, 1) == 'A') {$ver_class = 'ver-acc';}
                                    ?>
                                    <td>
                                        <a class="mysub_modal" href="javascript:void(0)" data-toggle="modal" data-target="#show_code" data-id=<?php echo $row['Sub_Id']; ?>>
                                            <span class="<?php echo $ver_class; ?>"><?php echo $ver; ?></span>
                                        </a>
                                    </td>
                                    <td><?php echo $row['Language']; ?></td>
                                    <td><?php echo sprintf('%0.2f', ($row['Time'])).' sec'; ?></td>
                                    <td><?php echo sprintf('%0.2f', ($row['Memory'] / 1024)).' MB'; ?></td>
                                    <td><?php echo sprintf('%0.2f', ($row['Source_Size'] / 1024)).' KB'; ?></td>
                                    <td><?php echo date('Y-m-d H:i:s', $row['Sub_Time']); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>

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
        <?php }
        include 'footer.php'; ?>
    </div>

    <script src="../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src = "https://www.gstatic.com/charts/loader.js"></script>
    <!-- <script src="../js/nav_bar.js" type="text/javascript"></script> -->
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            console.log('hello from chart');
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

        $(document).ready(function() {

            $(".code_modal").click(function() {
                x = $(this).attr('data-id');
                y = $(this).attr('data-tag');
                console.log(x, y);
                $.ajax({
                    url: "load_src.php",
                    method: "POST",
                    data: {
                        sub_id: x,
                        tag: y
                    },
                    success: function(response) {
                        $(".xyz").html(response);
                    }
                });
            });

            $(".mysub_modal").click(function() {
                x = $(this).attr('data-id');
                console.log(x)
                $.ajax({
                    url: "load_my_src.php",
                    method: "POST",
                    data: {
                        sub_id: x
                    },
                    success: function(response) {
                        $(".xyz").html(response);
                    }
                });
            });
        });
    </script>
</body>
</html>