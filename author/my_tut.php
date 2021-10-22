<?php 
if (!defined('noob')) {
    exit('<h1>Invalid page request</h1>');
}
?>

<script>var xy = 1;</script>

<div class="mt-5 mx-lg-5">
    <div class="Filter">
        <div class="row p-2">
            <div class="col-5 form-group">
                <label><b><i class="fas fa-search"></i> Title:</b></label>
                <input type="text" id="tit" class="form-control form-control-sm" placeholder="Tutorial Title" onkeyup="filterData()">
            </div>
            <div class="col-4 form-group">
                <label><b><i class="fas fa-search"></i> Category:</b></label>
                <select class="form-control form-control-sm" id="cat" onchange="filterData()">
                    <option selected value="%">All</option>
                    <option value="Algorithm">Algorithm</option>
                    <option value="Data Structure">Data Structure</option>
                    <option value="Graph Theory">Graph Theory</option>
                    <option value="Dynamic Programming">Dynamic Programming</option>
                    <option value="Greedy">Greedy</option>
                    <option value="Game Theory">Game Theory</option>
                    <option value="OJ Problems Editorial">OJ Problems Editorial</option>
                    <option value="Programming Language">Programming Language</option>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Science & Technology">Science & Technology</option>
                    <option value="Number Theory">Number Theory</option>
                    <option value="Combinatorics">Combinatorics</option>
                    <option value="Geomeatry">Geomeatry</option>
                    <option value="Math">Math</option>
                    <option value="Statistics">Statistics</option>
                    <option value="Numerical Analysis">Numerical Analysis</option>
                    <option value="Tools & Tips">Tools & Tips</option>
                    <option value="Others">Others</option>
                </select>
            </div>
            <div class="col-3 form-group">
                <label><b><i class="fas fa-search"></i> Status:</b></label>
                <select class="form-control form-control-sm" id="st" onchange="filterData()">
                    <option selected value="%">All</option>
                    <option value="Requested">Requested</option>
                    <option value="Approved">Approved</option>
                </select>
            </div>
        </div>
    </div>
    <div class="shadow-lg bg-light p-3 rounded">
        <table class="table table-sm show">
            
        </table>
    </div>
</div>

<div class="my-5 justify-content-center d-flex">
    <ul class="pagination">
        <li id="Prev" class="page-item"><button data-id="prv" class="page-link">Prev</button></li>
        <li><button data-id="1" class="page-link">1</button></li>
        <li><button data-id="2" class="page-link">2</button></li>
        <li><button data-id="3" class="page-link">3</button></li>
        <li><button class="btn btn-light">...</button></li>
        <li id="Next" class="page-item"><button data-id="nxt" class="page-link">Next</button></li>
    </ul>
</div>

<script src="../js/jquery-3.6.0.js" type="text/javascript"></script>
<script>
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

        $(".show").html('<div class="h3 my-5 text-center text-dark">Processing.....</div>');
        $.ajax({
            url: "load_tut.php",
            method: "POST",
            data: {
                title: $("#tit").val(),
                category: $("#cat").val(),
                status: $("#st").val(),
                page: xy
            },
            success: function(response) {
                console.log(response);
                if (response.length < 50) {
                    console.log('len: ' + response.length);
                    $("#Next").attr('class', 'page-item disabled');
                    $(".show").html('<div class="h1 my-5 text-center text-danger">No result found!</div>');
                }
                else {
                    $(".show").html(response)
                    console.log('len: ' + response.length);
                    $("#Next").attr('class', 'page-item');
                }
            }
        })
    }
    $(document).ready(function() {
        loadData();
    });
</script>