<!doctype html> 
<html> 
    <head> 
        <meta charset="utf-8" /> 
        <title>Simple Resource Comilper</title>
        <link href='http://fonts.googleapis.com/css?family=OFL+Sorts+Mill+Goudy+TT' rel='stylesheet' />
        <style>
            <?php
                include "./assets/css/style-min.css";
                include "./assets/css/fileuploader-min.css";
                //<link href="assets/css/style.css" rel="stylesheet" />
                //<link href="assets/css/fileuploader.css" rel="stylesheet" type="text/css">	
            ?>
        </style>
        <link rel="icon" type="image/x-icon" 
            href="http://www.gracecode.com/images/favicon/favicon_16x16.png" type="image/png" /> 
        <link rel="shortcut icon" href="http://www.gracecode.com/images/favicon/favicon_16x16.png" 
                type="image/png" /> 
    </head>
    <body>
        <div id="page">
            <div id="uploader"></div>
            <div id="J_Message" class="message loading">Uploading... <em>50%</em></div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
        <script>
        <?php
            include "./assets/javascript/fileuploader-min.js";
            include "./assets/javascript/compressor-min.js";
        /*
        <script src="assets/javascript/fileuploader.js"></script>
        <script src="assets/javascript/compressor.js"></script>
        //*/
        ?>
        </script>
    </body>
</html>
<?php // vim: set et sw=4 ts=4 sts=4 ft=html fdm=marker ff=unix fenc=utf8 nobomb:
