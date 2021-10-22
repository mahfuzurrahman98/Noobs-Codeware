<?php
if (!defined('noob')) {
    exit('<h1>Invalid page request</h1>');
}
?>

<script>
    var xy = 1;
    var tag_arr = [];
</script>

<div class="mt-5 mx-lg-5">
    <form class="row p-2">
        <div class="col-4 form-group">
            <label><b><i class="fas fa-search"></i> Title:</b></label>
            <input type="text" id="tt" class="form-control form-control-sm" id="X1" placeholder="Enter problem title" onkeyup="filterData()">
        </div>
        <div class="col-3 form-group">
            <label><b><i class="fas fa-search"></i> Difficulty:</b></label>
            <select id="df" class="form-control form-control-sm" onchange="filterData()">
                <option value="%">All</option>
                <option value="Simple">Simple</option>
                <option value="Easy">Easy</option>
                <option value="Medium">Medium</option>
                <option value="Moderate">Moderate</option>
                <option value="Hard">Hard</option>
            </select>
        </div>
        <div class="col-5 form-group">
            <label><b><i class="fas fa-search"></i> Tags:</b></label>
            <select id="tg" class="form-control form-control-sm mul-select" multiple="true" style="width:100%;" onchange="filterData()">
                <?php include '../tags.php'; ?>
            </select>
        </div>
    </form>

    <table class="table table-hover justify-content-center bg-light rounded">
        <thead>
            <tr class="">
                <td><b>Title</b></td>
                <td><b>Difficulty</b></td>
                <td><b>Author</b></td>
            </tr>
        </thead>
        <tbody class="show">
            
        </tbody>
    </table>

    <div class="mb-5 justify-content-center d-flex">
        <ul class="pagination">
            <li id="Prev" class="page-item"><button data-id="prv" class="page-link">Prev</button></li>
            <li><button data-id="1" class="page-link">1</button></li>
            <li><button data-id="2" class="page-link">2</button></li>
            <li><button data-id="3" class="page-link">3</button></li>
            <li><button class="btn btn-light">...</button></li>
            <li id="Next" class="page-item"><button data-id="nxt" class="page-link">Next</button></li>
        </ul>
    </div>
</div>

<script src="../js/jquery-3.6.0.js" type="text/javascript"></script>
<script src="../js/select2.js" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        $(".mul-select").select2({
            placeholder: "Search and select",
            tokenSeparators: ['/',',',';'," "] 
        });
        loadData();
    });
    $(".page-link").click(function() {
        var z = $(this).attr('data-id');
        if (z == "prv") { xy--; }
        else if (z == "1") { xy = 1; }
        else if (z == "2") { xy = 2; }
        else if (z == "3") { xy = 3; }
        else if (z == "nxt") { xy++; }
        loadData();
    });
    function filterData() {
        xy = 1;
        loadData();
    }
    function loadData() {
        if (xy == 1) {
            $("#Prev").attr('class', 'page-item disabled');
        }
        else {
            $("#Prev").attr('class', 'page-item');
        }

        $(".show").html('Processing.....')
        tg_arr = $("#tg").val();
        tg_arr.push('%');
        $.ajax({
            url: "load_prb.php",
            method: "POST",
            data: {
                title: $("#tt").val(),
                diff: $("#df").val(),
                tags: tg_arr,
                page: xy
            },
            success: function(response) {
                //console.log(title, ' | ', diff, ' | ', tags);
                // if (response.length < 600) {
                //     //console.log('len: ' + response.length);
                //     $("#Next").attr('class', 'page-item disabled');
                //     $(".trow").html('');
                //     $(".show").html('<div class="h1 my-5 text-center text-danger">No result found!</div>');
                // }
                // else {
                     $(".show").html(response)
                     console.log(response);
                     console.log('len: ' + response.length);
                //     $("#Next").attr('class', 'page-item');
                // }
            }
        });
    }
</script>