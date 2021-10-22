<?php

include '../../connection.php';
include 'security.php';

if (!isset($_GET['id'])) {
    exit('<h1>No such pages found</h1>');
}
$id = $_GET['id'];
$auth = $_SESSION['Username'];
$qry_prb = "SELECT * FROM User_Problem WHERE Id = '{$id}';";
$res_prb = mysqli_query($con, $qry_prb) or exit('<h1>No such problems found</h1>');

while ($row = mysqli_fetch_assoc($res_prb)) {
    $id = $row['Id'];
    $tit = $row['Title'];
    $stat = $row['Statement'];
    $cons = $row['Constraints'];
    $ipf = $row['Input_Format'];
    $outf = $row['Output_Format'];
    $samp_tst = explode(' ', $row['Sample_Test']);
    $tcc = $row['TC_Contributor'];
    $dif = $row['Difficulty'];
    $tags = $row['Tags'];
    $note = $row['Notes'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Problem</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-9">
                <div class="my-3">
                    <h2><b> <?php echo $tit; ?> </b></h2>
                    Difficulty: <?php echo '&nbsp'.$dif.'<br>'; ?>
                    <?php if ($auth != $tcc) { 
                        $qry = "SELECT Username FROM User WHERE Username = '{$tcc}';";
                        $res = mysqli_query($con, $qry);
                        if (mysqli_num_rows($res) > 0) {
                            $tcc = '<a href="../../profile.php?user='.$tcc.'">'.$tcc.'</a>';
                        }
                    ?>

                        Testcase Contributor: <?php echo $tcc; ?>
                    <?php } ?>
                </div>
                <div class="fub">
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
                                <td><?php echo nl2br(file_get_contents('../../uploads/user/testcases/'.$id.'/input/'.$samp_tst[$i])); ?></td>
                                <td><?php echo nl2br(file_get_contents('../../uploads/user/testcases/'.$id.'/output/'.$samp_tst[$i])); ?></td>
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
            <div class="col-12 col-lg-3 mt-lg-5 text-center">
                <div class="p-3 my-3 rounded bg-primary"><a class="text-white font-weight-bold btn btn-lg" href="details.php?id=<?php echo $id; ?>">Edit</a></div>
                <div class="p-3 my-3 rounded bg-danger"><button class="text-white font-weight-bold btn btn-lg" data-toggle="modal" data-target="#dlt_tut">Delete</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" data-keyboard="false" data-backdrop="static" id="dlt_tut" tabindex="-1"
        role="dialog" aria-labelledby="upd_updinfoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content p-3">
                <div class="modal-body text-center">
                    Are you sure want to delete this tutorial?
                </div>
                <form class="row px-2 mt-2" ction="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                    <div class="col-6"><button class="btn btn-danger" type="submit" name="yes">Yes</button></div>
                    <div class="col-6 text-right"><button class="btn btn-success" data-dismiss="modal" aria-label="Close">No</button></div>
                </form>
            </div>
        </div>
    </div>

    <?php
        if (isset($_POST['yes'])) {
            $qry = "DELETE FROM Problem WHERE Id = {$tid};";
            mysqli_query($con, $qry);
            echo '<script>
                window.history.replaceState(null, null, "../");
                window.location.reload();
                alert("Problem deleted successfully!");
            </script>';
        }
    ?>

    <script src="../../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="../../js/nav_bar.js" type="text/javascript"></script>
</body>

</html>