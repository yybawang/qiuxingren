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
<div class="iframe_article">
	<table cellpadding="0" cellspacing="1" width="1700">
		<tr>
			<th>编号</th>
			<th>删</th>
			<th>文章ID</th>
			<th>用户ID</th>
			<th>糗百用户ID</th>
			<th>糗百用户昵称</th>
			<th>头像</th>
			<th width="400">内容</th>
			<th>图片</th>
			<th>Up</th>
			<th>Down</th>
			<th>添加时间</th>
			<th>通过时间</th>
			<th>Zone</th>
			<th>是否显示</th>
		</tr>
		<?php if(is_array($articles)): foreach($articles as $key=>$article): ?><tr>
			<td class="numbers" width="40"><?php echo ($key+1); ?></td>
			<td class="align_center"><input type="checkbox" name="checkbox" value="<?php echo ($article["article_id"]); ?>" /></td>
			<td><?php echo ($article["article_id"]); ?></td>
			<td><?php echo ($article["user_id"]); ?></td>
			<td><?php echo ($article["former_user_id"]); ?></td>
			<td><?php echo ($article["former_user_name"]); ?></td>
			<td><?php if(empty($article["pic"])): ?>无<?php else: ?><img src="<?php echo ($article["pic"]); ?>" width="30" /><?php endif; ?></td>
			<td><?php echo ($article["content"]); ?></td>
			<td>
				<?php if(is_array($article["images"])): foreach($article["images"] as $key=>$image): if($article["former_id"] <= 0): ?><a class="zoom" href="__PUBLIC__<?php echo ($image["image_link"]); ?>"><img width="50" src="__PUBLIC__<?php echo ($image["image_link"]); ?>" /></a>
					<?php else: ?>
						<a class="zoom" href="<?php echo ($image["image_link"]); ?>"><img width="50" src="<?php echo ($image["image_link"]); ?>" /></a><?php endif; endforeach; endif; ?>
			</td>
			<td><?php echo ($article["up"]); ?></td>
			<td><?php echo ($article["down"]); ?></td>
			<td><?php echo ($article["add_time"]); ?></td>
			<td><?php echo ($article["check_time"]); ?></td>
			<td><?php echo ($article["zone_text"]); ?></td>
			<td><?php if($article["is_show"] == 1): ?>显示<?php elseif($article["is_show"] == -1): ?><span class="red">隐藏</span><?php else: ?><span class="red">待审核</span><?php endif; ?></td>
		</tr><?php endforeach; endif; ?>
		<tr><td></td><td><a href="javascript:;" id="full_check">全选</a><br /><a href="javascript:;" id="double_del">删除</a></td><td colspan="13">
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
		model : 'article',
		field : 'article_id',
		url : '__GROUP__/index/double_del'
	});
	
	y_pager({
		selecter : '.y_pager'
	});
	
	img_view({
		selecter : 'a.zoom'
	});
	
});
</script>
	</div>
</body>
</html>