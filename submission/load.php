<?php

include '../connection.php';

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    exit('<h1>Invalid page request</h1>');
}

$unm = $_SESSION['Username'];
$username = trim($_POST['username']);
$title = trim($_POST['title']);
$verdict = trim($_POST['verdict']);
$language = trim($_POST['language']);
$page = $_POST['page'];
$lim = 10;
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
if ($language == 'All') {
    $language = '%';
}

if ($username == 'Friends Only') {
    $qry = "SELECT * FROM Submission WHERE Problem_Title LIKE '%{$title}%' AND Verdict LIKE '{$verdict}%' AND Language LIKE '%{$language}' AND Username IN (SELECT Followed FROM Friend WHERE _user = '{$unm}')";
}
else {
    $qry = "SELECT * FROM Submission WHERE Username LIKE '%{$username}%' AND Problem_Title LIKE '%{$title}%' AND Verdict LIKE '{$verdict}%' AND Language LIKE '%{$language}'";
}
$qry .= " ORDER BY Sub_Time DESC LIMIT {$lim} OFFSET {$off};";
$res = mysqli_query($con, $qry);

while ($row = mysqli_fetch_assoc($res)) {
    $ver = $row['Verdict'];
    $ver_class = ''; 
    if (substr($ver, 0, 1) == 'C') {$ver_class = 'ver-ce';}
    if (substr($ver, 0, 1) == 'R') {$ver_class = 'ver-re';}
    if (substr($ver, 0, 1) == 'T') {$ver_class = 'ver-tle';}
    if (substr($ver, 0, 1) == 'M') {$ver_class = 'ver-mle';}
    if (substr($ver, 0, 1) == 'W') {$ver_class = 'ver-wa';}
    if (substr($ver, 0, 1) == 'A') {$ver_class = 'ver-acc';}
    ?>
    <tr>
    <td><a class="code_modal" href="javascript:void(0)" data-toggle="modal" data-target="#show_code" data-id=<?php echo $row['Sub_Id']; ?>><?php echo sprintf('%04d',$row['Sub_Id']); ?></a></td>
    <td><a class="text-dark" href="../problem/details.php?id=<?php echo $row['Problem_Id']; ?>"><?php echo $row['Problem_Title']; ?></a></td>
    <td><a class="text-info" href="../profile.php?user=<?php echo $row['Username']; ?>"><?php echo $row['Username']; ?></a></td>
    <td class="<?php echo $ver_class; ?>"><?php echo $row['Verdict']; ?></td>
    <td><?php echo $row['Language']; ?></td>
    <td><?php echo sprintf('%0.2f', ($row['Time'])).' sec'; ?></td>
    <td><?php echo sprintf('%0.2f', ($row['Memory'] / 1024)).' MB'; ?></td>
    <td><?php echo date('Y-m-d H:i', $row['Sub_Time']); ?></td>
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
