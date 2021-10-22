<?php

include '../connection.php';
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    exit('<h1>Invalid page request</h1>');
}

//Problem
$title = trim($_POST['title']);
$diff = $_POST['diff'];
$stat = $_POST['stat'];
$tags = [];
$tags = $_POST['tags'];
$unm = $_SESSION['Username'];

//Pagination
$page = $_POST['page'];
$lim = 3;
$off = ($page - 1) * $lim;

//Changes based on conditions
if ($title == '') {
    $title = '%';
}
if (count($tags) > 1) {
    array_pop($tags);
}

//Query writing
$qry = '';
$qry = "SELECT Id, Title, Difficulty, Requested, Approved FROM User_Problem WHERE Author = '{$unm}' AND Title LIKE '%{$title}%' AND Difficulty LIKE '%{$diff}%' AND (Tags LIKE '%{$tags[0]}%'";

//Adding tags
$len_tag = count($tags);
if ($len_tag == 1) { //only one tag or no tags
    $qry .= ")";
}
else { //more than one
    for ($i = 1; $i < $len_tag; $i++) {
        $qry .= " OR Tags LIKE '%{$tags[$i]}%'";
    }
    $qry .= ")";
}

if ($stat == 'nn') {
    $qry .= " AND Requested = 'No' AND Approved = 'No'";
}
else if ($stat == 'yn') {
    $qry .= " AND Requested = 'Yes' AND Approved = 'No'";
}
else if ($stat == 'yy') {
    $qry .= " AND Requested = 'Yes' AND Approved = 'Yes'";
}

$qry .= " ORDER BY Added_Time DESC LIMIT {$lim} OFFSET {$off};";
echo 'Query: '.$qry;
$res = mysqli_query($con, $qry) or die('Query Error');
if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $prb_id = $row['Id'];
        $prb_tit = $row['Title'];
        $prb_dif = $row['Difficulty'];
        $req = $row['Requested'];
        $app = $row['Approved'];

        echo '<tr>';
            echo '<td><b><a href="problem/show.php?id='.$prb_id.'">'.$prb_tit.'</a></b></td>';
            if ($prb_dif == 'Simple') {
                echo '<td class="text-secondary">'.$prb_dif.'</td>';
            }
            else if ($prb_dif == 'Easy') {
                echo '<td class="text-success">'.$prb_dif.'</td>';
            }
            else if ($prb_dif == 'Medium') {
                echo '<td class="text-warning">'.$prb_dif.'</td>';
            }
            else if ($prb_dif == 'Moderate') {
                echo '<td style="color: rgb(214, 118, 70);">'.$prb_dif.'</td>';
            }
            else {
                echo '<td class="text-danger">'.$prb_dif.'</td>';
            }

            if ($req == 'No' && $app == 'No') {
                echo '<td>Not Requested</td>';
            }
            else if ($req == 'Yes' && $app == 'No') {
                echo '<td>Requested</td>';
            }
            else if ($req == 'Yes' && $app == 'Yes') {
                echo '<td>Archived</td>';
            }
        echo '</tr>';
    }
}
else {
    echo '<tr class="text-danger text-center">';
        echo '<td>No</td>';
        echo '<td>results</td>';
        echo '<td>are</td>';
        echo '<td>found</td>';
    echo '</tr>';
}
?>

<script>
    console.log("<?php echo $qry; ?>");
</script>