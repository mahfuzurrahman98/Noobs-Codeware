<?php

include '../../connection.php';
include 'security.php';

$id = $_GET['id'];

$qry = "SELECT Title, Description, Problems, Start_Time, Finish_Time FROM Contest WHERE Id = '{$id}';";
$res = mysqli_query($con, $qry);
while ($row = mysqli_fetch_assoc($res)) {
    $tit = $row['Title'];
    $probs = explode(' ', $row['Problems']);
    $desc = $row['Description'];
    $beg_tym = $row['Start_Time'];
    $end_tym = $row['Finish_Time'];
}
$prb_num = 'A';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tit; ?></title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/sidebar.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <input type="hidden" id="beg_tym_id" value="<?php echo $beg_tym; ?>">
    <input type="hidden" id="end_tym_id" value="<?php echo $end_tym; ?>">
    <div class="container-fluid">
        <div class="text-center">
            <h1 class="text-center text-dark mt-5"><?php echo $tit; ?></h1>
            <div id="status"></div>
            <div id="show_clock" class="h6"></div>
        </div>
        <nav class="my-5 prb_info_tab fub mx-3 mx-lg-5">
            <div class="row px-3 py-1 shadow-lg rounded text-center justify-content-center">
                <a class="col-12 col-lg-2 nav-link tab_active"
                    href="overview.php?id=<?php echo $id; ?>" role="tab"><b>Overview</b></a>
                <a class="col-12 col-lg-2 nav-link"
                    href="standing.php?id=<?php echo $id; ?>" role="tab"><b>Standing</b></a>
                <a class="col-12 col-lg-2 nav-link"
                    href="submission.php?id=<?php echo $id; ?>" role="tab"><b>Submissions</b></a>
                <a class="col-12 col-lg-2 nav-link"
                    href="clarification.php?id=<?php echo $id; ?>" role="tab"><b>Clarification</b></a>
            </div>
        </nav>
        <div class="my-5">
            <?php echo $desc; ?>
        </div>

        <table class="table table-light ">
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
                    <td class="h3"><?php echo $prb_num.'. '?><a class="show_prb" href="javascript:void(0)" data-toggle="modal" data-target="#show_prb_modal" data-num="<?php echo $prb_num; ?>" data-id="<?php echo $prb; ?>" data-tit="<?php echo $prb_tit; ?>"><?php echo $prb_tit; ?></a></td>
                    <td><i class="far fa-user"></i> <?php echo '('.$solved.' / '.$tried.')'; ?></td>
                </tr>
                <?php
                    $prb_num++; 
                } ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" data-backdrop="static" id="show_prb_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title font-weight-bold"></h2>
                    <button type="button" class="text-dark btn btn-sm" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body ijk">
                </div>
            </div>
        </div>
    </div>

    <script src="../../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="validate.js" type="text/javascript"></script>
    <!-- <script src="../js/nav_bar.js" type="text/javascript"></script> -->

    <script>
        $(document).ready(function() {

            $(".show_prb").click(function() {
                console.log('clickedddd')
                x = $(this).attr('data-num');
                y = $(this).attr('data-id');
                z = $(this).attr('data-tit');
                console.log('prb_num: ', x, '\nprb_id: ', y);

                $('.modal-title').html(x+'. '+z);
                $.ajax({
                    url: "load_problem.php",
                    method: "POST",
                    data: {
                        cid: "<?php echo $id; ?>",
                        pnum: x,
                        pid: y
                    },
                    success: function(response) {
                        $(".ijk").html(response);
                    }
                });
            });
        });
    </script>
</body>

</html>