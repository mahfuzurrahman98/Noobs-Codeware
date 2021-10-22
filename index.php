<?php
include 'connection.php';
include 'security.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include 'nav_bar.php';?>
    <div class="container-fluid">
        <div class="d-none shadow shadow-lg text-center my-4 p-2 bg-white" style="border-radius: 25px;">
            <div class="text-primary h3">Welcome, <?php echo $_SESSION['Name']; ?></div>
			<div class="text-success h4">Greetings from Noobs Codeware</div>
        </div>

        <div class="row justify-content-center mx-1 mx-lg-0 mt-3">
            <div class="col-12 col-lg-3 mx-4 my-3 p-3 shadow-lg bg-white rounded"
            style="cursor: pointer;" onclick="window.location='problem';">
                <div class="text-center mb-3"><i class="fas fa-code-branch fa-5x"></i></div>
                <h4 class=""><b>Solve</b></h4>
                <p class="">Solve various categorized problems of several difficulty levels.</p>
            </div>

            <div class="col-12 col-lg-3 mx-4 my-3 p-3 shadow-lg bg-white rounded"
            style="cursor: pointer;" onclick="window.location='contest';">
                <div class="text-center mb-3"><i class="fas fa-trophy fa-5x"></i></div>
                <h4 class=""><b>Compete</b></h4>
                <p class="">Participate in our native and other contests. Host your own contest.</p>
            </div>

            <div class="col-12 col-lg-3 mx-4 my-3 p-3 shadow-lg bg-white rounded"
            style="cursor: pointer;" onclick="window.location='tutorial';">
                <div class="text-center mb-3"><i class="fas fa-book fa-5x"></i></div>
                <h4 class=""><b>Learn</b></h4>
                <p class="">Learn new algorithms and techniques to increase your programming skill.</p>
            </div>
        </div>

        <div class="my-4 row mx-1 justify-content-center">
            <div class="col-12 col-lg-7 mx-3 shadow shadow-lg bg-white">
                <p class="h4 text-center text-success mt-2"><u>Whats new</u></p>
                <table class="table table-sm">
                <?php
                $qry = "SELECT * FROM _Update LIMIT 10;";
                $res = mysqli_query($con, $qry);
                while ($row = mysqli_fetch_assoc($res)) {
                ?>
                    <tr><td><li>
                    <a href="update/show.php?id=<?php echo $row['Id']; ?>">
                        <?php echo substr($row['Description'], 0, 120) . '...'; ?>
                    </a> by 
                    <a class="text-danger" href="profile.php?user=<?php echo $row['Author']; ?>">
                        <?php echo $row['Author']; ?>
                    </a>
                    </li></td></tr>
                <?php
                }
                ?>
                </table>
                <p class="text-center"><a class="text-success" href="update"><u>show all</u></a></p>
            </div>
            <div class="col-12 col-lg-4 mx-3 shadow shadow-lg bg-white mt-4 mt-lg-0">
                <h4 class="text-center text-success mt-2"><u>Top solvers</u></h4>
                <table class="table table-sm">
                <?php
                $unm = $_SESSION['Username'];
                $qry = "SELECT Username, Solve FROM User ORDER BY Solve DESC LIMIT 10;";
                $res = mysqli_query($con, $qry);
                while ($row = mysqli_fetch_assoc($res)) {
                ?>
                    <tr <?php if ($row['Username'] == $unm) { ?> class="alert alert-danger" <?php } ?>>
                        <td class="text-primary">
                            <a href="profile.php?user=<?php echo $row['Username'] ?>"><?php echo $row['Username'] ?></a>
                        </td>
                        <td>
                            <?php echo $row['Solve'];?>
                        </td>
                    </tr>
                <?php } ?>
                </table>
                <p class="text-center"><a class="text-success" href="rank.php"><u>show all</u></a></p>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </div>
    <script src="js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="js/bootstrap.bundle.js" type="text/javascript"></script>
    <script src="js/select2.js" type="text/javascript"></script>
</body>

</html>