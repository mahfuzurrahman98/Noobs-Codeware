<?php

include '../connection.php';
include 'security.php';

$unm = $_SESSION["Username"];
$qry = "SELECT * FROM IDE WHERE _user = '{$unm}';";
$res = mysqli_query($con, $qry) or die("Query Failed!");

while ($row = mysqli_fetch_assoc($res)) {
    $prev_lang = $row['Language'];
    $prev_code = $row['Source_Code'];
    $prev_inp = $row['Input'];
    $prev_tab = $row['Tab_Width'];
    $prev_thm = $row['Theme'];
    $prev_fnt = $row['Font_Size'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codeground</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="style.css">
    <style>
        #inp {
            color: green;
            background: black;
        }
        select.form-control {
            -moz-appearance: none;
            -webkit-appearance: none;
            appearance: none;
        }
        .fub {
            font-family: Ubuntu;
        }
    </style>
</head>

<body>
    <input type="hidden" id="prev_lang" value="<?php echo $prev_lang; ?>">
    <textarea id="prev_code" style="display: none;"><?php echo $prev_code; ?></textarea>
    <input type="hidden" id="prev_inp" value="<?php echo $prev_inp; ?>">
    <input type="hidden" id="prev_thm" value="<?php echo $prev_thm; ?>">
    <input type="hidden" id="prev_fnt" value="<?php echo $prev_fnt; ?>">
    <input type="hidden" id="prev_tab" value="<?php echo $prev_tab; ?>">

    <div class="container-fluid" style="height: 100vh;">
        <div class="row">
            <div class="col-12 col-lg-8 mt-2">
                <div id="editor" style="height: 97vh; max-height: 97vh;"></div>
            </div>
            <div class="fub col-12 col-lg-4 mt-1 pl-2 pl-lg-0" style="height: 97; max-height: 97vh;">
                <div class="row mt-2 mb-3 mb-lg-1" style="max-height: 5vh;">
                    <div class="col-4">
                        <button class="btn btn-success btn-sm rounded-pill" data-toggle="tooltip" data-placement="right" title="Compile & Run(F9)" onclick="executeCode()"><b><i class="far fa-play-circle"></i> Run</b></button>
                    </div>
                    <div class="col-4 mx-auto">
                        <div class="form-group">
                            <select class="rounded-pill bg-dark form-control form-control-sm text-white" id="languages" class="languages" style="text-align-last: center;" onchange="changeLanguage()">
                                <option <?php if ($prev_lang == 'C') {echo 'selected';} ?> value="C">C</option>
                                <option <?php if ($prev_lang == 'C++') {echo 'selected';} ?> value="C++">C++</option>
                                <option <?php if ($prev_lang == 'Java') {echo 'selected';} ?> value="Java">Java</option>
                                <option <?php if ($prev_lang == 'Python') {echo 'selected';} ?> value="Python">Python</option>
                                <option <?php if ($prev_lang == 'Php') {echo 'selected';} ?> value="Php">Php</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4 text-right">
                        <button class="mr-1 btn btn-primary btn-sm" data-toggle="tooltip" data-placement="right" title="Save to my device" id="save"><i class="far fa-save"></i></button>
                        <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#setting"><i class="fas fa-tools"></i></button>
                    </div>
                </div>
                <div class="p-0 shadow shadow-lg bg-light rounded overflow-auto" style="height: 60vh; max-height: 60vh;">
                    <div class="output pl-3 pt-3">
                        <h6 class = "text-danger"><b>Not Compiled Yet!</b></h6>
                    </div>
                </div>
                <div class="mt-2" style="height: 25vh; max-height: 25vh;">
                    <l<abel><b>Stdin:</b></abel></label>
                    <textarea id="inp" class="form-control" rows="7"><?php echo $prev_inp; ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="fub modal fade"  id="setting" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Settings</b></h5>
                    <button type="button" class="btn btn-sm" data-dismiss="modal" >
                    <b class="h5"><i class="fas fa-times"></i></b>
                    </button>
                </div>
                <div class="modal-body xyz" style="border-radius: 10px;">
                    <div class="form-group form-inline">
                        <label><b>Font Size:</b></label>
                        <select class="form-control form-control-sm ml-auto" id="fnt" onchange="changeFont()">
                            <?php for ($i = 12; $i <= 36 ; $i += 2) {
                                $sel = '';
                                if ($prev_fnt == $i) {
                                    $sel = 'selected';
                                }
                                ?>
                                <option <?php echo $sel; ?> value="<?php echo $i; ?>"><?php echo $i; ?>px</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group form-inline">
                        <label><b>Editor Theme:</b></label>
                        <select  class="form-control form-control-sm ml-auto" id="thm" onchange="changeTheme()">
                            <optgroup label="Light">
                                <option <?php if ($prev_thm == 'xcode') {echo 'selected';} ?> value="xcode">Xcode</option>
                                <option <?php if ($prev_thm == 'textmate') {echo 'selected';} ?> value="textmate">Textmate</option>
                                <option <?php if ($prev_thm == 'kuroir') {echo 'selected';} ?> value="kuroir">Kuroir</option>
                                <option <?php if ($prev_thm == 'crimson_editor') {echo 'selected';} ?> value="crimson_editor">Crimson</option>
                                <option <?php if ($prev_thm == 'solarized_light') {echo 'selected';} ?> value="solarized_light">Solarized</option>
                            </optgroup>
                            <optgroup label="Dark">
                                <option <?php if ($prev_thm == 'monokai') {echo 'selected';} ?> value="monokai">Monokai</option>
                                <option <?php if ($prev_thm == 'gob') {echo 'selected';} ?> value="gob">Gob</option>
                                <option <?php if ($prev_thm == 'cobalt') {echo 'selected';} ?> value="cobalt">Cobalt</option>
                                <option <?php if ($prev_thm == 'merbivore_soft') {echo 'selected';} ?> value="merbivore_soft">Merbivore Soft</option>
                                <option <?php if ($prev_thm == 'gruvbox') {echo 'selected';} ?> value="gruvbox">Gruvbox</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group form-inline">
                        <label><b>Tab Width:</b></label>
                        <select class="form-control form-control-sm ml-auto" id="tab" onchange="changeTab()">
                            <?php for ($i = 2; $i <= 8 ; $i *= 2) {
                                $sel = '';
                                if ($prev_tab == $i) {
                                    $sel = 'selected';
                                }
                                ?>
                                <option <?php echo $sel; ?> value="<?php echo $i; ?>"><?php echo $i; ?> spaces</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="modal-footer my-0">
                        <div class="text-right"><button type="button" class="btn btn-success" onclick="setCurrentOptions()">Save Changes</button></div>
                    </div>
                </div>
            </div>
        
        </div>
    </div>

    <script src="js/ide.js"></script>
    <script src="js/lib/ace.js"></script>
    <script src="js/lib/ext-language_tools.js"></script>
    <script src="../js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="../js/bootstrap.bundle.js" type="text/javascript"></script>
    <!-- <script src="../js/nav_bar.js" type="text/javascript"></script> -->
</body>

</html>