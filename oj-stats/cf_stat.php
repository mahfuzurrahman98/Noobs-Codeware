<div class="cf_performence my-5 shadow-lg p-2 bg-white rounded text-center mb-3">
    <div class="row my-5">
        <div class="col-lg-6 text-center">
            <h5 class="text-danger">Current rating: <?php echo $usr_rat?> <span class="cf_rr">(max:
                    <?php echo $usr_mxrat?>)</span></h5>
        </div>
        <div class="col-lg-6 text-center">
            <h5 class="text-danger">Current rank: <?php echo $usr_rank?> <span class="cf_rr">(max:
                    <?php echo $usr_mxrank?>)</span></h5>
        </div>
    </div>
    <div>
        <h4 class="mb-3 text-center text-success">Recent 10 Submissions</h4>
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <td><b>Submission</b></td>
                    <td><b>Problem</b></td>
                    <td><b>Verdict</b></td>
                    <td><b>Language</b></td>
                    <td><b>When</b></td>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < 10; $i++) {?>
                <tr>
                    <?php
                        //https://codeforces.com/problemset/problem/1521/E
                        //https://codeforces.com/contest/1/submission/116013258
                        $subm = "https://codeforces.com/contest/" . $cf_subs[$i][1] . "/submission/" . $cf_subs[$i][0];
                        $subm_show = $cf_subs[$i][0];
                        $cf_link = "https://codeforces.com/problemset/problem/" . $cf_subs[$i][1]. '/' . $cf_subs[$i][2];
                        $prb2 = $cf_subs[$i][1] . ' ' . $cf_subs[$i][2] . '. ' . $cf_subs[$i][3];
                        ?>
                    <td> <?php echo ("<a href='$subm' target = 'blank' class='text-primary'>$subm_show</a>"); ?>
                    <td> <?php echo ("<a href='$cf_link' target = 'blank' class='text-primary'>$prb2</a>"); ?>
                    </td>
                    <td> 
                        <?php
                        if ($cf_subs[$i][4] == "OK") {
                            $cf_subs[$i][4] = "Accepted";
                        }
                        echo ($cf_subs[$i][4]); 
                        ?> </td>
                    <td> <?php echo ($cf_subs[$i][5]); ?> </td>
                    <td> <?php echo ($cf_subs[$i][6]); ?> </td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>