<?php 

include '../../connection.php'; 
include 'security.php';

$cid = $_POST['cid'];
$pnum = $_POST['pnum'];
$pid = $_POST['pid'];

$qry_prb = "SELECT * FROM User_Problem WHERE Id = '{$pid}';";
$res_prb = mysqli_query($con, $qry_prb) or exit('No such problem found!');

if (mysqli_num_rows($res_prb) == 0) {
    exit('No such problem found!');
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
</div>
<div class="row">
    <div id="desc" class="col-12 mx-0">
        <div class="shadow shadow-lg p-3 bg-light mb-4 prb_br">
            <h5><b>Statement</b></h5>
            <?php echo nl2br($stat); ?>
        </div>
        <div class="shadow shadow-lg p-3 bg-light mb-4 prb_br">
            <h5><b>Constraints</b></h5>
            <?php echo nl2br($cons); ?>
        </div>
        <div class="shadow shadow-lg p-3 bg-light mb-4 prb_br">
            <h5><b>Input Format</b></h5>
            <?php echo nl2br($ipf); ?>
        </div>
        <div class="shadow shadow-lg p-3 bg-light mb-4 prb_br">
            <h5><b>Output Format</b></h5>
            <?php echo nl2br($outf); ?>
        </div>
        <div class="shadow shadow-lg p-3 bg-light mb-4 prb_br">
            <h5><b>Sample Testcase</b></h5>
            <?php for ($i = 0; $i <count($samp_tst) ; $i++) { ?>
            <table class="table table-bordered border-dark">
                <thead>
                    <tr>
                        <td>Sample Input <?php echo $i; ?> </td>
                        <td>Sample Output <?php echo $i; ?> </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo nl2br(file_get_contents('../../uploads/user/testcases/'.$pid.'/input/'.$samp_tst[$i])); ?></td>
                        <td><?php echo nl2br(file_get_contents('../../uploads/user/testcases/'.$pid.'/output/'.$samp_tst[$i])); ?></td>
                    </tr>
                </tbody>
            </table>
            <?php } ?>
        </div>

    <?php
    if (!empty($note)) {
        echo '<div class="shadow p-3 bg-light mb-4 prb_br">';
        echo '<h5><b>Notes</b></h5>' . $note;
        echo '</div>';
    }
    ?>
    <div class="mb-5">
        <span class=""><b>Problem Tags:</b></span>
        <?php
            $tags = explode(' ', $tags); 
            foreach ($tags as $tg) {
                echo '<span class="mx-1 text-success shadow shadow-lg p-1 bg-light rounded">'.$tg.'</span>';
            }
        ?>
    </div>

    </div>
</div>