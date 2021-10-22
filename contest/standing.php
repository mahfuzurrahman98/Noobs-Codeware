<?php 

include '../connection.php'; 
include 'security.php';

if (!isset($_GET['id'])) {
    exit('<h1>No such pages found</h1>');
}

$flag = FALSE;
$id = $_GET['id'];
$qry = "SELECT Title, Problems, Scores, Start_Time, Freeze_Time, Finish_Time FROM Contest WHERE Id = '{$id}';";
$res = mysqli_query($con, $qry);

while ($row = mysqli_fetch_assoc($res)) {
    $tit = $row['Title'];
    $tmp_prb_arr = explode(' ', $row['Problems']);
    $tmp_scr_arr = explode(' ', $row['Scores']);
    $beg_tym = $row['Start_Time'];
    $end_tym = $row['Finish_Time'];
    $frz_tym = $row['Freeze_Time'];
}
//echo $beg_tym.'<br>';

if (mysqli_num_rows($res) == 0) {
    exit('<h1>No such contests found</h1>');
}

$prb_cnt = 'A';
$prb_arr = [];
$scr_arr = [];
for ($i = 0; $i < count($tmp_prb_arr); $i++) {
    $prb_arr[$prb_cnt] = $tmp_prb_arr[$i];
    $scr_arr[$prb_cnt] = intval($tmp_scr_arr[$i]);
    $prb_cnt++;
}

$cur_ts = date("Y-m-d H:i:s", time());
$qry = "SELECT Username, Problem, Verdict, TIMESTAMPDIFF(SECOND, Start_Time, Sub_Time) AS subtym FROM Contest JOIN Contest_Submission WHERE Id = Contest_Id AND Contest_Id = '{$id}' AND Verdict != 'Compilation Error'";

if ($cur_ts < $frz_tym) { //before freeze
    $qry .= " ORDER BY Sub_Time ASC;";
}
else if ($cur_ts >= $frz_tym) { //on freeze
    $qry .= " AND Sub_Time < Freeze_Time ORDER BY Sub_Time ASC;";
}
else if ($cur_ts > $end_tym) { //after contest
    $qry .= " ORDER BY Sub_Time ASC;";
}
//echo $qry;
$res = mysqli_query($con, $qry);

if (mysqli_num_rows($res) > 0) {
    $arr = [];
    while ($row = mysqli_fetch_assoc($res)) {
        //echo $row['Username'].', ';
        $arr[] = $row;
    }
    //echo 'arr_size: '.count($arr);
    //echo 'Username: '.$arr['Username'];
    include 'rank_generator.php';
    $flag = TRUE;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status-Codeware</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include 'nav_bar.php'; ?>
    <input type="hidden" id="beg_tym_id" value="<?php echo $beg_tym; ?>">
    <input type="hidden" id="end_tym_id" value="<?php echo $end_tym; ?>">
    <div class="container-fluid">
        <div class="text-center">
            <h1 class="text-center text-dark mt-5"><?php echo $tit; ?></h1>
            <div id="status"></div>
            <div id="show_clock" class="h6"></div>
        </div>
        <nav class="my-5 prb_info_tab fub mx-3 mx-lg-5">
            <div class="row px-3 py-1 shadow shadow-lg bg-light rounded text-center justify-content-center">
                <a class="col-12 col-lg-2 nav-link"
                    href="overview.php?id=<?php echo $id; ?>" role="tab"><b>Overview</b></a>
                <a class="col-12 col-lg-2 nav-link"
                    href="problem.php?id=<?php echo $id; ?>" role="tab"><b>Problems</b></a>
                <a class="col-12 col-lg-2 nav-link tab_active"
                    href="standing.php?id=<?php echo $id; ?>" role="tab"><b>Standing</b></a>
                <a class="col-12 col-lg-2 nav-link"
                    href="submission.php?id=<?php echo $id; ?>" role="tab"><b>Submission</b></a>
                <a class="col-12 col-lg-2 nav-link"
                    href="clarification.php?id=<?php echo $id; ?>" role="tab"><b>Clarification</b></a>
            </div>
        </nav>

        
        <table class="table table-sm table-hover table-striped p-2 mb-5 text-center">
            <thead>
                <tr>
                    <td><b><div class="text-left">Rank</div></b></td>
                    <td><b><div class="text-left">User</div></b></td>
                    <td><b><div class="text-left">Score</div></b></td>
                    <td><b><div class="text-left">Penalty</div></b></td>
                    <?php foreach ($prb_arr as $prob => $value) { ?>
                        <td>
                            <b><?php echo $prob; ?></b>
                        </td>
                    <?php } ?>
                </tr>
            </thead>
            <?php if ($flag) { ?>
            <tbody>
                <?php
                $rank_cnt = 1;
                foreach ($Contestant as $user) {
                ?>
                    <tr>
                        <td><?php echo '<div class="text-left">'.$rank_cnt.'</div>'; ?></td>
                        <td><?php echo '<div class="text-left">'.$user.'</div>'; ?></td>
                        <td><?php echo '<div class="text-left">'.$total_scored[$user].'</div>'; ?></td>
                        <td>
                            <?php
                            $rank_cnt++;
                            $utp = intval($total_penalty[$user] / 60) + ($total_penalty[$user] / 60 > 0);
                            echo '<div class="text-left">'.$utp.'</div>';
                            ?>
                        </td>
                        <?php foreach ($prb_arr as $prob => $value) { ?>
                            <td>
                                <?php
                                if (isset($Accepted[$user.','.$prob])) {
                                    $aup = intval($Accepted[$user.','.$prob] / 60) + ($Accepted[$user.','.$prob] / 60 > 0);
                                    echo '<div class="bg-success rounded text-white p-2">';
                                        echo (-1) * $Rejected[$user.','.$prob].', '.$aup;
                                        if ($first_solver[$prob] == $user) {
                                            echo ' <b><i class="fas fa-check"></i></b>';
                                        }
                                    echo '</div>';
                                }
                                else if (isset($Rejected[$user.','.$prob])) {
                                    $rup = intval($Rejected[$user.','.$prob] / 60) + ($Rejected[$user.','.$prob] / 60 > 0);
                                    echo '<div class="bg-danger rounded text-white p-2">';
                                        echo (-1) * $rup;
                                    echo '</div>';
                                }
                                ?>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
        </table>
    
        <?php include '../footer.php'; ?>
    </div>

    <script src="../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="../js/contest_validate.js" type="text/javascript"></script>
</body>

</html>