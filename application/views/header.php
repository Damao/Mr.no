<!DOCTYPE HTML>
<html lang="zh-CN"<?php if($is_mobile){echo ' class="is_mobile"';}?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Mr. NO</title>
    <link rel="stylesheet" href="/f2e/style.css?20121120">
	<script type="text/javascript" src="/f2e/jquery.js"></script>
	<script type="text/javascript" src="/f2e/fileuploader.min.js"></script>
    <?php if($is_mobile){ ?>
    <script type="text/javascript">
        window.onload = function(){
            setTimeout(scrollTo,0,0,0);
        }
    </script>
    <?php } ?>
</head>
<body>
<header class="lay_header">
	<div class="lay_page_width">
		<h1><a href="/" class="logo">Mr.NO</a></h1>
		<div class="lesd">ecd 生活电商</div>
	</div>
</header>
<div class="lay_page_container">
	<div class="lay_page_width">