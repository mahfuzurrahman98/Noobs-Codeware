<div class="text-center rounded py-1 px-0">
    <?php foreach ($prb_arr as $key => $value) { ?>
        <button class="prb_btn rounded-pill btn-primary btn-lg mx-3" data-num="<?php echo $key; ?>" data-id="<?php echo $value; ?>">
            <b><?php echo $key ?></b>
        </button>
    <?php } ?>
</div>

<div class="show_problem mt-3">
    
</div>