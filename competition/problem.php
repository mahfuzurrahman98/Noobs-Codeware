<?php 

include '../connection.php'; 
include 'security.php';

$id = $_GET['id'];
if (!isset($_GET['id'])) {
    exit('No such pages found!');
}

$qry = "SELECT Title, Problems, Start_Time, Finish_Time FROM User_Contest WHERE Id = '{$id}';";
$res = mysqli_query($con, $qry);

while ($row = mysqli_fetch_assoc($res)) {
    $tit = $row['Title'];
    $tmp_arr = explode(' ', $row['Problems']);
    $beg_tym = $row['Start_Time'];
    $end_tym = $row['Finish_Time'];
}

if (mysqli_num_rows($res) == 0) {
    exit('No such contests found!');
}

include 'participant_validate.php';
$prb_cnt = 'A';
$prb_arr = [];
for ($i = 0; $i < count($tmp_arr); $i++) {
    $prb_arr[$prb_cnt] = $tmp_arr[$i];
    $prb_cnt++;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="style.css">
    <style>
        #editor {
            height: 600px;
            font-size: 16px;
        }
        .fub {
            font-family: Ubuntu;
        }
    </style>
</head>

<body>
    <div class="fub"><?php include 'nav_bar.php'; ?></div>
    <input type="hidden" id="beg_tym_id" value="<?php echo $beg_tym; ?>">
    <input type="hidden" id="end_tym_id" value="<?php echo $end_tym; ?>">
    <input type="hidden" id="contest_id" value="<?php echo $id; ?>">
    <input type="hidden" id="first_prb_id" value="<?php echo $prb_arr['A']; ?>">
    <div class="container-fluid">
        <div class="text-center fub">
            <h1 class="text-center text-dark mt-5"><?php echo $tit; ?></h1>
            <div id="status"></div>
            <div id="show_clock" class="h6"></div>
        </div>
        <nav class="my-5 prb_info_tab fub mx-3 mx-lg-5">
            <div class="row px-3 py-1 shadow-lg rounded text-center justify-content-center">
                <a class="col-12 col-lg-2 nav-link"
                    href="overview.php?id=<?php echo $id; ?>" role="tab"><b>Overview</b></a>
                <a class="col-12 col-lg-2 nav-link tab_active"
                    href="problem.php?id=<?php echo $id; ?>" role="tab"><b>Problems</b></a>
                <a class="col-12 col-lg-2 nav-link"
                    href="standing.php?id=<?php echo $id; ?>" role="tab"><b>Standing</b></a>
                <a class="col-12 col-lg-2 nav-link"
                    href="submission.php?id=<?php echo $id; ?>" role="tab"><b>Submission</b></a>
                <a class="col-12 col-lg-2 nav-link"
                    href="clarification.php?id=<?php echo $id; ?>" role="tab"><b>Clarification</b></a>
            </div>
        </nav>
        <div class="text-center rounded py-1 px-0 fub">
            <?php foreach ($prb_arr as $key => $value) { ?>
                <button class="prb_btn d-none" data-num="<?php echo $key; ?>" data-id="<?php echo $value; ?>">
                    <b><?php echo $key ?></b>
                </button>
            <?php } ?>
        </div>
        <div class="show_problem d-none"></div>
    </div>

    <script src="editor/ide.js"></script>
    <script src="editor/lib/ace.js"></script>
    <script src="editor/lib/ext-language_tools.js"></script>
    <script src="../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../js/bootstrap.bundle.js" type="text/javascript"></script>
    <!-- <script src="../js/nav_bar.js" type="text/javascript"></script> -->
    <script src="validate.js" type="text/javascript"></script>
</body>
</html>