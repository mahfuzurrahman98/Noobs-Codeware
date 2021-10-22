var editor;

window.onload = function() {
    editor = ace.edit("editor");
    editor.getSession().setValue($('#prev_code').val());

    var prv_lng = $('#prev_lang').val();
    if (prv_lng == 'C' || prv_lng == 'C++') {
        prv_lng = 'c_cpp';
    }
    else if (prv_lng == 'Java') {
        prv_lng = 'java';
    }
    else {
        prv_lng = 'python';
    }

    editor.setOptions({
        enableBasicAutocompletion: true,
        enableLiveAutocompletion: true,
        enableSnippets: true,
        fontSize: parseInt($('#prev_fnt').val()),
        fontFamily: '',
        theme: 'ace/theme/'+$('#prev_thm').val(),
        tabSize: parseInt($('#prev_tab').val()),
        mode: 'ace/mode/'+prv_lng
    });
}

function changeLanguage() {
    var language = $("#languages").val();
    console.log('Language: ', language);
    if (language == 'C' || language == 'C++') {
        editor.setOptions({mode: 'ace/mode/c_cpp'});
    }
    else if (language == 'Java') {
        editor.setOptions({mode: 'ace/mode/java'});
    }
    else if (language == 'Python') {
        editor.setOptions({mode: 'ace/mode/python'});
    }
    else if (language == 'Php') {
        editor.setOptions({mode: 'ace/mode/php'});
    }
    else if (language == 'Javascript') {
        editor.setOptions({mode: 'ace/mode/javascript'});
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

function changeTab() {
    var cur_tab = $("#tab").val();
    editor.setOptions({tabSize: cur_tab});
}

function executeCode() {
    $(".output").html('Processing....');
    $.ajax({
        url: "compiler.php",
        method: "POST",
        data: {
            language: $("#languages").val(),
            input: $("#inp").val(),
            code: editor.getSession().getValue()
        },
        success: function(response) {
            $(".output").html(response);
        }
    });
    setCurrentOptions();
}

function download(filename, text) {
    var element = document.createElement('a');
    element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
    element.setAttribute('download', filename);

    element.style.display = 'none';
    document.body.appendChild(element);
    element.click();
    document.body.removeChild(element);
}

function saveCode() {
    var text = editor.getSession().getValue();
    var lang = $("#languages").val();
    var ex = '';
    if (lang == 'C') { ex = 'c';}
    else if (lang == 'C++') { ex = 'cpp';}
    else if (lang == 'Java') { ex = 'java';}
    else if (lang == 'Python') { ex = 'py';}
    else if (lang == 'Php') { ex = 'php';}
    else if (lang == 'Javascript') { ex = 'js';}
    var filename = "code."+ex;
    download(filename, text);
}

function toggleFullscreen() {
    console.log('toggleFullscreen');
    if ($('.nb').hasClass('d-none')) { //hidden, show now
        $('.nb').removeClass('d-none');
        $('#tfs').html('<i class="fas fa-expand"></i>');
    }
    else { //shown, hide now
        $('.nb').addClass('d-none');
        $('#tfs').html('<i class="fas fa-compress"></i>');
    }
}

function setCurrentOptions() {
    $.ajax({
        url: "set_cur.php",
        method: "POST",
        data: {
            lang: $("#languages").val(),
            code: editor.getSession().getValue(),
            input: $("#inp").val(),
            theme: $("#thm").val(),
            font: $("#fnt").val(),
            tab: $("#tab").val()
        },
        success: function(response) {
            console.log('Saved');
        }
    });
}

window.addEventListener('keydown', (e) => {
    console.log(e.key);
    if (e.key == 'F9') {
        e.preventDefault();
        executeCode();
    }
});