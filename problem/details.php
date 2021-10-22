<?php 

include '../connection.php'; 
include 'security.php';

if (!isset($_GET['id'])) {
    exit('No such pages found');
}

$pid = $_GET['id'];
$unm = $_SESSION['Username'];
$qry_prb = "SELECT * FROM Problem WHERE Id = '{$pid}';";
$res_prb = mysqli_query($con, $qry_prb) or exit('No such problems found');

if (mysqli_num_rows($res_prb) == 0) {
    exit('No such problem found!');
}

$qry_todo = "SELECT * FROM Todo WHERE (Problem_Id = '{$pid}' AND _user = '{$unm}');";
$res_todo = mysqli_query($con, $qry_todo) or die("Todo Selection Query Failed!");

while ($row = mysqli_fetch_assoc($res_prb)) {
    $id = $row['Id'];
    $tit = $row['Title'];
    $stat = $row['Statement'];
    $cons = $row['Constraints'];
    $ipf = $row['Input_Format'];
    $outf = $row['Output_Format'];
    $samp_tst = explode(' ', $row['Sample_Test']);
    $auth = $row['Author'];
    $tcc = $row['TC_Contributor'];
    $dif = $row['Difficulty'];
    $tags = $row['Tags'];
    $note = $row['Notes'];
}

$qry_sub = "SELECT Sub_Id FROM Submission WHERE Problem_Title = '{$tit}' AND Verdict = 'Accepted';";
$res_sub = mysqli_query($con, $qry_sub) or die("Submission Selection Query Failed!");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tit; ?></title>
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
    <input type="hidden" id="prb_id" value="<?php echo $pid; ?>">
    <input type="hidden" id="prb_tit" value="<?php echo $tit; ?>">
    <div class="container-fluid">
        <nav class="mx-5 prb_info_tab fub">
            <div class="row p-2 shadow shadow shadow-lg bg-light rounded text-center justify-content-center mt-5 mb-5">
                <a class="col-12 my-1 col-lg-3 mx-2 my-lg-0 nav-link tab_active"
                    href="details.php?id=<?php echo $pid; ?>" role="tab"><b>Details</b></a>
                <a class="col-12 my-1 col-lg-3 mx-2 my-lg-0 nav-link"
                    href="statistics.php?id=<?php echo $pid; ?>" role="tab"><b>Statistics</b></a>
                <a class="col-12 my-1 col-lg-3 mx-2 my-lg-0 nav-link"
                    href="discussion.php?id=<?php echo $pid; ?>" role="tab"><b>Disscussion</b></a>
            </div>
        </nav>
        <div class="row mb-3 fub">
            <div class="col-10">
                <h2><b> <?php echo $tit; ?> </b></h2>
                Difficulty: <?php echo '&nbsp'.$dif.'<br>'; ?>
                
                <?php
                    $qry_auth = "SELECT Name FROM User WHERE Username = '{$auth}';";
                    $res_auth = mysqli_query($con, $qry_auth) or die("Author Selection Query Failed!");
                    $qry_tc = "SELECT Name FROM User WHERE Username = '{$tcc}';";
                    $res_tc = mysqli_query($con, $qry_tc) or die("TC Selection Query Failed!");
                    if (mysqli_num_rows($res_auth) == 1) {
                        $auth = '<a href="../profile.php?user='.$auth.'">'.$auth.'</a>';
                    }
                    if (mysqli_num_rows($res_tc) == 1) {
                        $tcc = '<a href="../profile.php?user='.$tcc.'">'.$tcc.'</a>';
                    }
                ?>

                Problem Author: <?php echo '&nbsp'.$auth; ?><br>Testcase Contributor: <?php echo $tcc; ?>
            </div>
            <div class="col-2 row text-right">
                <div class="col-12 col-lg-6">
                    <?php if (mysqli_num_rows($res_todo) == 0 AND mysqli_num_rows($res_sub) == 0) { ?>
                    <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                        <button type="submit" name="addtodo" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Solve Later"><b><i class="fas fa-list-ul">&nbsp</i></b></button>
                    </form>
                    <?php } else { 
                        if (mysqli_num_rows($res_sub) > 0) {
                            $todo_btn_tit = 'Already Solved';
                        }
                        else if (mysqli_num_rows($res_todo) > 0) {
                            $todo_btn_tit = 'Already Added';
                        }
                    ?>
                        <button class="btn btn-secondary" disabled data-toggle="tooltip" data-placement="top" title="<?php echo $todo_btn_tit; ?>"><b><i class="fas fa-list-ul">&nbsp</i></b></button>
                    <?php } ?>
                </div>
                <div class="col-12 col-lg-6">
                    <button class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Toggle Code Editor" onclick="showHideIde()"><b><i class="fas fa-terminal"></i></b></button>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="desc" class="col-12 mx-0 fub">
                <?php include 'description.php' ?>
            </div>
            <div id="ide" class="mx-0" style="display: none;">
                <?php include 'code_editor.php' ?>
            </div>
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
        <?php
        if (isset($_POST['addtodo'])) {
            $qry = "INSERT INTO Todo(_user, Problem_Id, Problem_Title, Added_Time) VALUES('{$unm}', '{$pid}', '{$tit}', CURRENT_TIME());";
            $res = mysqli_query($con, $qry);
            echo '<script>
                window.history.replaceState(null, null, "../todo.php");
                window.location.reload();
            </script>';
        }
        ?>
        <div class="fub">
            <?php include 'footer.php'; ?>
        </div>
    </div>
    <script src="../js/problem_ide.js"></script>
    <script src="../ace/ace.js"></script>
    <script src="../ace/ext-language_tools.js"></script>
    <script src="../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../js/bootstrap.bundle.js" type="text/javascript"></script>

</body>
</html>