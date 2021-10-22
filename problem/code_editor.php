<?php
if (!defined('noob')) {
    exit('<h1>Invalid page request</h1>');
}
?>
<div id="editor"></div>

<div class="mt-3 mb-5 fub">
    <div class="row">
        <div class="col-1">
            <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#setting"><i class="fas fa-cog"></i></button>
        </div>
        <div class="col-5 text-left">
            <select class="form-control form-control-sm bg-dark text-white" id="languages" onchange="changeLanguage()">
                <option value="C">C</option>
                <option value="C++">C++</option>
                <option value="Java">Java</option>
                <option value="Python">Python</option>
            </select>
        </div>
        <div class="col-4">
            <button class="mr-1 btn btn-sm btn-secondary" onclick="showHideInput()"data-toggle="tooltip" data-placement="top" title="Toggle input field">Custom</button>

            <button id="run_inp" class="btn btn-sm btn-primary" onclick="customTestRun()" style="display: none;"data-toggle="tooltip" data-placement="top" title="Run on custom input">Run</button>

            <button id="run_test" class="btn btn-sm btn-primary" onclick="sampleTestRun()" style="display: inline-block;"data-toggle="tooltip" data-placement="top" title="Test against sample cases">Test</button>
        </div>
        <div class="col-2 text-right">
            <button class="btn btn-sm btn-success" onclick="submitCode()"data-toggle="tooltip" data-placement="top" title="Submit code">Submit</button>
        </div>
    </div>
    <div class="mt-2" id="custom_inp" style="display: none;">
        <textarea id="inp" class="form-control form-control-sm" style="background-color: black; color: green;" rows="7" placeholder=">"></textarea>
    </div>
    <div id="out_sec" class="mt-3 p-3 shadow-lg bg-light mr-0" style="display: none">
        <div class="output">

        </div>
    </div>
</div>