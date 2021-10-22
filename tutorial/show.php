<?php

include '../connection.php';
include 'security.php';

if (!isset($_GET['id'])) {
    exit('<h1>No such pages found!</h1>');
}
$tid = $_GET['id'];
$unm = $_SESSION['Username'];
$qry_tut = "SELECT * FROM Tutorial WHERE Id = $tid;";
$res_tut = mysqli_query($con, $qry_tut) or exit('No such tutorial found!');
if (mysqli_num_rows($res_tut) == 0) {
    exit('<h1>No such tutorials found!</h1>');
}

while ($row = mysqli_fetch_assoc($res_tut)) {
    $tut_tit = $row['Title'];
    $tut_content = $row['Content'];
    $tut_auth = $row['Author'];
    $tut_cat = $row['Category'];
    $tut_tym = $row['Added_Time'];
}

$qry_author = "SELECT Username FROM User WHERE Username = '{$tut_auth}';";
$res_author = mysqli_query($con, $qry_author);

if (mysqli_num_rows($res_author) > 0) {
    $tut_auth = '<a href="../profile.php?user=' . $tut_auth . '">' . $tut_auth . '</a>';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tut_tit; ?></title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include 'nav_bar.php';?>
    <div class="container-fluid">
        <div class="row">
        <div class="col-12 col-lg-9">
        <div class="mt-5">
            <h3 class="my-3 mt-3"><b> <?php echo $tut_tit ?></b> </h3>
            <div class="row">
                <div class="col-12"><?php echo 'Category: ' . $tut_cat . '<br>'; ?></div>
                <div class="col-12">
                    <i class="fas fa-user-secret"></i>
                    <?php
                    echo 'Author: '.$tut_auth . '<br>'; ?>
                </div>
                <div class="col-12">
                    <div><i class="far fa-calendar-alt"></i> <span class="text-info">
                            <?php echo date('M j Y, g:i A', strtotime($tut_tym)); ?></span></div>
                </div>
            </div>
            <div class="shadow bg-light rounded p-4 mt-3 mb-5">
                <?php echo $tut_content; ?>
            </div>
        </div>
        
        <div id="cmt_section" class="my-5 mx-lg-5">
            <hr>
            <?php
            $qry = "SELECT * FROM Comment WHERE Origin = 'tutorial' AND Origin_Id = '{$tid}';";
            $res = mysqli_query($con, $qry) or die("Query Failed!");

            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $comment_id = $row['Id'];
                    $comment_desc = $row['Content'];
                    $comment_unm = $row['_user'];
                    $comment_tym = $row['Added_Time'];

                    $qry_pc = "SELECT Profile_Picture FROM User WHERE Username = '{$comment_unm}';";
                    $res_pc = mysqli_query($con, $qry_pc) or die("Query Failed!");
                    $pp = mysqli_fetch_assoc($res_pc)['Profile_Picture'];

                    echo '<div class="shadow-lg rounded p-2 mb-2">';
                        $ex_path = '';
                        if (is_null($pp)) {
                            echo'<img class="img cmnt_image_prof rounded-circle" src="'.$img_path.'/user.png" alt="X">';
                        }
                        else {
                            echo'<img class="img cmnt_image_prof rounded-circle" src="../uploads/user/profile_picture/'.$pp.'" alt="X">';
                        }
                        echo '<span class="ml-2"><b>'.$comment_unm.'</b></span>';
                        echo '<span class="text-primary">'.' at '.'</span>';
                        echo '<span class="text-muted">'.date('M j Y, g:i A', strtotime($comment_tym)).'</span>';
                        echo '<p class="ml-5">'.nl2br($comment_desc).'</p>';
                        if ($comment_unm == $unm) {
                            echo '<button id="delc" class="ml-5 btn btn-sm btn-danger" value="'.$comment_id.'" onclick="del_comment()">Delete</button>';
                        }
                    echo '</div>';
                }
            }
            ?>
        </div>
        <div class="form-group">
            <textarea class="form-control mb-2" placeholder="Write a comment...." id="comment_desc" style="border-radius: 1.5rem;" required></textarea>
            <div class="d-flex justify-content-end">
            <button id="com_btn" class="btn btn-success rounded-pill" onclick="do_comment()"><b>Comment</b></button>
            </div>
        </div>
        </div>
        <div class="col-12 col-lg-3 mt-5">
            <h5 class="text-center text-success">Related Tutorials</h5><hr>
            <?php
            $qry_rel = "SELECT Id, Title FROM Tutorial WHERE Category = '{$tut_cat}';";
            $res_rel = mysqli_query($con, $qry_rel  ) or die("Selection Query Failed!");

            if (mysqli_num_rows($res_rel) > 0) {
                while ($row = mysqli_fetch_assoc($res_rel)) {
                    $rel_id = $row['Id'];
                    $rel_tit = $row['Title'];
                    if ($rel_tit == $tut_tit) {
                        continue;
                    }
                    echo '<a class="ml-lg-2" href="tutorial.php?id='.$rel_id.'">'.$rel_tit.'</a><br>';
                }
            }
            ?>
        </div>
        </div>
        <?php include '../footer.php'; ?>
    </div>
    <script src="../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script>
    function do_comment() {
        $.ajax({
            url: "../comment/add_comment.php",
            method: "POST",
            data: {
                comment_content: $("#comment_desc").val(),
                user: "<?php echo $unm; ?>",
                origin: 'tutorial',
                origin_id: <?php echo $tid; ?>,
                img_path: '../uploads/user/profile_picture'
            },
            success: function(response) {
                $('#cmt_section').html(response);
                $("#comment_desc").val('')
            }
        });
    }

    function del_comment() {
        $.ajax({
            url: "../comment/delete_comment.php",
            method: "POST",
            data: {
                user: "<?php echo $unm; ?>",
                origin: 'tutorial',
                origin_id: <?php echo $tid; ?>,
                comment_id: $("#delc").val(),
                img_path: '../uploads/user/profile_picture'
            },
            success: function(response) {
                $('#cmt_section').html(response)
            }
        });
    }
    </script>
</body>

</html>