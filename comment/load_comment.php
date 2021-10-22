<?php


echo '<div class="my-5"><hr>';

$qry = "SELECT * FROM Comment WHERE Origin = '{$origin}' AND Origin_Id = '{$origin_id}';";
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
                echo'<img class="img cmnt_image_prof rounded-circle" src="'.$img_path.'/'.$pp.'" alt="X">';
            }
            echo '<span class="ml-2"><b>'.$comment_unm.'</b></span>';
            echo '<span class="text-primary">'.' at '.'</span>';
            echo '<span class="text-muted">'.date('M j Y, g:i A', strtotime($comment_tym)).'</span>';
            if ($comment_unm == $user_nm) {
                echo '<span><button id="delc" class="ml-2 btn btn-sm btn-danger" value="'.$comment_id.'" onclick="del_comment()"><i class="far fa-trash-alt"></i></button></span>';
            }
            echo '<p class="ml-5">'.nl2br($comment_desc).'</p>';
        echo '</div>';
    }
}
echo '</div>';

?>