var end_dt = new Date($('#end_tym_id').val());
var beg_dt = new Date($('#beg_tym_id').val());
var contest_id = $('#contest_id').val();
var problem_id = $('#first_prb_id').val();
var problem_num = "A";

function getRem(beg, end) {
    var t = end - beg;
    var days = Math.floor(t / (1000 * 60 * 60 * 24));
    var hours = Math.floor((t % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((t % (1000 * 60)) / 1000);
    return (days + 'd ' + hours + 'hrs ' + minutes + 'm ' + seconds + 's');
}

function loadProblem(contest_id, problem_num, problem_id) {
    $(".show_problem").html('<div class="my-5 h1 text-center fub">Processing...</div>');
    $.ajax({
        url: "load_problem.php",
        method: "POST",
        data: {
            cid: contest_id,
            pnum: problem_num,
            pid: problem_id
        },
        success: function(response) {
            $('.show_problem').html(response);
        }
    })
}

$(".prb_btn").click(function() {
    problem_num = $(this).attr('data-num');
    problem_id = $(this).attr('data-id');
    loadProblem(contest_id, problem_num, problem_id);
});

function validate() {
    if (new Date() < beg_dt) {
        $('#status').html('Not started yet');
        $('#status').attr('class', 'h4 text-primary');
        $('#show_clock').html('<i class="far fa-clock"></i> Starts in ' + getRem(new Date(), beg_dt));
    }
    else if (new Date() < end_dt) {
        $('#status').html('Running...');
        $('#status').attr('class', 'h4 text-success');
        $('#show_clock').html('<i class="far fa-clock"></i> ' + getRem(new Date(), end_dt) + ' left');
    }
    else {
        $('#status').html('Ended on ' + end_dt);
        $('#status').attr('class', 'h4 text-danger');
        $('.prb_btn').attr('class', 'prb_btn btn-success rounded-pill btn-lg mx-3 my-1');
    }
}
$(document).ready(function() {
    validate();
    setInterval(validate, 1000);
});