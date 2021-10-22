<?php 

include '../connection.php';
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    exit('<h1>Invalid page requcest</h1>');
}
include 'security.php';
$cid = $_POST['cid'];
$pnum = $_POST['pnum'];
$pid = $_POST['pid'];
$qry_prb = "SELECT * FROM Problem WHERE Id = '{$pid}';";
$res_prb = mysqli_query($con, $qry_prb) or exit('<h1>No such problems found</h1>');

if (mysqli_num_rows($res_prb) == 0) {
    exit('<h1>No such problems found</h1>');
}

while ($row = mysqli_fetch_assoc($res_prb)) {
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

?>
<title><?php echo $pnum.'. '.$tit; ?></title>
<div class="row mb-3 fub">
    <div class="col-8">
        <h2><b> <?php echo $pnum.'. '.$tit; ?> </b></h2>        
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
    <div id="ide_toggle" class="d-none">
        <button class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Code, Run & Submit" onclick="showHideIde()"><b><i class="fas fa-terminal"></i></b>Toggle IDE</button>
    </div>
</div>
<div class="row mb-5">
    <div id="desc" class="col-12 mx-0 fub">
        <?php include 'description.php' ?>
    </div>
    <div id="ide" class="mx-0" style="display: none;">
        <?php include 'code_editor.php' ?>
    </div>
</div>