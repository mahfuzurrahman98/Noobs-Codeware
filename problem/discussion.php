<?php

include '../connection.php'; 
include 'security.php';

if (!isset($_GET['id'])) {
    exit('<h1>No such pages found!<h1>');
}

$pid = $_GET['id'];
$unm = $_SESSION['Username'];

$qry_prb = "SELECT Title FROM Problem WHERE Id = '{$pid}';";
$res_prb = mysqli_query($con, $qry_prb) or exit('No such problem found!');

if (mysqli_num_rows($res_prb) == 0) {
    exit('<h1>No such problems found<h1>');
}
else {
    $tit = mysqli_fetch_assoc($res_prb)['Title'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tit; ?></title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include 'nav_bar.php'; ?>
    <div class="container-fluid">

        <nav class="mx-5 prb_info_tab">
            <div class="row p-2 shadow shadow-lg bg-light rounded text-center justify-content-center mt-5 mb-5">
                <a class="col-12 my-1 col-lg-3 mx-2 my-lg-0 nav-link"
                    href="details.php?id=<?php echo $pid; ?>" role="tab"><b>Details</b></a>
                <a class="col-12 my-1 col-lg-3 mx-2 my-lg-0 nav-link"
                    href="statistics.php?id=<?php echo $pid; ?>" role="tab"><b>Statistics</b></a>
                <a class="col-12 my-1 col-lg-3 mx-2 my-lg-0 nav-link tab_active"
                    href="discussion.php?id=<?php echo $pid; ?>" role="tab"><b>Disscussion</b></a>
            </div>
        </nav>
        
        <div id="cmt_section" class="my-5 mx-lg-5">
            <hr>
            <?php
            $qry = "SELECT * FROM Comment WHERE Origin = 'problem' AND Origin_Id = '{$pid}';";
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
        <div class="form-group my-5 mx-lg-5">
            <textarea class="form-control mb-2" rows="5" placeholder="Write something...." id="comment_desc" style="border-radius: 1.5rem;" required></textarea>
            <div class="d-flex justify-content-end">
            <button id="com_btn" class="btn btn-success rounded-pill" onclick="do_comment()"><b>Post</b></button>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </div>

    <script src="../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="../js/nav_bar.js" type="text/javascript"></script>
    <script>
    function do_comment() {
        $.ajax({
            url: "../comment/add_comment.php",
            method: "POST",
            data: {
                comment_content: $("#comment_desc").val(),
                user: "<?php echo $unm; ?>",
                origin: 'problem',
                origin_id: "<?php echo $pid; ?>",
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
                origin: 'problem',
                origin_id: "<?php echo $pid; ?>",
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