<?php include '../keep_secure.php';?>
<?php
if ($_SESSION['Role'] == 0) {
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
    .adm-txt {
        font-size: 40px;
        font-family: ubuntu;
        font-weight: bold;
        color: white;
    }
    .dropdown-item:hover {
        background-color: #73D216FF;
    }

    
    .project-tab #tabs {
        background: #007b5e;
        color: #eee;
    }

    .project-tab #tabs h6.section-title {
        color: #eee;
    }

    .project-tab #tabs .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
        color: #387506;
        background-color: transparent;
        border-color: transparent transparent #f3f3f3;
        border-bottom: 3px solid !important;
        font-size: 16px;
        font-weight: bold;
    }

    .project-tab .nav-link {
        border: 1px solid transparent;
        border-top-left-radius: .25rem;
        border-top-right-radius: .25rem;
        color: #067515;
        font-size: 16px;
        font-weight: 600;
    }

    .project-tab .nav-link:hover {
        border: none;
    }

    .project-tab thead {
        background: #f3f3f3;
        color: #333;
    }

    .project-tab a {
        text-decoration: none;
        color: #333;
        font-weight: 600;
    }
    </style>
    </style>
</head>

<body>
    <div class="contain">

        <?php include 'nav_bar.php' ?>
        
        <nav class="project-tab">
            <div class="nav text-center row nav-tabs justify-content-center mt-5 mb-5" id="nav-tab" role="tablist">
                <a class="col border mx-1 mt-2 mt-sm-0 nav-link active" id="nav-add_prb-tab" data-toggle="tab" href="#nav-add_prb" role="tab"
                    aria-controls="nav-add_prb" aria-selected="true"><b>Problem</b></a>
                <a class="col mx-1 mt-2 mt-sm-0 nav-link" id="nav-add_update-tab" data-toggle="tab" href="#nav-add_update" role="tab"
                    aria-controls="nav-add_update" aria-selected="false"><b>Announcement</b></a>
                <a class="col mx-1 mt-2 mt-sm-0 nav-link" id="nav-add_post-tab" data-toggle="tab" href="#nav-add_post" role="tab"
                    aria-controls="nav-add_post" aria-selected="false"><b>Tutorial</b></a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-add_prb" role="tabpanel" aria-labelledby="nav-add_prb-tab">
                <form class = "shadow-lg p-3 bg-light rounded mb-4" action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="X1"><b>Title:</b></label>
                            <input type="text" name="tit" class="form-control" id="X1" placeholder="Enter the title">
                        </div>
                        <div class="col-lg-6 mt-3 mt-lg-0">
                            <label for="X2"><b>Difficulty:</b></label>
                            <select class="form-control" name="dif">
                            <option selected value="Easy">Easy</option>
                            <option value="Medium">Medium</option>
                            <option value="Hard">Hard</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="X3"><b>Statement:</b></label>
                        <textarea name="stat" class="form-control mb-2" placeholder="Write the statement" id="X3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="X44"><b>Input Format:</b></label>
                        <textarea name="inpf" class="form-control mb-2" placeholder="Write the input format" id="X44"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="X444"><b>Output Format:</b></label>
                        <textarea name="outf" class="form-control mb-2" placeholder="Write the output format" id="X444"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="X4"><b>Constraints:</b></label>
                        <textarea name="cons" class="form-control mb-2" placeholder="Write the constrints" id="X4"></textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="X5"><b>Sample Input:</b></label>
                            <textarea name="samp_inp" class="form-control mb-2" placeholder="Enter the sample input" id="X5"></textarea>
                        </div>
                        <div class="col-lg-6">
                            <label for="X6"><b>Sample Output:</b></label>
                            <textarea name="samp_out" class="form-control mb-2" placeholder="Enter the sample output" id="X6"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="X55"><b>Full Input:</b></label>
                            <textarea name="full_inp" class="form-control mb-2" placeholder="Enter the full input" id="X55"></textarea>
                        </div>
                        <div class="col-lg-6">
                            <label for="X66"><b>Full Output:</b></label>
                            <textarea name="full_out" class="form-control mb-2" placeholder="Enter the full output" id="X66"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="X443"><b>Notes:</b></label>
                        <textarea name="note" class="form-control mb-2" placeholder="Write notes or explanations" id="X443"></textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="X7"><b>Problem Setter: (<span class="text-danger">Enter username if registered</span>)</b></label>
                            <input type="text" name="prb_set" class="form-control" id="X7"
                                placeholder="Enter The problem setter's name">
                        </div>
                        <div class="col-lg-6 mt-3 mt-lg-0">
                            <label for="X8"><b>Testcase Contributor: (<span class="text-danger">Enter username if registered</span>)</b></label>
                            <input type="text" name="tc_cont" class="form-control" id="X8"
                                placeholder="Enter the test case contributor's name">
                        </div>
                    </div>
                    <button type="submit" name="add" class="btn btn-success"><b>Add</b></button>
                </form>
                <?php
                if (isset($_POST['add'])) {
                    $tit = $_POST['tit'];
                    $dif = $_POST['dif'];
                    $stat = $_POST['stat'];
                    $cons = $_POST['cons'];
                    $inpf = $_POST['inpf'];
                    $outf = $_POST['outf'];
                    $samp_inp = $_POST['samp_inp'];
                    $samp_out = $_POST['samp_out'];
                    $full_inp = $_POST['full_inp'];
                    $full_out = $_POST['full_out'];
                    $note = $_POST['note'];
                    $prb_set = $_POST['prb_set'];
                    $tc_cont = $_POST['tc_cont'];
                    echo $dif;
                    if (strlen($tit) == 0 or strlen($dif) == 0 or strlen($stat) == 0 or strlen($cons) == 0 or strlen($samp_out) == 0 or strlen($full_out) == 0 or strlen($prb_set) == 0 or strlen($inpf) == 0 or strlen($outf) == 0 or strlen($note) == 0 or strlen($tc_cont) == 0) {
                        echo '<script>
                            if (window.history.replaceState) {
                                window.history.replaceState(null, null, window.location.href);
                            }
                            alert("You left input fields blank!");
                            window.location.reload();
                        </script>';
                    }
                    
                    $qry1 = "SELECT Id FROM Problem WHERE Title = '{$tit}';";
                    $res1 = mysqli_query($con, $qry1) or die("Query Failed!");
                    if (mysqli_num_rows($res1) > 0) {
                        echo '<script>
                            if (window.history.replaceState) {
                                window.history.replaceState(null, null, window.location.href);
                            }
                            alert("Title already exists!");
                            window.location.reload();
                        </script>';
                    }
    
                    else {
                        $qry = "INSERT INTO Problem(Title, difficulty, Statement, Constraints, Input_Format, Output_Format, Sample_Input, Sample_Output, Full_Input, Full_Output, Notes, Author, TC_Contributor) VALUES('{$tit}', '{$dif}', '{$stat}', '{$cons}', '{$inpf}', '{$outf}', '{$samp_inp}', '{$samp_out}', '{$full_inp}', '{$full_out}', '{$note}', '{$prb_set}', '{$tc_cont}');";
                        $res = mysqli_query($con, $qry);
                        echo '<script>
                            if (window.history.replaceState) {
                                window.history.replaceState(null, null, window.location.href);
                            }
                            alert("Tutorial uploaded successfully!");
                            window.location.reload();
                        </script>';
                    }
                }
                ?>
            </div>
            <div class="tab-pane fade" id="nav-add_update" role="tabpanel" aria-labelledby="nav-add_update-tab">
                <form class = "shadow-lg p-3 bg-light rounded mb-4" action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                    <div class="form-group">
                        <label for="X1"><b>Title:</b></label>
                        <input type="text" name="up_tit" class="form-control" id="X1" placeholder="Enter the title">
                    </div>
                    <div class="form-group">
                        <label for="X2"><b>Description:</b></label>
                        <textarea name="desc" class="form-control mb-2" placeholder="Write the descriptions" rows="15" id="X2"></textarea>
                    </div>
                    <button type="submit" name="pst" class="btn btn-success"><b>Post</b></button>
                </form>
                <?php
                if (isset($_POST['pst'])) {
                    $up_tit = $_POST['up_tit'];
                    $desc = $_POST['desc'];
                    $auth = $_SESSION['Username'];

                    if (strlen($up_tit) == 0 or strlen($desc) == 0) {
                        echo '<script>
                            if (window.history.replaceState) {
                                window.history.replaceState(null, null, window.location.href);
                            }
                            alert("You left input fields blank!");
                            window.location.reload();
                        </script>';
                    }
    
                    else {
                        $qry = "INSERT INTO Announcement(Title, Description, Author) VALUES('{$up_tit}', '{$desc}', '{$auth}');";
                        mysqli_query($con, $qry) or die('Inserting Announcement Failed!');
                        echo '<script>
                            if (window.history.replaceState) {
                                window.history.replaceState(null, null, window.location.href);
                            }
                            alert("Announcement uploaded successfully!");
                            window.location.reload();
                        </script>';
                    }
                }
                ?>
            </div>
                
            <div class="tab-pane fade" id="nav-add_post" role="tabpanel" aria-labelledby="nav-add_post-tab">
                <form class = "shadow-lg p-3 bg-light rounded mb-4" action="<?php $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="Xx1"><b>Title:</b></label>
                        <input type="text" name="tut_tit" class="form-control" id="Xx1" placeholder="Enter the title">
                    </div>
                    <div class="form-group">
                        <label for="Xx2"><b>Category:</b></label>
                        <select class="form-control" name="cat">
                            <option selected value="Math">Math</option>
                            <option value="Number Theory">Number Theory</option>
                            <option value="Combinatorics">Combinatorics</option>
                            <option value="Data Structure">Data Structure</option>
                            <option value="Geomeatry">Geomeatry</option>
                            <option value="Algorithm">Algorithm</option>
                            <option value="Graph Theory">Graph Theory</option>
                            <option value="Dynamic Programming">Dynamic Programming</option>
                            <option value="Greedy">Greedy</option>
                            <option value="Game Theory">Game Theory</option>
                            <option value="Tools & Tips">Tools & Tips</option>
                            <option value="Programming Language">Programming Language</option>
                            <option value="OJ Problems Editorial">OJ Problems Editorial</option>
                            <option value="Numerical Methods">Numerical Methods</option>
                            <option value="Computer Science">Computer Science</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Xx3"><b>Author:</b></label>
                        <input type="text" name="tut_auth" class="form-control" id="Xx3" placeholder="Enter the author name, or username if he is registered">
                    </div>
                    <div class="form-group">
                        <label for="Xx4"><b>File to upload:</b></label>
                        <input type="file" name="doc_file" class="form-control-file" id="Xx4">
                    </div>
                    <button type="submit" name="pub" class="btn btn-success"><b>Publish</b></button>
                </form>
                <?php
                if (isset($_POST['pub'])) {
                    if (isset($_FILES['doc_file'])) {
                        $fname = $_FILES['doc_file']['name'];
                        $ftmp = $_FILES['doc_file']['tmp_name'];
                        $ftyp = $_FILES['doc_file']['type'];
                        $fext = substr($fname, strrpos($fname, '.')  + 1);
                        
                        if ($fext == 'pdf') {
                            $tut_tit = $_POST['tut_tit'];
                            $tut_auth = $_POST['tut_auth'];
                            $cat = $_POST['cat'];
                            $iname = $tut_tit . '.' . $fext;
                            move_uploaded_file($ftmp, "Uploads/" . $iname);
                            $qry = "INSERT INTO Tutorial(Title, Author, Category, File_Name) VALUES('{$tut_tit}', '{$tut_auth}', '{$cat}', '{$iname}');";
                            $res = mysqli_query($con, $qry);

                            echo '<script>
                                if (window.history.replaceState) {
                                    window.history.replaceState(null, null, window.location.href);
                                }
                                alert("Tutorial uploaded successfully!");
                                window.location.reload();
                            </script>';
                        }
                        else {
                            echo '<script>
                                if (window.history.replaceState) {
                                    window.history.replaceState(null, null, window.location.href);
                                }
                                alert("Upload PDF file only!");
                                window.location.reload();
                            </script>';
                        }
                    }
                    echo '<script>
                        if (window.history.replaceState) {
                            window.history.replaceState(null, null, window.location.href);
                        }
                        alert("Tutorial uploaded successfully!");
                        window.location.reload();
                    </script>';
                }
                ?>
            </div>
        </div>

        <?php include '../footer.php'; ?>
    </div>
    
    <script src="../jquery/jquery-3.6.0.slim.min.js" type="text/javascript"></script>
    <script src="../js/bootstrap.bundle.min.js" type="text/javascript"></script>
</body>

</html>