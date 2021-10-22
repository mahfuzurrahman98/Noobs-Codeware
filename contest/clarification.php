<?php 

include '../connection.php'; 
include 'security.php';

if (!isset($_GET['id'])) {
    exit('<h1>No such pages found</h1>');
}

$id = $_GET['id'];
$qry = "SELECT Title, Problems, Start_Time, Finish_Time FROM Contest WHERE Id = '{$id}';";
$res = mysqli_query($con, $qry);

while ($row = mysqli_fetch_assoc($res)) {
    $tit = $row['Title'];
    $tmp_arr = explode(' ', $row['Problems']);
    $beg_tym = $row['Start_Time'];
    $end_tym = $row['Finish_Time'];
}

if (mysqli_num_rows($res) == 0) {
    exit('<h1>No such contests found</h1>');
}

$prb_cnt = 'A';
$prb_arr = [];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include 'nav_bar.php'; ?>
    <input type="hidden" id="beg_tym_id" value="<?php echo $beg_tym; ?>">
    <input type="hidden" id="end_tym_id" value="<?php echo $end_tym; ?>">
    <input type="hidden" id="contest_id" value="<?php echo $id; ?>">
    <input type="hidden" id="first_prb_id" value="<?php echo $prb_arr['A']; ?>">
    <div class="container-fluid">
        <div class="text-center">
            <h1 class="text-center text-dark mt-5"><?php echo $tit; ?></h1>
            <div id="status"></div>
            <div id="show_clock" class="h6"></div>
        </div>
        <nav class="my-5 prb_info_tab fub mx-3 mx-lg-5">
            <div class="row px-3 py-1 shadow shadow-lg bg-light rounded text-center justify-content-center">
                <a class="col-12 col-lg-2 nav-link"
                    href="overview.php?id=<?php echo $id; ?>" role="tab"><b>Overview</b></a>
                <a class="col-12 col-lg-2 nav-link"
                    href="problem.php?id=<?php echo $id; ?>" role="tab"><b>Problems</b></a>
                <a class="col-12 col-lg-2 nav-link"
                    href="standing.php?id=<?php echo $id; ?>" role="tab"><b>Standing</b></a>
                <a class="col-12 col-lg-2 nav-link"
                    href="submission.php?id=<?php echo $id; ?>" role="tab"><b>Submission</b></a>
                <a class="col-12 col-lg-2 nav-link tab_active"
                    href="clarification.php?id=<?php echo $id; ?>" role="tab"><b>Clarification</b></a>
            </div>
        </nav>

        <div class="mx-lg-5 mb-5">
            <table class="table table-success table-hover rounded" style="cursor: pointer; cursor: hand;">
                <tbody>
                <?php
                $qry = "SELECT Cmnt_Id, Ques FROM Clarifi_Comment WHERE Contest_Id = '{$id}' AND _user = 'judge';";
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

        <div class="clar_section mb-5">
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
                        <button id="filter_btn" class="btn btn-secondary" onclick="loadData()">Apply</button>
                    </div>
                </div>
                <div class="col-12 col-lg-9"> 
                    <div class="load_clar"></div>
                </div>
            </div>
            <div class="ask_btn text-right mr-3 my-3 d-none">
                <button class="btn btn-primary rounded-pill" data-toggle="modal" data-target="#ask"><b>Ask to clarify</b></button>
            </div>
        </div>
        <?php include '../footer.php'; ?>
    </div>


    <div class="modal fade" data-backdrop="static" id="ask" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ask to clarify a specific problem</h5>
                    <button type="button" class="text-dark btn btn-sm" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                        <div class="form-group text-success h5">
                            <label><b>Problem:</b></label>
                            <select name="ask_prb" class="form-control">
                                <?php $prb_cnt = 'A'; for ($i = 0; $i < count($tmp_arr); $i++) { ?>
                                <option value="<?php echo $prb_cnt; ?>"><?php echo $prb_cnt; ?></option>
                                <?php
                                    $prb_cnt++;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group text-success h5">
                            <label><b>Question:</b></label>
                            <textarea name="ask_ques" class="form-control" rows="10" required=""></textarea>
                        </div>
                        <button type="submit" class="btn btn-success" name="ask_ques_submit"><b>Ask</b></button>
                    </form>
                </div>  
            </div>
        </div>
    </div>
    <div class="modal fade" data-backdrop="static" id="sfc" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Clarification</h5>
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
    if (isset($_POST['ask_ques_submit'])) {
        $ask_prb = $_POST['ask_prb'];
        $ask_ques = mysqli_real_escape_string($con, $_POST['ask_ques']);

        $unm = $_SESSION['Username'];
        $qry = "INSERT INTO Clarifi_Comment(Contest_Id, _user, Problem, Ques) VALUES('{$id}', '{$unm}', '{$ask_prb}', '{$ask_ques}');";
        mysqli_query($con, $qry);
        echo '<script>
            window.history.replaceState(null, null, window.location.href);
            window.location.reload();
        </script>';
    }
    ?>
    <script src="../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="../js/contest_validate.js" type="text/javascript"></script>
    <script>
        function loadData() {
            $("#filter_btn").text('Filtering...');
            $.ajax({
                url: "load_clarifi.php",
                method: "POST",
                data: {
                    problem: $("#search_prb").val(),
                    contest: "<?php echo $id; ?>"
                },
                success: function(response) {
                    $("#filter_btn").text('Apply');
                    console.log('len: ' + response.length);
                    $('.load_clar').html(response);
                }
            });
        }
        loadData();
        $(".show_ann_modal").click(function() {
            x = $(this).attr('data-id');
            //console.log('clar_id: ', x);

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
    </script>
</body>
</html>