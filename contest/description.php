<?php
if (!defined('noob')) {
    exit('<h1>Invalid page request</h1>');
}
?>

<div class="fub">
    <div class="shadow shadow-lg p-3 bg-light mb-4 prb_br">
        <h5><b>Statement</b></h5>
        <?php echo nl2br($stat); ?>
    </div>
    <div class="shadow shadow-lg p-3 bg-light mb-4 prb_br">
        <h5><b>Constraints</b></h5>
        <?php echo nl2br($cons); ?>
    </div>
    <div class="shadow shadow-lg p-3 bg-light mb-4 prb_br">
        <h5><b>Input Format</b></h5>
        <?php echo nl2br($ipf); ?>
    </div>
    <div class="shadow shadow-lg p-3 bg-light mb-4 prb_br">
        <h5><b>Output Format</b></h5>
        <?php echo nl2br($outf); ?>
    </div>
    <div class="shadow shadow-lg p-3 bg-light mb-4 prb_br">
        <h5><b>Sample Testcase</b></h5>
        <?php for ($i = 0; $i <count($samp_tst) ; $i++) { ?>
        <table class="table table-bordered border-dark">
            <thead>
                <tr>
                    <td>Sample Input <?php echo $i; ?> </td>
                    <td>Sample Output <?php echo $i; ?> </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo nl2br(file_get_contents('../uploads/admin/testcases/'.$pid.'/input/'.$samp_tst[$i])); ?></td>
                    <td><?php echo nl2br(file_get_contents('../uploads/admin/testcases/'.$pid.'/output/'.$samp_tst[$i])); ?></td>
                </tr>
            </tbody>
        </table>
        <?php } ?>
    </div>

    <?php
    if (!empty($note)) {
    	echo '<div class="shadow p-3 bg-light mb-4 prb_br">';
    	echo '<h5><b>Notes</b></h5>' . $note;
    	echo '</div>';
    }
    ?>
</div>