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
<div class="iframe_Ip">
	<table cellpadding="0" cellspacing="1">
		<tr>
			<th>编号</th>
			<th>删</th>
			<th>ID</th>
			<th>用户ID</th>
			<th>内容</th>
			<th>添加时间</th>
			<th>添加者IP</th>
			<th>已/未读</th>
			<th>可回复</th>
		</tr>
		<?php if(is_array($datas)): foreach($datas as $key=>$d): ?><tr>
			<td class="numbers" width="40"><?php echo ($key+1); ?></td>
			<td class="align_center"><input type="checkbox" name="checkbox" value="<?php echo ($d["message_id"]); ?>" /></td>
			<td><?php echo ($d["message_id"]); ?></td>
			<td><?php echo ($d["user_id"]); ?></td>
			<td><?php echo ($d["content"]); ?></td>
			<td><?php echo ($d["add_time"]); ?></td>
			<td><?php echo ($d["add_ip"]); ?></td>
			<td><?php if($d["is_read"] == 0): ?>未读<?php else: ?>已读<?php endif; ?></td>
			<td><?php if($d["user_id"] > 1): ?><a class="reply_fankui" uid="<?php echo ($d["user_id"]); ?>" href="javascript:;">回复</a><?php else: ?>不<?php endif; ?></td>
		</tr><?php endforeach; endif; ?>
		<tr><td></td><td><a href="javascript:;" id="full_check">全选</a><br /><a href="javascript:;" id="double_del">删除</a></td>
		<td colspan="7">
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
		model : 'message',
		field : 'message_id',
		url : '__GROUP__/index/double_del'
	});
	
	y_pager({
		selecter : '.y_pager'
	});
	
	reply_fankui({
		selecter : '.reply_fankui',
		url : '__GROUP__/message/replay_fankui'
	});
	
	
});
</script>
	</div>
</body>
</html>