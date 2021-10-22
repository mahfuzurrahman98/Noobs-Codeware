<?php 

include '../connection.php'; 
include 'security.php';

$pid = $_GET['id'];

function highlightText($text) {
    $text = trim($text);
    $text = highlight_string("<?php " . $text, true);  // highlight_string() requires opening PHP tag or otherwise it will not colorize the text
    $text = trim($text);
    $text = preg_replace("|^\\<code\\>\\<span style\\=\"color\\: #[a-fA-F0-9]{0,6}\"\\>|", "", $text, 1);  // remove prefix
    $text = preg_replace("|\\</code\\>\$|", "", $text, 1);  // remove suffix 1
    $text = trim($text);  // remove line breaks
    $text = preg_replace("|\\</span\\>\$|", "", $text, 1);  // remove suffix 2
    $text = trim($text);  // remove line breaks
    $text = preg_replace("|^(\\<span style\\=\"color\\: #[a-fA-F0-9]{0,6}\"\\>)(&lt;\\?php&nbsp;)(.*?)(\\</span\\>)|", "\$1\$3\$4", $text);  // remove custom added "<?php "

    return $text;
}


$qry_prb = "SELECT * FROM User_Problem WHERE Id = '{$pid}' AND Requested = 'Yes' AND Approved = 'No';";
$res_prb = mysqli_query($con, $qry_prb) or exit('No such problems found!');

if (mysqli_num_rows($res_prb) == 0) {
    exit('No such problems found!');
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
    $jud_sol_lang = $row['Judges_Sol_Lang'];
    $jud_sol = $row['Judges_Solution'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/select2.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="container-fluid">
        <h2 class="mt-5"><b><?php echo $tit.'<br>'; ?></b></h2>
        <div class="row mb-3">
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
            <div class="col-4 text-right">
                <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                    <button type="submit" name="app" class="btn btn-success my-1">Approve</button>
                    <button type="submit" name="rmv" class="btn btn-danger">Decline</button>
                </form>
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
                                <td><?php echo nl2br(file_get_contents('../uploads/admin/testcases/'.$pid.'/input/'.$samp_tst[$i])); ?></td>
                                <td><?php echo nl2br(file_get_contents('../uploads/admin/testcases/'.$pid.'/output/'.$samp_tst[$i])); ?></td>
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

        <div class="row mb-5">
            <div class="col-12 col-lg-5 mb-3">
                <div class="bg-light p-3">
                    <?php
                    $inps = scandir('../uploads/admin/testcases/'.$pid.'/input');
                    $outs = scandir('../uploads/admin/testcases/'.$pid.'/output');
                    ?>

                    <table class="table table-sm rounded">
                        <tbody>
                            <?php for ($i = 2; $i < count($inps); $i++) { ?>
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-sm btn-secondary showbtn" data-toggle="modal" data-target="#showtest" sno="<?php echo $i - 2; ?>" data-id="<?php echo $inps[$i]; ?>"><b>Testcase <?php echo $i - 2; ?></b></button>  
                                </td>
                                <td>
                                    <?php if (in_array($inps[$i], $samp_tst)) {echo 'Added as sample';} ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-lg-7">
                <div class="bg-light mx-lg-3 p-3">
                    <h5>Judge Solution (<?php echo $jud_sol_lang; ?>)</h5>
                    <?php echo highlightText($jud_sol); ?>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" data-backdrop="static" id="showtest" tabindex="-1" role="dialog" aria-labelledby="addtestLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body xyz">
            
                </div>
            </div>
        </div>
    </div>

    <?php

    if (isset($_POST['app'])) {
        $qry = "INSERT INTO Problem(Id, Title, Difficulty, Tags, Statement, Constraints, Input_Format, Output_Format, Sample_Test, Notes, Author, TC_Contributor, Judges_Sol_Lang, Judges_Solution)SELECT Id, Title, Difficulty, Tags, Statement, Constraints, Input_Format, Output_Format, Sample_Test, Notes, Author, TC_Contributor, Judges_Sol_Lang, Judges_Solution FROM User_Problem WHERE Id = '{$pid}';";
        echo $qry;
        mysqli_query($con, $qry);

        $qry = "UPDATE Problem SET Archive = 'show' WHERE Id = '{$pid}';";
        mysqli_query($con, $qry);

        $qry = "UPDATE User_Problem SET Requested = 'Yes', Approved = 'Yes' WHERE Id = '{$pid}';";
        mysqli_query($con, $qry);

        $qry = "INSERT INTO Problem_Statistics(P_Id) VALUES('{$pid}');";
        mysqli_query($con, $qry);

        shell_exec('cp -r ../uploads/user/testcases/'.$pid.' ../uploads/admin/testcases');
        echo '<script>
            window.history.replaceState(null, null, "index.php?id=p");
            window.location.reload();
        </script>';
    }

    if (isset($_POST['rmv'])) {
        $qry = "UPDATE User_Problem SET Requested = 'No', Approved = 'No' WHERE Id = {$pid};";
        mysqli_query($con, $qry);
        echo '<script>
            window.history.replaceState(null, null, "index.php?id=p");
            window.location.reload();
        </script>';
    }

    ?>

    <script src="../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="../js/sidebar.js" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $(".showbtn").click(function() {
                x = $(this).attr('data-id');
                console.log('tcid: ', x);
                y = $(this).attr('sno');

                $.ajax({
                    url: "show_testcase.php",
                    method: "POST",
                    data: {
                        pid: "<?php echo $pid; ?>",
                        sno: y,
                        tcid : x
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