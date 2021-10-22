<div class="uva_perform mt-3 shadow-lg p-2 bg-white rounded text-center mb-3">
    
    <div class="row mt-3">
        <div class="col-lg-6 text-center">
            <h4>Total submission: <?php echo $nos; ?></h4>
        </div>
        <div class="col-lg-6 text-center">
            <h4>Total accepted: <?php echo $acc; ?></h4>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-lg-2 text-center">
            <b>Acceptance Rate:</b>
        </div>
        <div class="col-lg-8 justify-content-start progress">

            <div class="progress-bar" role="progressbar" style="width: <?php echo $wid; ?>%"
                aria-valuenow="<?php $wid; ?>" aria-valuemin="0" aria-valuemax="100">
                <?php echo $wid . "%"; ?>
            </div>
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
                        $prb = $subs[$i][1] . ". " . $subs[$i][2];
                        $uv_link = "https://onlinejudge.org/index.php?option=com_onlinejudge&Itemid=8&page=show_problem&problem=" . $subs[$i][6];
                    ?>
                    <td> <?php echo ($subs[$i][0]); ?> </td>
                    <td> <?php echo ("<a href='$uv_link' target = 'blank' class='text-primary'>$prb</a>"); ?>
                    </td>
                    <td> <?php echo ($subs[$i][3]); ?> </td>
                    <td> <?php echo ($subs[$i][4]); ?> </td>
                    <td> <?php echo ($subs[$i][5]); ?> </td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>