<?php

include '../../connection.php';
include 'security.php';

$id = $_POST['id'];
$flag = TRUE;
$qry = "SELECT Title, Problems, Start_Time, Finish_Time FROM User_Contest WHERE Id = '{$id}';";
$res = mysqli_query($con, $qry);

while ($row = mysqli_fetch_assoc($res)) {
    $tit = $row['Title'];
    if (!$row['Problems']) {
        $flag = FALSE;
    }
    $probs = explode(' ', $row['Problems']);
    $beg_tym = $row['Start_Time'];
    $end_tym = $row['Finish_Time'];
}

$prb_cnt = 'A';
$prb_arr = [];
for ($i = 0; $i < count($probs); $i++) {
    $qry = "SELECT Title FROM User_Problem WHERE Id = '{$probs[$i]}';";
    $res = mysqli_query($con, $qry);
    $prb_arr[$prb_cnt] = mysqli_fetch_assoc($res)['Title'];
    $prb_cnt++;
}

$unm = $_SESSION['Username'];
$username = trim($_POST['username']);
$title = trim($_POST['title']);
$verdict = trim($_POST['verdict']);
$language = trim($_POST['language']);
$page = $_POST['page'];
$lim = 3;
$off = ($page - 1) * $lim;
$qry = '';

if ($username == 'All' OR $username == '') {
    $username = '%';
}
else if ($username == 'My Only') {
    $username = $_SESSION['Username'];
}
if ($title == '') {
    $title = '%';
}
if ($verdict == 'All') {
    $verdict = '%';
}
if ($language == 'All') {
    $language = '%';
}

if ($username == 'Friends Only') {
    $qry = "SELECT * FROM Contest_Submission WHERE Contest_Id = '{$id}' AND Problem LIKE '%{$title}%' AND Verdict LIKE '%{$verdict}%' AND Language LIKE '%{$language}%' AND Username IN (SELECT Followed FROM Friend WHERE _user = '{$unm}')";
}
else {
    $qry = "SELECT * FROM Contest_Submission WHERE Contest_Id = '{$id}' AND Username LIKE '%{$username}%' AND Problem LIKE '%{$title}%' AND Verdict LIKE '%{$verdict}%' AND Language LIKE '%{$language}%'";
}
$qry .= " ORDER BY Sub_Time DESC LIMIT {$lim} OFFSET {$off};";
$res = mysqli_query($con, $qry) or die('Error');

while ($row = mysqli_fetch_assoc($res)) {
    $qry_pid = "SELECT Id FROM Problem WHERE Title = '{$title}';";
    $res_pid = mysqli_query($con, $qry_pid);
    while ($row_pid = mysqli_fetch_assoc($res_pid)) { $pid = $row_pid['Id']; }
    $ver = $row['Verdict'];
    $ver_class = ''; 
    if (substr($ver, 0, 1) == 'C') {$ver_class = 'ver-ce';}
    if (substr($ver, 0, 1) == 'R') {$ver_class = 'ver-re';}
    if (substr($ver, 0, 1) == 'T') {$ver_class = 'ver-tle';}
    if (substr($ver, 0, 1) == 'W') {$ver_class = 'ver-wa';}
    if (substr($ver, 0, 1) == 'A') {$ver_class = 'ver-acc';}
    ?>
    <tr>
    <td><a class="code_modal" href="javascript:void(0)" data-toggle="modal" data-target="#show_code" data-id=<?php echo $row['Sub_Id']; ?>><?php echo sprintf('%04d',$row['Sub_Id']); ?></a></td>
    <td><?php echo $row['Problem'].'. '.$prb_arr[$row['Problem']]; ?></td>
    <td><a class="text-info" href="../profile.php?user=<?php echo $row['Username']; ?>"><?php echo $row['Username']; ?></a></td>
    <td class="<?php echo $ver_class; ?>"><?php echo $row['Verdict']; ?></td>
    <td><?php echo $row['Language']; ?></td>
    <td><?php echo sprintf('%0.2f', ($row['Time'])).' sec'; ?></td>
    <td><?php echo sprintf('%0.2f', ($row['Memory'] / 1024)).' MB'; ?></td>
    <td><?php echo $row['Sub_Time']; ?></td>
    </tr>
<?php } ?>


<script src="../js/jquery-3.6.0.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $(".code_modal").click(function() {
            x = $(this).attr('data-id');
            console.log(x)
            $.ajax({
                url: "load_src_code.php",
                method: "POST",
                data: {
                    sub_id: x
                },
                success: function(response) {
                    $(".xyz").html(response);
                }
            });
        });
    });
</script>
