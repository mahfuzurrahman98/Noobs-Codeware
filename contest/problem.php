<?php 

include '../connection.php'; 
include 'security.php';

$id = $_GET['id'];
if (!isset($_GET['id'])) {
    exit('No such pages found!');
}

$qry = "SELECT Title, Problems, Start_Time, Finish_Time FROM Contest WHERE Id = '{$id}';";
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
</head>

<body>
    <?php include 'nav_bar.php'; ?>
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
            <div class="row px-3 py-1 shadow shadow-lg bg-light rounded text-center justify-content-center">
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
        <?php include '../footer.php'; ?>
    </div>
    <div class="fub modal fade" id="setting" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Settings</b></h5>
                    <button type="button" class="btn btn-sm" data-dismiss="modal" >
                    <b class="h5"><i class="fas fa-times"></i></b>
                    </button>
                </div>
                <div class="modal-body xyz" style="border-radius: 10px;">
                    <div class="form-group form-inline">
                        <label><b>Font Size:</b></label>
                        <select class="form-control form-control-sm ml-auto" id="fnt" onchange="changeFont()">
                            <?php for ($i = 12; $i <= 36 ; $i += 2) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?>px</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group form-inline">
                        <label><b>Editor Theme:</b></label>
                        <select class="form-control form-control-sm ml-auto" id="thm" onchange="changeTheme()">
                            <optgroup label="Light">
                                <option value="xcode">Xcode</option>
                                <option value="textmate">Textmate</option>
                                <option value="kuroir">Kuroir</option>
                                <option value="crimson_editor">Crimson</option>
                                <option value="solarized_light">Solarized</option>
                            </optgroup>
                            <optgroup label="Dark">
                                <option selected value="monokai">Monokai</option>
                                <option value="gob">Gob</option>
                                <option value="cobalt">Cobalt</option>
                                <option value="merbivore_soft">Merbivore Soft</option>
                                <option value="gruvbox">Gruvbox</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group form-inline">
                        <label><b>Tab Width:</b></label>
                        <select class="form-control form-control-sm ml-auto" id="tab" onchange="changeTab()">
                            <option value="2">2 spaces</option>
                            <option value="4" selected>4 spaces</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/contest_ide.js"></script>
    <script src="../ace/ace.js"></script>
    <script src="../ace/ext-language_tools.js"></script>
    <script src="../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="../js/contest_validate.js" type="text/javascript"></script>
</body>
</html>