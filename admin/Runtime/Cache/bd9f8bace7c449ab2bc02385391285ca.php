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
<div class="iframe_image">
	<!-- <table cellpadding="0" cellspacing="1">
		<tr>
			<th>编号</th>
			<th>删</th>
			<th>图片ID</th>
			<th>对应文章ID</th>
			<th>图片</th>
		</tr>
		<?php if(is_array($images)): foreach($images as $key=>$image): ?><tr>
			<td class="numbers" width="40"><?php echo ($key+1); ?></td>
			<td class="align_center"><input type="checkbox" name="checkbox" value="<?php echo ($image["image_id"]); ?>" /></td>
			<td><?php echo ($image["image_id"]); ?></td>
			<td><?php echo ($image["in_article_id"]); ?></td>
			<td><a class="zoom" href="<?php echo ($image["image_link"]); ?>"><img height="50" src="<?php echo ($image["image_link"]); ?>" /></a></td>
		</tr><?php endforeach; endif; ?>
		<tr><td></td><td><a href="javascript:;" id="full_check">全选</a></td>
		<td colspan="11">
			<?php echo ($pager); ?>
		</td></tr>
	</table> -->
	<table cellpadding="0" cellspacing="1">
	<tr>
	<?php if(is_array($images)): foreach($images as $key=>$image): if($key != 0 and $key % 5 == 0): ?></tr><tr><?php endif; ?>
		<td><a class="zoom hover_article" status="0" aid="<?php echo ($image["article_id"]); ?>" href="<?php echo ($image["image_link"]); ?>"><img width="300" src="<?php echo ($image["image_link"]); ?>" /><span class="article"><span></span></span></a></td><?php endforeach; endif; ?>
	</td></tr>
	<tr><td colspan="5"><?php echo ($pager); ?></td></tr>
	</table>
</div>

<script>
$(function(){
	full_check({
		clicker : '#full_check',
		selecter : '[name=checkbox]'
	});
	
	y_pager({
		selecter : '.y_pager'
	});
	
	img_view({
		selecter : 'a.zoom'
	});
	
	hover_article({
		selecter : '.hover_article',
		url : '__GROUP__/image/hover_article'
	});
});
</script>
	</div>
</body>
</html>