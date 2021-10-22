<?php 
if (!defined('noob')) {
    exit('<h1>Invalid page request</h1>');
}
?>
<div class="fub">
    <div class="shadow shadow-lg p-3 bg-light mb-4 prb_br">
        <h5><b>Statement</b></h5>
        <?php echo $stat; ?>
    </div>
    <div class="shadow shadow-lg p-3 bg-light mb-4 prb_br">
        <h5><b>Constraints</b></h5>
        <?php echo $cons; ?>
    </div>
    <div class="shadow shadow-lg p-3 bg-light mb-4 prb_br">
        <h5><b>Input Format</b></h5>
        <?php echo $ipf; ?>
    </div>
    <div class="shadow shadow-lg p-3 bg-light mb-4 prb_br">
        <h5><b>Output Format</b></h5>
        <?php echo $outf; ?>
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
                    <td><?php echo nl2br(file_get_contents('../uploads/admin/testcases/'.$id.'/input/'.$samp_tst[$i])); ?></td>
                    <td><?php echo nl2br(file_get_contents('../uploads/admin/testcases/'.$id.'/output/'.$samp_tst[$i])); ?></td>
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

    <div class="mb-5">
        <span class=""><b>Problem Tags:</b></span>
        <?php
            $tags = explode(' ', $tags); 
            foreach ($tags as $tg) {
                echo '<span class="mx-1 text-success shadow shadow-lg p-1 bg-light rounded">'.$tg.'</span>';
            }
        ?>
    </div>
</div>