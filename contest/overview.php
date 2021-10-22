<?php

include '../connection.php';
include 'security.php';

if (!isset($_GET['id'])) {
    exit('<h1>No such pages found</h1>');
}

$id = $_GET['id'];
$qry = "SELECT Title, Description, Rules, Problems, Start_Time, Finish_Time, Author FROM Contest WHERE Id = '{$id}';";
$res = mysqli_query($con, $qry);
while ($row = mysqli_fetch_assoc($res)) {
    $tit = $row['Title'];
    $author = explode('/', substr(substr($row['Author'], 1), 0, -1));
    $probs = explode(' ', $row['Problems']);
    $desc = $row['Description'];
    $rule = $row['Rules'];
    $beg_tym = $row['Start_Time'];
    $end_tym = $row['Finish_Time'];
}
if (mysqli_num_rows($res) == 0) {
    exit('<h1>No such contests found</h1>');
}
$prb_num = 'A';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tit; ?></title>
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
                <a class="col-12 col-lg-2 nav-link tab_active"
                    href="overview.php?id=<?php echo $id; ?>" role="tab"><b>Overview</b></a>
                <a class="col-12 col-lg-2 nav-link"
                    href="problem.php?id=<?php echo $id; ?>" role="tab"><b>Problems</b></a>
                <a class="col-12 col-lg-2 nav-link"
                    href="standing.php?id=<?php echo $id; ?>" role="tab"><b>Standing</b></a>
                <a class="col-12 col-lg-2 nav-link"
                    href="submission.php?id=<?php echo $id; ?>" role="tab"><b>Submission</b></a>
                <a class="col-12 col-lg-2 nav-link"
                    href="clarification.php?id=<?php echo $id; ?>" role="tab"><b>Clarification</b></a>
            </div>
        </nav>
        <div class="my-5">
            <h4>Description</h4>
            <?php echo $desc; ?>
        </div>
        <div class="my-5">
            <h4>Rules</h4>
            <?php echo $rule; ?>
        </div>
        <div class="my-5">
            <h4>Judges</h4>
            <?php
            foreach ($author as $auth) {
                $auth = trim($auth);
                $qry = "SELECT Username FROM User WHERE Username = '{$auth}';";
                $res = mysqli_query($con, $qry);
                if (mysqli_num_rows($res) > 0) {
                    $auth = '<a href="../profile.php?user='.$auth.'">'.$auth.'</a>';
                }
                echo $auth.' ';
            }
            ?>
        </div>

        <table class="table table-light mb-5">
            <tbody>
                <?php foreach ($probs as $prb) {
                    $qry = "SELECT Title FROM Problem WHERE Id = '{$prb}';";
                    $res = mysqli_query($con, $qry);
                    $prb_tit = mysqli_fetch_assoc($res)['Title'];

                    $qry = "SELECT DISTINCT Username FROM Contest_Submission WHERE Contest_Id = '{$id}' AND Problem = '{$prb_num}' AND Verdict = 'Accepted';";
                    $res = mysqli_query($con, $qry);
                    $solved = mysqli_num_rows($res);

                    $qry = "SELECT DISTINCT Username FROM Contest_Submission WHERE Contest_Id = '{$id}' AND Problem = '{$prb_num}';";
                    $res = mysqli_query($con, $qry);
                    $tried = mysqli_num_rows($res);
                ?>
                <tr>
                    <td class="h3"><?php echo $prb_num.'. '.$prb_tit; ?></td>
                    <td><i class="far fa-user"></i> <?php echo '('.$solved.' / '.$tried.')'; ?></td>
                </tr>
                <?php
                    $prb_num++; 
                } ?>
            </tbody>
        </table>
        <?php include '../footer.php'; ?>
    </div>

    <script src="../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="../js/contest_validate.js" type="text/javascript"></script>
</body>

</html>