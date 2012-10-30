<!DOCTYPE HTML>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>Mr. no</title>
    <link rel="stylesheet" href="/mrno/f2e/style.css">
    <link href="/mrno/f2e/fileuploader.css" rel="stylesheet" type="text/css">
</head>
<body>
<script type="text/javascript" src="/mrno/f2e/jquery.js"></script>
<script type="text/javascript" src="/mrno/f2e/fileuploader.min.js"></script>
<div id="file-uploader-demo1">
    <noscript>
        <p>Please enable JavaScript to use file uploader.</p>
        <!-- or put a simple form for upload here -->
    </noscript>
</div>
<script>
    function createUploader(){
        var uploader = new qq.FileUploader({
            element: document.getElementById('file-uploader-demo1'),
            action: 'index.php/form/ajaxupload',
            debug: true,
            inputName:"qqfile",
            autoUpload:true,
            allowedExtensions: ['jpg', 'png'],
            forceMultipart:false,
            failedUploadTextDisplay: {
                mode: 'custom',
                maxChars: 40,
                responseProperty: 'error',
                enableTooltip: true
            },
            uploadButtonText:"来一发",
            onComplete: function(id, fileName, responseJSON) {
                if (responseJSON.success) {
                    $('body').append('<img src="uploads/'+responseJSON.task_id+responseJSON.file_type+'" alt="' + fileName + '">');
                    $("#task_id").val(responseJSON.task_id);
                }
            }
        });
    }


    // in your app create uploader as soon as the DOM is ready
    // don't wait for the window to load
    window.onload = createUploader;
</script>
<form action="index.php/form/update" method="post">
    <input type="text" name="task_area" value="{w:1,h:1,l:1,t:1}">
    <input type="text" name="task_directive" value="" placeholder="任务描述">
    <input type="text" value="" id="task_id" name="task_id">
    <input type="submit">
</form>

div.
</body>
</html>