<?php
return array(
	//'配置项'=>'配置值'
	'DEFAULT_CHARSET'		=> 'utf-8',
	
	//URL			
	'URL_CASE_INSENSITIVE' 	=> true,						//url不区分大小写(为默认，但在调试下为false(区分),所以这里要设置)
	'URL_HTML_SUFFIX'		=> '.page',
	'URL_MODEL'				=> 2,

	//调试
	//'SHOW_PAGE_TRACE' 		=> true, 						//开启后浏览器右下角有个调试按钮
	
	'DEFAULT_MODULE'		=> 'Article',
	
	'HTML_CACHE_ON'			=> false,
	'HTML_CACHE_RULES'		=> array(
		'Index:' => array('{:module}_{:action}_{t}_{page}',3600),
		'Zone:' => array('{:module}_{:action}_{t}_{page}',3600),
		'Article:' => array('{:module}_{:action}',3600),
	),
	
	//模板
	'DEFAULT_THEME'			=> 'green',
	'THEME_LIST'			=> 'green',
	'TMPL_DETECT_THEME'		=> true,
	
	'TMPL_ACTION_ERROR'		=> APP_PATH.'Tpl/dispatch_jump.tpl',
	'TMPL_ACTION_SUCCESS'	=> APP_PATH.'Tpl/dispatch_jump.tpl',
	
	
	'LOAD_EXT_CONFIG' 		=> 'public', 				// 加载扩展配置文件
	
	//邮箱
	'MAIL_ADDRESS'	=> 'yybawang@163.com', 	// 邮箱地址
	'MAIL_SMTP'		=> 'smtp.163.com', 	// 邮箱SMTP服务器
	'MAIL_LOGINNAME'=> 'yybawang', 			// 邮箱登录帐号
	'MAIL_PASSWORD'	=> 'zz3581022', 			// 邮箱密码
	//错误页
	//'ERROR_PAGE'			=> './Public/error.html',
	//'TMPL_EXCEPTION_FILE'	=> './Public/error.html',
	
	//自定义
	'LIMIT'					=> '20',
	
	'ZONE' => array(
		array(
			'zone'		=> 1,
			'word'		=> '求祝福',
			'keyword'	=> array('祝福','过百','过100','过1000','过千','过十','过10','顶到','多少靠大家了','给过就行','过520','过250','爱你'),
		),
		array(
			'zone'		=> 2,
			'word'		=> 'XXOO区',
			'keyword'	=> array('XXOO','绿了','被绿','爱爱','动作电影','苍老师','女优','射了','she','kj','情趣','阳wei','日用','动作片'),
		),
		array(
			'zone'		=> 3,
			'word'		=> '爆照求带走',
			'keyword'	=>  array('带走','求联系','爆照','抱照','额头','素颜','美图秀秀'),
		),
		
	),
	//替换关键字，
	'REPLACE_KEYWORDS'	=> array(
		array(array('糗百','糗事百科,臭百'),'糗星'),
	),
);
?>