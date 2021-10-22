let editor;

function init() {
    editor = ace.edit("editor");
    editor.setOptions({
        enableBasicAutocompletion: true,
        enableLiveAutocompletion: true,
        enableSnippets: true,
        fontSize: 18,
        fontFamily: '',
        theme: 'ace/theme/monokai',
        tabSize: 4,
        mode: 'ace/mode/c_cpp'
    });
}

function showHideIde() {
    if($("#ide").css('display') == 'none') { //show ide now
        init();
        $("#desc").attr('class', 'col-12 col-lg-6');
        $("#ide").css('display', 'inline-block');
        $("#ide").attr('class', 'col-12 col-lg-6');
    }
    else { //hide ide now
        $("#desc").attr('class', 'col-12');
        $("#ide").css('display', 'none');
        $("#ide").attr('class', '');
    }
}

function showHideInput() {
    if($("#custom_inp").css('display') == 'none') {
        $("#custom_inp").css('display', 'block');
        $("#run_inp").css('display', 'inline-block');
        $("#run_test").css('display', 'none');
    }
    else {
        $("#custom_inp").css('display', 'none');
        $("#run_inp").css('display', 'none');
        $("#run_test").css('display', 'inline-block');
    }
}

function changeLanguage() {
    var language = $("#languages").val();
    if (language == 'C' || language == 'C++') {
        editor.setOptions({mode: 'ace/mode/c_cpp'});
    }
    else if (language == 'Java') {
        editor.setOptions({mode: 'ace/mode/java'});
    }
}

function changeFont() {
    var fs = parseInt($("#fnt").val());
    editor.setOptions({fontSize: fs});
}

function changeTheme() {
    var cur_thm = $("#thm").val();
    editor.setOptions({theme: 'ace/theme/'+cur_thm});
}

function sampleTestRun() {
    $("#out_sec").css('display', 'block');
    $(".output").html('<img src="../images/processing.gif" width="100px" alt="">Processing')
    $.ajax({
        url: "compiler/sample_test_compiler.php",
        method: "POST",
        data: {
            pid: $("#problem_id").val(),
            language: $("#languages").val(),
            input: $("#inp").val(),
            code: editor.getSession().getValue()
        },
        success: function(response) {
            //console.log(response);
            $(".output").html(response);
        }
    })
}

function customTestRun() {
    $("#out_sec").css('display', 'block');
    $(".output").html('<img src="../images/processing.gif" width="100px" alt="">Processing')
    $.ajax({
        url: "compiler/custom_test_compiler.php",
        method: "POST",
        data: {
            language: $("#languages").val(),
            input: $("#inp").val(),
            code: editor.getSession().getValue()
        },
        success: function(response) {
            //console.log(response);
            $(".output").html(response);
        }
    })
}

function submitCode() {
    //console.log('submit ', $("#contest_id").val(), ' ', $("#problem_id").val(), ' ', $("#problem_tit").val());
    $("#out_sec").css('display', 'block');
    $(".output").html('<img src="../images/processing.gif" width="100px" alt="">Processing')
    $.ajax({
        url: "compiler/verdict_compiler.php",
        method: "POST",
        data: {
            cid: $("#contest_id").val(),
            pid: $("#problem_id").val(),
            ptit: $("#problem_tit").val(),
            language: $("#languages").val(),
            code: editor.getSession().getValue()
        },
        success: function(response) {
            //console.log(response);
            $(".output").html(response);
        }
    })
}