<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<title><?php echo ($title); ?></title>
<link rel="Bookmark"   href="__ROOT__/favicon.ico" /> <!-- 收藏夹中的图标 -->
<link rel="shortcut icon" href="__ROOT__/favicon.ico" /> <!-- 地址栏前面的图标 -->
<link rel="icon" href="__ROOT__/animated_favicon.gif" type="image/gif" /> <!-- 动态Icon图标 -->
<script type="text/javascript" src="__PUBLIC__/public/jquery/jquery-1.11.0.js"></script>	
<script type="text/javascript" src="__PUBLIC__/public/jquery/jquery.cookies.2.2.0.js"></script>
<script type="text/javascript" src="__PUBLIC__/public/jquery/lhgdialog.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo (__ROOT__); echo (substr(THEME_PATH,1)); ?>public/css/admin.css" />
<script type="text/javascript" src="<?php echo (__ROOT__); echo (substr(THEME_PATH,1)); ?>public/js/admin.js"></script>
</head>
<body class="iframe_body">
<!-- 框架 -->
<div id="iframe">
	<ul id="iframe_head">
		<!-- 100%宽的头 -->
		<li class="head">
			<div class="right_content">
				<audio list="0" controls="controls" id="audio_player" volume="0.6" preload="metadata" src="<?php echo (__ROOT__); echo (substr(THEME_PATH,1)); ?>public/music/悲伤的天使.mp3">
				</audio>
				<ul>
					<li><a href="javascript:clear_temp();">清除缓存</a></li>
					<li><a target="_blank" href="<?php echo (__ROOT__); ?>/">打开首页</a></li>
					<li><a href="__GROUP__/login/logout">退出登录</a></li>
				</ul>
			</div>
		</li>
		<li class="iframe_close_head" status="1"></li>
	</ul>
	<ul id="iframe_body">
		<li class="left">
		<div id="iframe_menu">
			<?php if(is_array($menus)): foreach($menus as $key=>$menu): ?><ul><li status="1"><div class="main_menu"><i class="bg_img"></i><span><?php echo ($menu["title"]); ?></span><b>∨</b></div></li>
				<ul heights="0px">
				<?php if(is_array($menu["child"])): foreach($menu["child"] as $key=>$child): ?><li><a target="iframe1" href="<?php echo ($child["url"]); ?>"><?php echo ($child["title"]); ?></a></li><?php endforeach; endif; ?>
				</ul>
			</ul><?php endforeach; endif; ?>
		</div>
		</li>
		<li class="iframe_close_menu" status="1"></li>
		<li class="right">
			<!-- 这里放可变内容 -->
			<iframe id="iframe1" name="iframe1" width="100%" height="100%" framespacing=0 frameborder="NO" scrolling="yes"  noresize="noresize" src="__GROUP__/index/iframe_index"></iframe>
		</li>
	</ul>
</div>
</body>
</html>
<script>
$(function(){
	//关闭 head
	$('#iframe #iframe_head .iframe_close_head').click(function(){
		if($(this).attr('status') == '1'){
			$('#iframe #iframe_head').animate({'height':'5px'});
			$('#iframe #iframe_head .head').animate({'height':'0px'});
			$('#iframe #iframe_body').animate({'top':'5px'});
			$(this).attr('status','0');
		}else{
			$('#iframe #iframe_head').animate({'height':'85px'});
			$('#iframe #iframe_head .head').animate({'height':'80px'});
			$('#iframe #iframe_body').animate({'top':'85px'});
			$(this).attr('status','1');
		}
	});
	//关闭 menu
	$('#iframe #iframe_body .iframe_close_menu').click(function(){
		if($(this).attr('status') == '1'){
			$(this).animate({'left':'0px'});
			$('#iframe #iframe_body .right').animate({'left':'5px'});
			$(this).attr('status','0');
		}else{
			$(this).animate({'left':'200px'});
			$('#iframe #iframe_body .right').animate({'left':'205px'});
			$(this).attr('status','1');
		}
	});
	
	
	//左侧菜单点击效果
	$('#iframe_menu > ul > li').click(function(){
		var status = $(this).attr('status');
		if(status == '1'){
			$(this).siblings('ul').attr('heights',$(this).siblings('ul').css('height'));
			$(this).siblings('ul').animate({'height':'0px'},300,function(){$(this).css('display','none');});
			$(this).find('.main_menu > b').text('＜');
			$(this).attr('status','0');
		}else{
			var heights = $(this).siblings('ul').attr('heights');
			$(this).siblings('ul').css('display','block').animate({'height':heights},300);
			$(this).find('.main_menu > b').text('∨');
			$(this).attr('status','1');
		}
	});
	
	
	music_play_list();
	 
	
});

var clear_temp = function(){
	$.post('__GROUP__/index/clear_temp',{},function(msg){
		y_dialog('提示信息',msg.info);
	});
};

//生成播放列表来循环播放
var music_play_list = function(){
	//播放列表
	var audio_play_list = new Array(
		'悲伤的天使.mp3',
		'雪映移城.mp3',
		'磯村由紀子-风居住的街道.mp3',
		'牛奶咖啡 - 明天你好.mp3',
		'独立.mp3'
	);
	
	var audio = document.getElementById('audio_player');
	var play_id = $('#audio_player').attr('list');
	audio.addEventListener('ended',function(){
		play_id++;
		if(play_id >= audio_play_list.length){
			play_id = 0;
		}
		audio.src  = '<?php echo (__ROOT__); echo (substr(THEME_PATH,1)); ?>public/music/'+audio_play_list[play_id];
		audio.play();
	},false);
}
</script>