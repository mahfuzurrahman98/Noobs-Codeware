<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>aa</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="archive" checked-data-toggle="toggle" data-on="show" data-off="hide" style="color: green; width: 5px;">
            <label class="custom-control-label" id="archive" for="archive" value="hide">Show in archive</label>
        </div>

    </div>
        
    <script src="js/jquery-3.6.0.js" type="text/javascript"></script>
    <script src="js/bootstrap.bundle.js" type="text/javascript"></script>
</body>

</html>

<script>
    $(document).ready(function() {
        $('#archive').change(function() {
            if ($(this).prop('checked')) {
                $('#archive').val("show");
                $('label#archive').text('Hide from archive');
            }
            else {
                $('#archive').val("hide");
                $('label#archive').text('Show in archive');
            }
            console.log($('#archive').val());
        });
    });
</script>