<div class = "shadow-lg p-3 bg-light rounded">
    <p class="show_warn shadow shadow-lg alert alert-danger rounded d-none"></p>

    <label><b>Title:</b></label>
    <input type="text" class="form-control" id="tit" placeholder="Enter the title">

    <div class="row">
        <div class="col-6">
            <label class="mt-3"><b>Start Time:</b></label>
            <input type="datetime-local" class="form-control" id="stym">
        </div>
        <div class="col-6">
            <label class="mt-3"><b>End Time:</b></label>
            <input type="datetime-local" class="form-control" id="etym">
        </div>
    </div>

    <label class="mt-3"><b>Judges:</b><span class="text-muted">(In case of multiple judges, separate using forward slash /)</span></label>
    <textarea class="form-control" id="judges" placeholder="E.g. Mahfuz/Arif/Rahman"></textarea>

    <label class="mt-3"><b>Allowed contestants:</b><span class="text-muted">(Separate usernames using forward slash /)</span></label>
    <textarea class="form-control" id="contestants" placeholder="E.g. Mahfuz/Arif/Rahman"></textarea>

    <div class="text-center mt-3">
        <button class="btn btn-success" data-toggle="modal" data-target="#addtest" onclick="addData()"><b>Create</b></button>
    </div>
</div>


<script>
    function addData() {
        console.log('added........');
        $.ajax({
            url: "contest/set.php",
            method: "POST",
            data: {
                title: $('#tit').val(),
                start: $('#stym').val(),
                end: $('#etym').val(),
                judge: $('#judges').val(),
                contestant: $('#contestants').val(),
            },
            success: function(response) {
                $('.show_warn').removeClass('d-none');
                $('.show_warn').addClass('d-block');
                $('.show_warn').html(response);
            }
        });
    }
</script>