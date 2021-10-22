<?php

include '../connection.php';
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    exit('<h1>Invalid page request</h1>');
}
//User
$unm = $_SESSION['Username'];
//Problem
$title = trim($_POST['title']);
$diff = $_POST['diff'];
$tags = [];
$tags = $_POST['tags'];
//Submission
$status = $_POST['status'];
//Statistics
$sort = $_POST['sort'];
//Pagination
$page = $_POST['page'];
$lim = 5;
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
//Submission status check
if ($status == 'Unattempted') {
    $qry = "SELECT Id, Title, Difficulty, No_Of_Acc, No_Of_Sub, Added_Time FROM Problem JOIN Problem_Statistics ON P_Id = Id WHERE Title NOT IN (SELECT DISTINCT Problem_Title FROM Submission WHERE Username = '{$unm}') AND Title LIKE '%{$title}%' AND Difficulty LIKE '%{$diff}%' AND (Tags LIKE '%{$tags[0]}%'";
}

else if ($status == 'Attempted') {
    $qry = "SELECT DISTINCT Id, Title, Difficulty, No_Of_Acc, No_Of_Sub, Added_Time FROM Problem JOIN Status ON Title = Problem_Title JOIN Problem_Statistics ON  P_Id = Id WHERE Problem_Title NOT IN(SELECT DISTINCT Problem_Title FROM Submission WHERE Verdict = 'Accepted') AND Title LIKE '%{$title}%' AND Difficulty LIKE '%{$diff}%' AND Username = '{$unm}' AND Verdict != 'Accepted' AND (Tags LIKE '%{$tags[0]}%'";
}

else if ($status == 'Solved') {
    $qry = "SELECT DISTINCT Id, Title, Difficulty, No_Of_Acc, No_Of_Sub, Added_Time FROM Problem JOIN Submission ON Title = Problem_Title JOIN Problem_Statistics ON  P_Id = Id WHERE Title LIKE '%{$title}%' AND Difficulty LIKE '%{$diff}%' AND Username = '{$unm}' AND Verdict = 'Accepted' AND (Tags LIKE '%{$tags[0]}%'";
}

else if ($status == 'All') {
    $qry = "SELECT Id, Title, Difficulty, No_Of_Acc, No_Of_Sub, Added_Time FROM Problem JOIN Problem_Statistics ON Id = P_Id WHERE Title LIKE '%{$title}%' AND Difficulty LIKE '%{$diff}%' AND (Tags LIKE '%{$tags[0]}%'";
}

//Adding tags
$len_tag = count($tags);
if ($len_tag == 1) { //only one tag or no tags
    $qry .= ") AND Archive = 'show'";
}
else { //more than one
    for ($i = 1; $i < $len_tag; $i++) {
        $qry .= " OR Tags LIKE '%{$tags[$i]}%'";
    }
    $qry .= ") AND Archive = 'show'";
}

//Sort problem
if ($sort == 'acc_asc') {
    $qry .= " ORDER BY (No_Of_Acc / No_Of_Sub) ASC";
}
else if ($sort == 'acc_desc') {
    $qry .= " ORDER BY (No_Of_Acc / No_Of_Sub) DESC";
}
else if ($sort == 'sub_asc') {
    $qry .= " ORDER BY No_Of_Sub ASC";
}
else if ($sort == 'sub_desc') {
    $qry .= " ORDER BY No_Of_Sub DESC";
}
else if ($sort == 'unsorted') {
    $qry .= " ORDER BY Added_Time DESC";
}
$qry .= " LIMIT {$lim} OFFSET {$off};";

$res = mysqli_query($con, $qry) or die('Query Error');
if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $prb_id = $row['Id'];
        $prb_tit = $row['Title'];
        $prb_dif = $row['Difficulty'];
        $prb_acc = $row['No_Of_Acc'];
        $prb_sub = $row['No_Of_Sub'];
        if ($prb_sub == 0) {
            $prb_acc_rat = sprintf('%0.2f', 0);
        }
        else {
            $prb_acc_rat = sprintf('%0.2f',($prb_acc / $prb_sub) * 100);
        }

        echo '<tr>';
            echo '<td><a href="details.php?id='.$prb_id.'">'.$prb_tit.'</a></td>';
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
            echo '<td style="color: darkgreen;">'.$prb_acc_rat.'%</td>';
            echo '<td style="color: grey;">'.$prb_sub.'</td>';
        echo '</tr>';
    }
}
?>

