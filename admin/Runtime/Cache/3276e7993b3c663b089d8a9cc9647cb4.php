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
	
<!-- 宽 100% -->
<div class="iframe_user">
	<table cellpadding="0" cellspacing="1">
		<tr>
			<th>编号</th>
			<th>删</th>
			<th>用户ID</th>
			<th>头像</th>
			<th>昵称</th>
			<th>email(登录帐号)</th>
			<th>性别</th>
			<th>签到信息</th>
			<th>积分</th>
			<th>个人语录</th>
			<th>注册时间</th>
			<th>注册IP</th>
			<th>最后登录时间</th>
			<th>最后登录IP</th>
			<th>登录次数</th>
			<th>操作</th>
		</tr>
		<?php if(is_array($users)): foreach($users as $key=>$user): ?><tr>
			<td class="numbers" width="40"><?php echo ($key+1); ?></td>
			<td class="align_center"><input type="checkbox" name="checkbox" value="<?php echo ($user["user_id"]); ?>" /></td>
			<td><?php echo ($user["user_id"]); ?></td>
			<td><?php if(empty($user["pic"])): ?>无<?php else: ?><img src="<?php echo ($user["pic"]); ?>" height="30" /><?php endif; ?></td>
			<td><?php echo ($user["user_name"]); ?></td>
			<td><?php echo ($user["email"]); ?></td>
			<td><?php if($user["sex"] == 1): ?>男<?php elseif($user["sex"] == -1): ?>女<?php else: ?><font color="#CCC">未填</font><?php endif; ?></td>
			<td><?php echo ($user["sign"]); ?></td>
			<td><?php echo ($user["sign_jifen"]); ?></td>
			<td><?php echo ($user["resume"]); ?></td>
			<td><?php echo ($user["reg_time"]); ?></td>
			<td><?php echo ($user["reg_ip"]); ?></td>
			<td><?php echo ($user["last_log_time"]); ?></td>
			<td><?php echo ($user["last_log_ip"]); ?></td>
			<td><?php echo ($user["logins"]); ?></td>
			<td><a class="edit_user" uid="<?php echo ($user["user_id"]); ?>" href="javascript:;">编辑</a></td>
		</tr><?php endforeach; endif; ?>
		<tr><td></td><td><a href="javascript:;" id="full_check">全选</a><br /><a href="javascript:;" id="double_del">删除</a></td><td colspan="15">
			<!-- //这里分页，等下做成form格式 -->
			<?php echo ($pager); ?>
		</td></tr>
	</table>
</div>

<script>
$(function(){
	full_check({
		clicker : '#full_check',
		selecter : '[name=checkbox]'
	});
	
	double_del({
		clicker : '#double_del',
		selecter : '[name=checkbox]',
		model : 'user',
		field : 'user_id',
		url : '__GROUP__/index/double_del'
	});
	
	y_pager({
		selecter : '.y_pager'
	});
	
	edit_user({
		url : '__GROUP__/user/edit',
		id_attr	: 'uid'
	});
	
});
</script>
	</div>
</body>
</html>