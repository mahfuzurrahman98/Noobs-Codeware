<?php

include '../../connection.php';
include 'security.php';

if (!isset($_GET['id'])) {
    exit('<h1>No such pages found</h1>');
}


$pid = $_GET['id'];

$qry_prb = "SELECT * FROM User_Problem WHERE Id = '{$pid}';";
$res_prb = mysqli_query($con, $qry_prb) or die("<h1>No such pages found</h1>");

while ($row = mysqli_fetch_assoc($res_prb)) {
    $tit = $row['Title'];
    $samp_tst = explode(' ', $row['Sample_Test']);
    $saved_lang =  $row['Judges_Sol_Lang'];
    $saved_code = $row['Judges_Solution'];
}

function get_last($dir) {
   $files = scandir($dir);
   $sz = count($files);
   $last = $files[$sz - 1];
   $i = 0;
   $x = 0;
   $d = 0;
   while ($last[$i] != '.') {
      $d = $last[$i];
      $x = $x * 10 + $d;
      $i++;
   }
   return $x;
}

function idff($fname) {
   $i = 0;
   $x = 0;
   $d = 0;
   while ($fname[$i] != '.') {
      $d = $fname[$i];
      $x = $x * 10 + $d;
      $i++;
   }
   return $x;
}

function pera($st) {
    $X = '';
    for($i=0; $i<strlen($st); $i++) {
        if (ord($st[$i]) == 13 && ord($st[$i + 1]) == 10) {
            $X .= PHP_EOL;
            $i++;
        }
        else {
            $X .= $st[$i];
        }
    }
    return $X;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testcases</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <?php include 'nav_bar.php'; ?>
    <h2 class="text-center text-success mt-5"><?php echo $tit; ?></h2>
    <div class="container-fluid">
        <nav class="mx-5 prb_info_tab">
            <div class="row p-2 shadow-lg rounded bg-light text-center justify-content-center mt-5 mb-5">
                <a class="col-12 my-1 col-lg-3 mx-2 my-lg-0 nav-link" href="details.php?id=<?php echo $pid; ?>" role="tab"><b>Details</b></a>
                <a class="col-12 my-1 col-lg-3 mx-2 my-lg-0 nav-link tab_active" href="testcases.php?id=<?php echo $pid; ?>" role="tab"><b>Testcases</b></a>
            </div>
        </nav>
        <div class="mt-5 mx-lg-5 text-center">
            <p class="alert alert-warning text-left">To set test cases, you have to paste your judging solution for this problem. We will run the code to generate the output as opposed to the input you entered. Use our <a href="../../codeground">native code editor</a> to test and run code. Note that, you can still make further changes and updates to the test case.</p>
            <textarea class="w-100 form-control" id="usr_sol" rows="15"><?php echo $saved_code; ?></textarea>
            <div class="text-left mt-3">
                <div class="row">
                    <div class="col-6">
                        <button class="btn btn-success font-weight-bold" id="sol_save">Save</button>
                    </div>
                    <div class="col-6">
                        <select class="form-control bg-dark text-white" id="sol_lang">
                            <option value="C" <?php if ($saved_lang == 'C') { echo 'selected'; } ?>>C</option>
                            <option value="C++" <?php if ($saved_lang == 'C++') { echo 'selected'; } ?>>C++</option>
                            <option value="Java" <?php if ($saved_lang == 'Java') { echo 'selected'; } ?>>Java</option>
                            <option value="Python" <?php if ($saved_lang == 'Python') { echo 'selected'; } ?>>Python</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="shadow-lg bg-white rounded my-5 p-3 mx-lg-5 px-lg-5">
            <?php
            $inps = scandir('../../uploads/user/testcases/'.$pid.'/input');
            $outs = scandir('../../uploads/user/testcases/'.$pid.'/output');
            ?>

            <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                <table class="table table-sm rounded">
                    <tbody>
                        <?php for ($i = 2; $i < count($inps); $i++) { ?>
                        <tr>
                            <td><b>Testcase <?php echo $i - 2; ?></b></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary editbtn" data-toggle="modal" data-target="#edittest" sno="<?php echo $i - 2; ?>" data-id="<?php echo $inps[$i]; ?>"><i class="fas fa-eye"></i></button>  
                            </td>
                            <td>
                                <input type="checkbox" class="form-check-input" name="sample_test[]" value="<?php echo $inps[$i]; ?>" <?php if (in_array($inps[$i], $samp_tst)) {echo 'checked="checked"';} ?>>
                                <label>Add as sample</label>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger dltbtn" data-toggle="modal" data-target="#dlttest" data-id="<?php echo $inps[$i]; ?>"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div>
                    <button type="submit" class="btn btn-success" name="save_tst">Save changes</button>
                </div>
                <div class="float-right">
                    <button type="button" class="btn btn-lg btn-success rounded-circle" data-toggle="modal" data-target="#addtest"><i class="fas fa-plus"></i></button>
                </div>
            </form>
        </div>
        
        <div class="modal fade" data-backdrop="static" id="addtest" tabindex="-1" role="dialog" aria-labelledby="addtestLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-body">
                <div class="row">
                    <div class="col-11"><h3 class="text-center mb-3"><b>Add a new testcase</b></h3></div>
                    <div class="col-1 text-right">
                        <a href="javascript:void(0)" class="text-danger" data-dismiss="modal"><b><i class="fas fa-times"></i></b></a>
                    </div>
                </div>
                <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                    <div class="form-group">
                        <label><b>Write the input:</b></label>
                        <textarea name="tc_inp" class="form-control mb-2" id="tc_inp" rows="7" required></textarea>
                    </div>
                    <div class="form-group">
                        <label><b>Write the output:</b></label>
                        <textarea name="tc_out" class="form-control mb-2" rows="7" id="gen_out" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <button id="gen_out_btn" class="btn btn-primary font-weight-bold">Generate Output</button>
                            <span class="ml-3 gen_msg shadow shadow-lg p-1"></span>
                        </div>
                        <div class="col-6 text-right">
                            <button type="submit" name="addtst" class="btn btn-secondary" id="addtest_btn" disabled><b>Add</b></button>
                        </div>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" data-backdrop="static" id="edittest" tabindex="-1" role="dialog" aria-labelledby="addtestLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body xyz">
                
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" data-backdrop="static" id="dlttest" tabindex="-1" role="dialog" aria-labelledby="addtestLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body abc">
                
                    </div>
                </div>
            </div>
        </div>

        <?php
        if(isset($_POST['addtst'])) {

            $tc_inp = $_POST['tc_inp'];
            $tc_out = pera($_POST['tc_out']);
            
            $dir = '../../uploads/user/testcases/'.$pid.'/input';
            $last_file = '' . get_last($dir) + 1;

            shell_exec('echo> ../../uploads/user/testcases/'.$pid.'/input/'.$last_file.'.txt');
            shell_exec('echo> ../../uploads/user/testcases/'.$pid.'/output/'.$last_file.'.txt');
            file_put_contents('../../uploads/user/testcases/'.$pid.'/input/'.$last_file.'.txt', $tc_inp);
            file_put_contents('../../uploads/user/testcases/'.$pid.'/output/'.$last_file.'.txt', $tc_out);
            echo '<script>
                if (window.history.replaceState) {
                    window.history.replaceState(null, null, window.location.href);
                }
                alert("Testcase added successfully!");
                window.location.reload();
            </script>';
        }

        if(isset($_POST['save_tst'])) {
            $tst_str = '';
            foreach ($_POST['sample_test'] as $k) {
                $tst_str = $tst_str . $k . ' ';
            }
            $tst_str = trim($tst_str);
            $qry = "UPDATE Problem SET Sample_Test = '{$tst_str}' WHERE Id = '{$pid}';";
            mysqli_query($con, $qry);
            echo '<script>
                if (window.history.replaceState) {
                    window.history.replaceState(null, null, window.location.href);
                }
                alert("Changes saved successfully!");
                window.location.reload();
            </script>';
        }
        ?>
    
        <?php include '../../footer.php'; ?>
    </div>
    
    <script src="../../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../../js/bootstrap.bundle.js" type="text/javascript"></script>
    <script>
        function save_code_fun() {
            $("#sol_save").text('saving...');
            $("#sol_save").removeClass('btn-success');
            $("#sol_save").addClass('btn-secondary');
            code = $('#usr_sol').val();
            lang = $('#sol_lang').val();

            console.log('code: ', code);
            console.log('lang: ', lang);

            $.ajax({
                url: "save_code.php",
                method: "POST",
                data: {
                    pid: "<?php echo $pid; ?>",
                    code: code,
                    lang : lang
                },
                success: function() {
                    $("#sol_save").text('Save');
                    $("#sol_save").removeClass('btn-secondary');
                    $("#sol_save").addClass('btn-success');
                }
            });
        }
        $(document).ready(function() {
            $("#gen_out_btn").click(function() {
                save_code_fun();
                code = $('#usr_sol').val();
                lang = $('#sol_lang').val();
                input = $('#tc_inp').val();

                $('#gen_out_btn').text('Generating...');
                $('#gen_out').val('');
                //console.log('code: ', code);
                console.log('lang: ', lang);
                console.log('inp: ', input);

                $.ajax({
                    url: "generator/compiler.php",
                    method: "POST",
                    data: {
                        code: code,
                        lang : lang,
                        input: input
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        $('#gen_out_btn').text('Generated');
                        $('.gen_msg').text(response.msg);
                        if (response.msg == 'Success') {
                            $('.gen_msg').addClass('text-success');
                            $('.gen_msg').removeClass('text-danger');
                            $('#gen_out').val(response.output);
                            $('#addtest_btn').attr('disabled', false);
                            $('#addtest_btn').removeClass('btn-secondary');
                            $('#addtest_btn').addClass('btn-success');
                        }
                        else {
                            $('.gen_msg').addClass('text-danger');
                            $('.gen_msg').addClass('text-success');
                            $('#addtest_btn').attr('disabled', true);
                            $('#addtest_btn').addClass('btn-secondary');
                            $('#addtest_btn').removeClass('btn-success');
                        }
                        console.log('msg: ', response.msg);
                        console.log('output: ', response.output);
                    }
                });
            });
            $("#sol_save").click(save_code_fun);
            $(".editbtn").click(function() {
                x = $(this).attr('data-id');
                console.log('tcid: ', x);
                y = $(this).attr('sno');

                $.ajax({
                    url: "show_edit_testcase.php",
                    method: "POST",
                    data: {
                        pid: "<?php echo $pid; ?>",
                        sno: y,
                        tcid : x
                    },
                    success: function(response) {
                        $(".xyz").html(response);
                    }
                });
            });
            $(".dltbtn").click(function() {
                x = $(this).attr('data-id');

                $.ajax({
                    url: "delete_testcase.php",
                    method: "POST",
                    data: {
                        pid: "<?php echo $pid; ?>",
                        tcid : x
                    },
                    success: function(response) {
                        $(".abc").html(response);
                    }
                });
            });
        });
    </script>

</body>

</html>