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
        <div class="col-8 form-group">
            <label><b><i class="fas fa-search"></i> Title:</b></label>
            <input type="text" id="tt" class="form-control form-control-sm" placeholder="Enter contest title" onkeyup="filterData()">
        </div>
        <div class="col-4 form-group">
            <label><b><i class="fas fa-search"></i> Status:</b></label>
            <select id="st" class="form-control form-control-sm" onchange="filterData()">
                <option value="%">All</option>
                <option value="Featured">Featured</option>
                <option value="Running">Running</option>
                <option value="Ended"><span class="text-danger">Ended</span></option>
            </select>
        </div>
    </form>

    <table class="table table-hover justify-content-center bg-light rounded">
        <thead>
            <tr class="">
                <td><b>Title</b></td>
                <td><b>Starts</b></td>
                <td><b>Status</b></td>
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
    <div class="modal fade" data-keyboard="false" data-backdrop="static" id="dlt_prb" tabindex="-1"
        role="dialog" aria-labelledby="upd_updinfoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content p-3">
                <div class="modal-body text-center">
                    Are you sure want to delete this problem?
                </div>
                <div class="row px-2 mt-2">
                    <div class="col-6"><button class="btn btn-danger" onclick="del()">Yes</button></div>
                    <div class="col-6 text-right"><button class="btn btn-success" data-dismiss="modal" aria-label="Close">No</button></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../js/jquery-3.6.0.js" type="text/javascript"></script>
<script>
    $(document).ready(function(){
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
        $.ajax({
            url: "load_cont.php",
            method: "POST",
            data: {
                tit: $("#tt").val(),
                stat: $("#st").val(),
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
                     console.log('len: ' + response.length);
                //     $("#Next").attr('class', 'page-item');
                // }
            }
        });
    }
</script>
