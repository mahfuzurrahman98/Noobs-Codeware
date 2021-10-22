<?php

include '../connection.php'; 
include 'security.php';

$problem = $_POST['problem'];
$contest = $_POST['contest'];
$qry = "SELECT Cmnt_Id, _user, Problem, Ques, Replied FROM User_Clarifi_Comment WHERE Contest_Id = '{$contest}' AND Problem LIKE '%{$problem}%' AND _user != 'judge' ORDER BY Added_On ASC;";
$res = mysqli_query($con, $qry);

?>

<table class="table table-hover bg-light rounded" style="cursor: pointer; cursor: hand;">
    <tbody>
    <?php
    while ($row = mysqli_fetch_assoc($res)) {
        $Cmnt_Id = $row['Cmnt_Id'];
        $_user = $row['_user'];
        $Problem = $row['Problem'];
        $Ques = $row['Ques'];
        $Replied = $row['Replied']; ?>

        <tr>
        <td class="h4 show_clar_modal" data-toggle="modal" data-target="#sfc" data-id="<?php echo $Cmnt_Id; ?>">
            <span><?php echo $Problem.'. '.substr($Ques, 0, 70); ?></span>
            <?php
            if ($Replied == 'yes') { ?>
                <span class="ml-1 text-success"><i class="fas fa-check-double"></i></span>
            <?php } ?>
        </td>
        </tr>

    <?php }  ?>

    </tbody>
</table>

<script>
    $(document).ready(function() {
        $(".show_clar_modal").click(function() {
            console.log('clickedddd')
            x = $(this).attr('data-id');
            console.log('clar_id: ', x);

            $.ajax({
                url: "show_clarifi.php",
                method: "POST",
                data: {
                    clar_id: x
                },
                success: function(response) {
                    $(".xyz").html(response);
                }
            });
        });
    });
</script>