<?php
if (!defined('noob')) {
    exit('<h1>Invalid page request</h1>');
}
if ($No_Accepted == 1) { ?>
    <h2 class="text-center text-danger">No submission is accepted yet</h2>
<?php } else { ?>
    <table class="table table-sm">
        <tbody class="">
            <tr>
                <td><a class="text-warning code_modal" href="javascript:void(0)" data-toggle="modal" data-target="#show_code" data-tag="earliest" data-id=<?php echo $early_sub_id; ?>>Earliest</a></td>
                <td> <?php echo date("Y-m-d H:i", $early_sub_tym); ?></td>
                <td>by <a href="../profile.php?user=<?php echo $early_sub_unm; ?>"><?php echo $early_sub_unm; ?></a></td>
            </tr>
            <tr>
                <td><a class="text-success code_modal" href="javascript:void(0)" data-toggle="modal" data-target="#show_code" data-tag="fastest" data-id=<?php echo $fast_sub_id; ?>>Fastest</a></td>
                <td> <?php echo $fast_tym; ?> sec<span class="text-muted">(time)</span> </td>
                <td>by <a href="../profile.php?user=<?php echo $fast_sub_unm; ?>"><?php echo $fast_sub_unm; ?></a></td>
            </tr>
            <tr>
                <td><a class="text-danger code_modal" href="javascript:void(0)" data-toggle="modal" data-target="#show_code" data-tag="slowest" data-id=<?php echo $slow_sub_id; ?>>Slowest</a></td>
                <td> <?php echo $slow_tym; ?> sec<span class="text-muted">(time)</span> </td>
                <td>by <a href="../profile.php?user=<?php echo $slow_sub_unm; ?>"><?php echo $slow_sub_unm; ?></a></td>
            </tr>
            <tr>
                <td><a class="text-success code_modal" href="javascript:void(0)" data-toggle="modal" data-target="#show_code" data-tag="lightest" data-id=<?php echo $light_sub_id; ?>>Lightest</a></td> 
                <td> <?php echo $light_mem; ?> MB<span class="text-muted">(memory)</span> </td>
                <td>by <a href="../profile.php?user=<?php echo $light_sub_unm; ?>"><?php echo $light_sub_unm; ?></a></td>
            </tr>
            <tr>
                <td><a class="text-danger code_modal" href="javascript:void(0)" data-toggle="modal" data-target="#show_code" data-tag="haviest" data-id=<?php echo $heavy_sub_id; ?>>Heaviest</a></td> 
                <td> <?php echo $heavy_mem; ?> MB<span class="text-muted">(memory)</span> </td> 
                <td>by <a href="../profile.php?user=<?php echo $heavy_sub_unm; ?>"><?php echo $heavy_sub_unm; ?></a></td>
            </tr>
            <tr>
                <td><a class="text-success code_modal" href="javascript:void(0)" data-toggle="modal" data-target="#show_code" data-tag="shortest" data-id=<?php echo $short_sub_id; ?>>Shortest</a></td> 
                <td> <?php echo $short_size; ?> B<span class="text-muted">(source)</span></td> 
                <td>by <a href="../profile.php?user=<?php echo $short_sub_unm; ?>"><?php echo $short_sub_unm; ?></a></td>
            </tr>
            <tr>
                <td><a class="text-danger code_modal" href="javascript:void(0)" data-toggle="modal" data-target="#show_code" data-tag="longest" data-id=<?php echo $long_sub_id; ?>>Longest</a></td>
                <td> <?php echo $long_size; ?> B<span class="text-muted">(source)</span></td> 
                <td>by <a href="../profile.php?user=<?php echo $long_sub_unm; ?>"><?php echo $long_sub_unm; ?></a></td>
            </tr>
        </tbody>
    </table>
<?php } ?>