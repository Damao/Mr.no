<!DOCTYPE HTML>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>Mr. no</title>
</head>
<body>
<?php
/*echo $task_timestamp ."<br>";
echo $file_type ."<br>";
echo $task_area ."<br>";
echo $task_directive ."<br>";
echo $result_device ."<br>";
*/?>
<img src="/mrno/upload/<?php echo $task_id .'.'. $file_type; ?>" alt="">
<form action="../submit/<?php echo $task_id; ?>" method="post">
    <input type="text" value="{w:1,h:1,l:1,t:1}" name="result_area">
    <input type="text" value="1" name="result_success">
    <input type="text" value="15" name="result_stay_time">
    <input type="submit">

</form>
</body>
</html>