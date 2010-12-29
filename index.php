<!doctype html> 
<html> 
<head> 
<meta charset="utf-8" /> 
<link href="assets/css/fileuploader.css" rel="stylesheet" type="text/css">	
</head>
<body>

	<div id="file-uploader">		
		<noscript>			
			<p>Please enable JavaScript to use file uploader.</p>
			<!-- or put a simple form for upload here -->
		</noscript>         
	</div>

    <script src="assets/javascript/fileuploader.js"></script>
    <script>        
        function createUploader(){            
            var uploader = new qq.FileUploader({
                debug: true,
                //action: 'compiler/do-nothing.htm',
                action: 'compiler/',
                element: document.getElementById('file-uploader'),
                allowedExtensions: ['js', 'css'],
                sizeLimit: 100 * 10000, // 1MB
                fileParam: 'upload_file',
                onComplete: function(id, fileName, responseJSON){
                    location.href = responseJSON.url;
                },
                messages: {
                    typeError: "抱歉，只允许上传 Javascript、CSS 文件",
                    sizeError: "{file} 太大了, 文件容量请控制在 {sizeLimit} 之内",
                   emptyError: "文件 {file} 似乎是空文件"
                }
            });           
        }
        
        // in your app create uploader as soon as the DOM is ready
        // don't wait for the window to load  
        window.onload = createUploader;     
    </script>    
</body>
</html>
<?php

/*
<form action="compiler/" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <p><input type="file" name="upload_file" />
    <input type="submit" value="Upload" /></p>
</form>
 */
// vim: set et sw=4 ts=4 sts=4 ft=html fdm=marker ff=unix fenc=utf8 nobomb:
