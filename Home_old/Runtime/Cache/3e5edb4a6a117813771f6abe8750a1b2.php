<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ($title); ?></title>

<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<meta name="keywords" content="糗星人,糗事百科,糗百,qiuxingren，糗百交友，糗百暗号，糗百笑话，糗百论坛" />
<meta name="description" content="糗星人,糗事百科,糗百,qiuxingren，糗百交友，糗百暗号，糗百笑话，糗百论坛" />
<meta name="Generator" content="糗星人,糗事百科,糗百,qiuxingren，糗百交友，糗百暗号，糗百笑话，糗百论坛" /> 
<meta name="DEscription" content="糗事,XXOO,求带走,囧事,笑话，糗百交友，糗百暗号，糗百笑话，糗百论坛" /> 
<meta name="Author" content="糗星人，糗百暗号，糗百笑话，糗百论坛" />
<meta name="Robots" content= "all" />
<link rel="Bookmark"   href="__ROOT__/favicon.ico" /> <!-- 收藏夹中的图标 -->
<link rel="shortcut icon" href="__ROOT__/favicon.ico" /> <!-- 地址栏前面的图标 -->
<link rel="icon" href="__ROOT__/animated_favicon.gif" type="image/gif" /> <!-- 动态Icon图标 -->
<script type="text/javascript" src="__PUBLIC__/public/jquery/jquery-1.11.0.js"></script>	
<script type="text/javascript" src="__PUBLIC__/public/jquery/jquery.cookies.2.2.0.js"></script>
<script type="text/javascript" src="__PUBLIC__/public/jquery/lhgdialog.js"></script>
<script type="text/javascript" src="__PUBLIC__/public/jquery/hoverIntent.js"></script>
<script type="text/javascript" src="__PUBLIC__/public/jquery/superfish.js"></script>
<script type="text/javascript" src="__PUBLIC__/public/jquery/jquery-ui-1.10.4.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/public/jquery/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/public/jquery/jquery.iviewer.js"></script>
<script type="text/javascript" src="__PUBLIC__/public/jquery/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="__PUBLIC__/public/jquery/kkpager.js"></script>
<script type="text/javascript" src="__PUBLIC__/public/jquery/jquery.pressAndHold.js"></script>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/public/css/superfish.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/public/css/public.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/public/css/jquery.iviewer.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/public/css/kkpager.css" />
<link rel="stylesheet" type="text/css" href="<?php echo (__ROOT__); echo (substr(THEME_PATH,1)); ?>public/css/index.css" />
<script type="text/javascript" src="<?php echo (__ROOT__); echo (substr(THEME_PATH,1)); ?>public/js/index.js"></script>
<script type="text/javascript" src="<?php echo (__ROOT__); echo (substr(THEME_PATH,1)); ?>public/js/log.js"></script>

</head>
<body>
	<div class="head">
		<div class="header">
		<div class="text_logo">
			<!-- <ol>
				<li class="zh">糗星人</li>
				<li class="pinyin">http://qiuxingren.com</li>
			<ol> -->
		</div>
			<div class="logo_right">
			<ol>
			<li class="user_li">
				
				<div class="user_bar">
					<?php if($_SESSION['tsuser']['userid']!= null): ?><div class="login">
							<a href="__GROUP__/Usercenter/center"><?php echo ($_SESSION['tsuser']['username']); ?></a>
							<a class="new_message" href="__GROUP__/Usercenter/message" style="width:10px;height:25px;background:url(__PUBLIC__/public/images/web_icon.png) no-repeat scroll -76px 7px transparent;position:relative;"><span class="message_num" style="position:absolute;top:-8px;left:20px;">0</span></a>
							<a href="__GROUP__/User/logout" id="go_out">退出</a>
						</div>
					<?php else: ?>
					<div class="logout">
					<a href="__GROUP__/User/login">登陆</a>
					<a href="__GROUP__/User/register">注册</a>
					</div><?php endif; ?>
				</div>
			</li>
			<li class="group_bar"><ul>
				<li><a target="_blank" title="欢迎进入我的博客" href="__ROOT__/blog">博客</a></li>
				<li><a target="_blank" title="逛论坛" href="http://bbs.qiuxingren.com">论坛</a></li>
				<li><a title="糗星人主页" href="__GROUP__/Index/index">主页</a></li>
			</ul></li>
			</ol>
			</div>
		</div>
		<div class="nav">
			<ul class="nav_ul">
				<li class="down marrow">
					<p><a href="__GROUP__/Index/hot">精华</a></p>
					<div class="subtext">
						<a href="__GROUP__/Index/hot_8">8小时内</a>
						<a href="__GROUP__/Index/hot">24小时内</a>
						<a href="__GROUP__/Index/week">一周内</a>
						<a href="__GROUP__/Index/month">一月内</a>
					</div>
				</li>
				<li class="down real">
					<p><a href="__GROUP__/Index/imgrand">真相</a></p>
					<div class="subtext">
						<a href="__GROUP__/Index/imgrand">硬菜</a>
						<a href="__GROUP__/Index/pic">时令</a>
					</div>
				</li>
				<li class="index">
					<p><a href="__GROUP__/Index/index">最新</a></p>
				</li>
				<li class="down zone">
					<p><a href="javascript:void(0)">版区</a></p>
					<div class="subtext">
						<a href="__GROUP__/Zone/z1"><?php echo (C("z1.word")); ?></a>
						<a href="__GROUP__/Zone/z2"><?php echo (C("z2.word")); ?></a>
						<a href="__GROUP__/Zone/z3"><?php echo (C("z3.word")); ?></a>
					</div>
				</li>
				<li class="check">
					<p><a href="__GROUP__/Send/audit">审帖</a></p>
					
				</li>
				<li class="put">
					<p><a href="__GROUP__/Send/send">投稿</a></p>
					
				</li>
				<li class="down now">
					<p><a title="实时同步最新，本地不留缓存，以进来网站的时间为准" href="__GROUP__/Now/Index">实时最新</a></p>
					<div class="subtext">
						<a href="__GROUP__/Now/hot_8">8小时精华</a>
						<a href="__GROUP__/Now/hot_24">24小时精华</a>
						<a href="__GROUP__/Now/pic">真相之时令</a>
						<a href="__GROUP__/Now/imgrank">真相之精华</a>
					</div>
				</li>
				
				<div class="search">
					<form action="__GROUP__/Index/search" method="post">
					<span><input type="text" value="<?php echo ($_POST['keyword']); ?>" placeholder="搜索糗事关键字" name="keyword" class="k_search" /></span><span><input class="sub" type="submit" value="搜 索" /></span>
					</form>
				</div>
			</ul>
		</div>
		
	</div>
