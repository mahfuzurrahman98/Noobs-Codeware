<?php

include '../../connection.php';
include 'security.php';

$id = $_GET['id'];
$qry = "SELECT * From Contest WHERE Id = '{$id}';";
$res = mysqli_query($con, $qry) or die('Errorrrrr');

while($row = mysqli_fetch_assoc($res)) {
    $tit = $row['Title'];
    $beg_tym = gmdate('Y-m-d\TH:i:s', strtotime($row['Start_Time']));
    $end_tym = gmdate('Y-m-d\TH:i:s', strtotime($row['Finish_Time']));
    $tmp_arr = explode(' ', $row['Problems']);
    $author = $row['Author'];
}

$prb_cnt = 'A';
$prb_arr = [];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/sidebar.css">
</head>

<body>
    <?php include 'sidebar.php';?>
    <input type="hidden" id="beg_tym_id" value="<?php echo $beg_tym; ?>">
    <input type="hidden" id="end_tym_id" value="<?php echo $end_tym; ?>">
    <input type="hidden" id="contest_id" value="<?php echo $id; ?>">
    <div class="container-fluid">
        <div class="text-center">
            <h1 class="text-center text-dark mt-5"><?php echo $tit; ?></h1>
            <div id="status"></div>
            <div id="show_clock" class="h6"></div>
        </div>
        <nav class="my-5 prb_info_tab fub mx-3 mx-lg-5">
            <div class="row px-3 py-1 shadow-lg rounded text-center justify-content-center">
                <a class="col-12 col-lg-2 nav-link"
                    href="overview.php?id=<?php echo $id; ?>" role="tab"><b>Overview</b></a>
                <a class="col-12 col-lg-2 nav-link"
                    href="standing.php?id=<?php echo $id; ?>" role="tab"><b>Standing</b></a>
                <a class="col-12 col-lg-2 nav-link"
                    href="submission.php?id=<?php echo $id; ?>" role="tab"><b>Submission</b></a>
                <a class="col-12 col-lg-2 nav-link tab_active"
                    href="clarification.php?id=<?php echo $id; ?>" role="tab"><b>Clarification</b></a>
            </div>
        </nav>
        <div id="status"></div>
        <div class="show_clock"></div>

        <div class="mx-lg-5 mb-5">
            <table class="table table-success table-hover rounded" style="cursor: pointer; cursor: hand;">
                <tbody>
                <?php
                $qry = "SELECT Cmnt_Id, Ques FROM Clarifi_Comment WHERE Contest_Id = '{$id}' AND _user = 'judge' ORDER BY Added_On ASC;";
                $res = mysqli_query($con, $qry);
                while ($row = mysqli_fetch_assoc($res)) {
                    $Cmnt_Id = $row['Cmnt_Id'];
                    $Ques = $row['Ques']; ?>

                    <tr>
                    <td class="h4 show_ann_modal" data-toggle="modal" data-target="#ann_modal" data-id="<?php echo $Cmnt_Id; ?>">
                        <span><?php echo substr($Ques, 0, 70); ?></span>
                    </td>
                    </tr>

                <?php }  ?>
                </tbody>
            </table>
        </div>

        <div class="clar_section">
            <div class="row">
                <div class="col-12 col-lg-3 text-center">
                    <h2>Filter Clarifications</h2>
                    <div class="my-3">
                        <div class="form-group mx-5 mx-lg-0">
                            <select id="search_prb" class="form-control">
                                <option value="%">All</option>
                                <?php for ($i = 0; $i < count($tmp_arr); $i++) { ?>
                                <option value="<?php echo $prb_cnt; ?>"><?php echo $prb_cnt; ?></option>
                                <?php
                                    $prb_cnt++;
                                }
                                ?>
                            </select>
                        </div>
                        <button class="btn btn-secondary" onclick="loadData()">Apply</button>
                    </div>
                </div>
                <div class="col-12 col-lg-9"> 
                    <div class="load_clar"></div>
                </div>
            </div>
            <div class="text-right mr-3 my-3">
                <button class="btn btn-primary rounded-pill" data-toggle="modal" data-target="#general_clarifi"><b>Post an announcement</b></button>
            </div>
        </div>
        
    </div>


    <div class="modal fade" data-backdrop="static" id="general_clarifi" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Post a general announcement</h5>
                    <button type="button" class="text-dark btn btn-sm" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                        <div class="form-group text-success h5">
                            <textarea name="announce" class="form-control" rows="10" required=""></textarea>
                        </div>
                        <button type="submit" class="btn btn-success" name="general_announce_submit"><b>Post</b></button>
                    </form>
                </div>  
            </div>
        </div>
    </div>
    <div class="modal fade" data-backdrop="static" id="sfc" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Clarification asked</h5>
                    <button type="button" class="text-dark btn btn-sm" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body xyz">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" data-backdrop="static" id="ann_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Announcement</h5>
                    <button type="button" class="text-dark btn btn-sm" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body ijk">
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST['general_announce_submit'])) {
        $announce = mysqli_real_escape_string($con, $_POST['announce']);
        $qry = "INSERT INTO Clarifi_Comment(Contest_Id, Ques) VALUES('{$id}', '{$announce}');";
        mysqli_query($con, $qry);
        echo '<script>
            window.history.replaceState(null, null, window.location.href);
            window.location.reload();
        </script>';
    }
    ?>
    <script src="../../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../../js/bootstrap.bundle.js" type="text/javascript"></script>
    <!-- <script src="../js/nav_bar.js" type="text/javascript"></script> -->
    <script src="validate.js" type="text/javascript"></script>
    <script>
        var p_id = '%';
        function loadData() {
            p_id = $("#search_prb").val();
            $.ajax({
                url: "load_clarifi.php",
                method: "POST",
                data: {
                    problem: p_id,
                    contest: "<?php echo $id; ?>"
                },
                success: function(response) {
                    console.log('len: ' + response.length);
                    $('.load_clar').html(response)
                }
            });
        }
        $(document).ready(function() {
            loadData();
            $(".show_ann_modal").click(function() {
                console.log('clickedddd')
                x = $(this).attr('data-id');
                console.log('clar_id: ', x);

                $.ajax({
                    url: "show_ann.php",
                    method: "POST",
                    data: {
                        ann_id: x
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