<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<link rel="Bookmark"   href="__ROOT__/favicon.ico" /> <!-- 收藏夹中的图标 -->
<link rel="shortcut icon" href="__ROOT__/favicon.ico" /> <!-- 地址栏前面的图标 -->
<link rel="icon" href="__ROOT__/animated_favicon.gif" type="image/gif" /> <!-- 动态Icon图标 -->
<script type="text/javascript" src="__PUBLIC__/public/jquery/jquery-1.11.0.js"></script>	
<script type="text/javascript" src="__PUBLIC__/public/jquery/jquery.cookies.2.2.0.js"></script>
<script type="text/javascript" src="__PUBLIC__/public/jquery/lhgdialog.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo (__ROOT__); echo (substr(THEME_PATH,1)); ?>public/css/admin.css" />
<script type="text/javascript" src="<?php echo (__ROOT__); echo (substr(THEME_PATH,1)); ?>public/js/admin.js"></script>
</head>
<body>
	<div class="body">
	
<div class="iframe_user">
	<form action="" method="post">
	<table class="table_add_user" cellpadding="0" cellspacing="1">
		<tr><th colspan="3">添加用户</th></tr>
		<tr><td>邮箱(登录帐号)<span class="red">*</span></td><td><input type="text" name="email" value="<?php echo ($user["email"]); ?>" /></td><td><span class="prompt"></span></td></tr>
		<tr><td>密码<span class="red">*</span></td><td><input type="text" name="password" value="" /></td><td><span class="prompt"></span></td></tr>
		<tr><td>昵称</td><td><input type="text" name="user_name" value="<?php echo ($user["user_name"]); ?>" /></td><td><span class="prompt"></span></td></tr>
		<tr><td></td><td colspan="2"><input class="bottom" style="width:125px;" type="submit" value="保　存" /></td></tr>
	</table>
	</form>
</div>
	</div>
</body>
</html>