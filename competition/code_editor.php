<div class="row fub">
    <input type="hidden" id="contest_id" value="<?php echo $cid; ?>">
    <input type="hidden" id="problem_id" value="<?php echo $pid; ?>">
    <input type="hidden" id="problem_tit" value="<?php echo $tit ?>">
    <div class="form-group col-4">
        <label><b>Language:</b></label>
        <select class="form-control form-control-sm" id="languages" class="languages" onchange="changeLanguage()">
            <option value="C">C</option>
            <option value="C++">C++</option>
            <option value="Java">Java</option>
            <option value="Python">Python</option>
        </select>
    </div>
    <div class="form-group col-4">
        <label><b>Font:</b></label>
        <select class="form-control form-control-sm" id="fnt" onchange="changeFont()">
            <option value="12">12</option>
            <option value="14">14</option>
            <option value="16">16</option>
            <option selected value="18">18</option>
            <option value="20">20</option>
            <option value="22">22</option>
            <option value="24">24</option>
            <option value="26">26</option>
            <option value="28">28</option>
            <option value="30">30</option>
            <option value="32">32</option>
            <option value="34">34</option>
            <option value="36">36</option>
        </select>
    </div>
    <div class="form-group col-4">
        <label><b>Theme:</b></label>
        <select class="form-control form-control-sm" id="thm" onchange="changeTheme()">
            <optgroup label="Light">
                <option value="xcode">Xcode</option>
                <option value="textmate">Textmate</option>
                <option value="kuroir">Kuroir</option>
                <option value="crimson_editor">Crimson</option>
                <option value="solarized_light">Solarized</option>
            </optgroup>
            <optgroup label="Dark">
                <option selected value="monokai">Monokai</option>
                <option value="gob">Gob</option>
                <option value="cobalt">Cobalt</option>
                <option value="merbivore_soft">Merbivore Soft</option>
                <option value="gruvbox">Gruvbox</option>
            </optgroup>
        </select>
    </div>
</div>
<div id="editor"></div>

<div class="mt-3 ml-1 fub">
    <div class="row">
        <div class="col-8">
            <button class="mr-2 btn btn-sm btn-secondary" onclick="showHideInput()"data-toggle="tooltip" data-placement="top" title="Toggle input field">Custom Input</button>
            <button id="run_inp" class="btn btn-sm btn-primary" onclick="customTestRun()" style="display: none;"data-toggle="tooltip" data-placement="top" title="Run on custom input">Run</button>
            <button id="run_test" class="btn btn-sm btn-primary" onclick="sampleTestRun()" style="display: inline-block;"data-toggle="tooltip" data-placement="top" title="Test against sample cases">Test</button>
        </div>
        <div class="col-4 text-right"><button class="btn btn-sm btn-success" onclick="submitCode()"data-toggle="tooltip" data-placement="top" title="Submit code">Submit</button></div>
    </div>
    <div class="mt-2" id="custom_inp" style="display: none;">
        <textarea id="inp" class="form-control form-control-sm" style="background-color: black; color: green;" rows="7" placeholder=">"></textarea>
    </div>
    <div id="out_sec" class="mt-3 p-3 shadow-lg bg-light mr-0" style="display: none">
        <div class="output">

        </div>
    </div>
</div>