<div class = "shadow-lg p-3 bg-light rounded">
    <p class="show_warn shadow shadow-lg alert alert-danger rounded d-none"></p>

    <label><b>Title:</b></label>
    <input type="text" class="form-control" id="tit" placeholder="Enter the title">

    <label class="mt-3"><b>Difficulty:</b></label>
    <select class="form-control" id="dif">
        <option value="Simple">Simple</option>
        <option value="Easy">Easy</option>
        <option value="Medium">Medium</option>
        <option value="Moderate">Moderate</option>
        <option value="Hard">Hard</option>
    </select>

    <label class="mt-3"><b>Tags:</b></label><br>
    <select id="tgs" class="form-control mul-select" multiple="true" style="width:100%;">
        <?php include '../tags.php'; ?>
    </select>

    <div class="text-center mt-3">
        <button class="btn btn-success" data-toggle="modal" data-target="#addtest" onclick="addData()"><b>Create</b></button>
    </div>
</div>

<script>
    var tag_arr_js = [''];
    $(document).ready(function(){
        $(".mul-select").select2({
            placeholder: "Add Tags",
            tokenSeparators: ['/',',',';'," "]
        });
    });
    function addData() {
        console.log('added........');
        tag_arr_js = tag_arr_js.concat($("#tgs").val());
        console.log('tagssss:', tag_arr_js);
        $.ajax({
            url: "problem/set.php",
            method: "POST",
            data: {
                tit: $('#tit').val(),
                dif: $('#dif').val(),
                tags: tag_arr_js
            },
            success: function(response) {
                $('.show_warn').removeClass('d-none');
                $('.show_warn').addClass('d-block');
                $('.show_warn').html(response);
            }
        });
    }
</script>