<?php 
include 'connection.php';
include 'security.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rank-Codeware</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include 'nav_bar.php'; ?>
    <div class="container-fluid">
        <div class="p-2">
            <h3 class="mt-5 mb-4 font-weight-bold text-success text-center">Global Rank</h3>
            <table class="table table-sm bg-light table-striped table-hover justify-content-cente rounded mb-3">
                <thead>
                <tr class="text-muted">
                <td><b>Rank</b></td>
                <td><b>Username</b></td>
                <td><b>Institute</b></td>
                <td><b>Solve</b></td>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $qry_up = "SELECT Username, Institute, Solve FROM User ORDER BY Solve DESC;";
                    $res_up = mysqli_query($con, $qry_up) or die("Query Failed!");
                    $ii = 1;
                    if (mysqli_num_rows($res_up) > 0) {
                        while ($row = mysqli_fetch_assoc($res_up)) {
                            $r_unm= $row['Username'];
                            $r_inst = $row['Institute'];
                            $r_rat = $row['Solve'];

                            $xx = "";
                            if ($_SESSION['Username'] == $r_unm) {
                                $xx = "table-danger";
                            }
                            
                            echo '<tr class='.$xx.'>';
                            echo '<td>'. $ii .'</td>';
                            $ii++;
                            echo '<td>'. $r_unm .'</td>';
                            echo '<td>'. $r_inst .'</td>';
                            echo '<td>'. $r_rat .'</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php include 'footer.php'; ?>
    </div>
    <script src="js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="js/nav_bar.js" type="text/javascript"></script>
    <script>
        $('#rnk').attr('class', 'nav-link text-success font-weight-bold');
    </script>
</body>

</html>