<script>
//导航指针
var action = "<?php echo (ACTION_NAME); ?>";
action = action.toLowerCase();
switch(action){
	case 'hot':
	case 'hot_8':
	case 'week':
	case 'month': $(".marrow").addClass("on");break;
	case 'pic':
	case 'imgrand': $(".real").addClass("on");break;
	case 'index': $(".index").addClass("on");break;
	case 'z1':
	case 'z2':
	case 'z3': $(".zone").addClass("on");break;
	case 'audit': $(".check").addClass("on");break;
	case 'send': $(".put").addClass("on");break;
	default: $(".nav_ul li").removeClass("on");break;
}
$(function(){
	new_message({
		user_id : "<?php echo ($_SESSION['tsuser']['userid']); ?>",
		post_url : "__GROUP__/User/new_message_ajax"
	});
});
</script>





<div class="article">
	<div class="articler">
		<div class="left">
			<h1>加入我(们)</h1>
				<h3>额..</h3>
			<h1>手机应用</h1>
			<h3><a target="_blank" href="http://as.baidu.com/a/item?docid=3331657&pre=web_am_indexnew&f=hao">糗星人客户端</a></h3>
		</div>
	</div>
</div>

<div class="foot">
	<div class="friend">
		<ul class="title"><li>FriendLinks 友情链接</li></ul>
		<ul class="link">
			<li><a target="_blank" href="http://www.cms789.com">cms资源网</a></li>
			<li><a target="_blank" href="http://www.cms789.com">cms资源网</a></li>
			<li><a target="_blank" href="http://www.cms789.com">cms资源网</a></li>
			<li><a target="_blank" href="http://www.cms789.com">cms资源网</a></li>
			<li><a target="_blank" href="http://www.cms789.com">cms资源网</a></li>
			<li><a target="_blank" href="http://www.cms789.com">cms资源网</a></li>
		</ul>
	</div>
	<div class="footer">
		<div class="ad">
		</div>
		
		<div class="help">
				<a href="__GROUP__/Article/about">关于我们</a>
				<a href="__GROUP__/Article/state">负责声明</a>
				<a href="__GROUP__/Article/joinus">加入我们</a>
				<a href="__GROUP__/Article/proposal">在线反馈</a>
				<a href="__GROUP__/Article/app">安卓客户端</a>
		</div>
		
		<div class="copyright">
		<a>© qiuxingren.com  鄂ICP备76546728号-4</a>
		
		<script language="javascript" type="text/javascript" src="http://js.users.51.la/16812026.js"></script>
		<noscript><a href="http://www.51.la/?16812026" target="_blank"><img alt="&#x6211;&#x8981;&#x5566;&#x514D;&#x8D39;&#x7EDF;&#x8BA1;" src="http://img.users.51.la/16812026.asp" style="border:none" /></a></noscript>
		<script type="text/javascript">
			//百度统计代码
			var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
			document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Ff09af1a94883d1925005ce91ef5939ce' type='text/javascript'%3E%3C/script%3E"));
		</script>
		</div>
	</div>
</div>
<script>
$(function(){
	fix_footer({
		center_dom : '.articler'
	});
	fix_footer({
		center_dom : '.ucenter'
	});
	fix_footer({
		center_dom : '.user_login'
	});
	fix_footer({
		center_dom : '.sender'
	});
	fix_footer({
		center_dom : '.auditer'
	});
	fix_footer({
		center_dom : '.content'
	});
});
</script>
</body>
</html>