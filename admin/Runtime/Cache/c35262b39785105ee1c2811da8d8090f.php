<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="height:100%;width:100%;">
<head><title>Admin登录--糗星人网站</title>
<meta charset="utf-8" />
<script type="text/javascript" src="__PUBLIC__/public/jquery/jquery-1.11.0.js"></script>	
<link rel="stylesheet" type="text/css" href="<?php echo (__ROOT__); echo (substr(THEME_PATH,1)); ?>public/css/admin.css" />
</head>

<body style="background:#4B7293;height:100%;width:100%;">
	<!-- 100% 全部全部加上中间登录页 -->
	<!-- <div class="login">
		<div class="trans_border">
			<form action="__GROUP__/login/login" method="post" id="login_form">
				<table class="login_table" cellpadding="0" cellspacing="0" width="100%">
					<tr><td colspan="3" height="85" style="text-align:center;"><img width="40" src="__PUBLIC__/user_bg/admin_logo.png" />　　<img height="40" src="__PUBLIC__/user_bg/logo_text.png" /></td></tr>
					<tr><th height="40" width="80">用户名：</th><td width="262"><input type="text" placeholder="管理员帐号" name="user_name" value="" /></td><td><span class="red user_error"></span></td></tr>
					<tr><th height="40">密　码：</th><td><input type="password" name="password" value="" /></td><td><span class="red pass_error"></span></td></tr>
					<tr><td height="40"></td><td><input type="submit" class="bottom" value="登　录" /></td><td><span class="red submit_error"></span></td></tr>
					<tr><td colspan="3"></td></tr>
				</table>
			</form>
		</div>
	</div> -->
	<div id="login_form" class="login_box">
		<div class="tishi"><span>后台样式不兼容IE8及以下版本，支持 firefox 25+，chrome或chrome 内核浏览器</span></div>
		<div class="login_iptbox">
			<form action="__GROUP__/login/login" method="post">
			<input value="" type="submit" class="login_tj_btn" />
			<input name="user_name" type="text" class="ipt" value="" />
			<input name="password" type="password" class="ipt" value="" />
			</form>
		</div>
		<div class="error"><span class="red submit_error"></span></div>
	</div>
</body>
</html>

<script>
$(function(){
	
	$("[name=user_name]").focus();
	
	$("#login_form").submit(function(e){
		var user_name = $("[name=user_name]").val();
		var password = $("[name=password]").val();
		if(user_name == '' || user_name == null){
			//$('.user_error').text("用户名不能为空").animate({'opacity':'0.4'},3000,function(){$(this).text('');});
			$('.submit_error').text("用户名不能为空").animate({"opacity":"1"},3000,function(){$(this).text('');});
			$("[name=user_name]").focus();
			return false;
		}
		if(password == '' || password == null){
			//$('.pass_error').text("密码不能为空").animate({'opacity':'0.4'},3000,function(){$(this).text('');});
			$('.submit_error').text("密码不能为空").animate({"opacity":"1"},3000,function(){$(this).text('');});
			$("[name=password]").focus();
			return false;
		}
		
		$.post('__GROUP__/login/login',{user_name:user_name,password:password},function(msg){
			if(msg.status == 1){
				$(".submit_error").text(msg.info+'-等待跳转...');
				location.reload();
			}else if(msg.status == 2){
				$(".submit_error").text(msg.info);
			}else{
				$(".submit_error").text(msg.info);
			}
			return false;
		});
		return false;
	});
	
});
</script>