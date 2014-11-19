<?php
return array(
	//'配置项'=>'配置值'
	'LOG_RECORD'			=> false,  		// 进行日志记录
    'LOG_EXCEPTION_RECORD'  => false,    	// 是否记录异常信息日志
	'LOG_LEVEL' 	 		=> 'EMERG', 	// 只记录 EMERG 错误
	//项目
	'DEFAULT_GROUP'			=> 'Home',
	'MODULE_ALLOW_LIST'     => array('Home'),
	'DEFAULT_CHARSET'		=> 'utf-8',
	
	//URL			
	'URL_CASE_INSENSITIVE' 	=> true,						//url不区分大小写(为默认，但在调试下为false(区分),所以这里要设置)
	'URL_HTML_SUFFIX'		=> 'html|php|htm',
	'URL_MODEL'				=> 2,

	//调试
	'SHOW_RUN_TIME'=>false,          // 运行时间显示
    'SHOW_ADV_TIME'=>false,          // 显示详细的运行时间
	'SHOW_PAGE_TRACE' 		=> false, 						//开启后浏览器右下角有个调试按钮
	
	'HTML_CACHE_ON'			=> false,
	'HTML_CACHE_RULES'		=> array(
		'Index:' => array('{:module}_{:action}_{t}_{page}',3600),
		'Zone:' => array('{:module}_{:action}_{t}_{page}',3600),
		'Article:' => array('{:module}_{:action}',3600),
	),
	
	//模板
	'DEFAULT_THEME'			=> 'default',
	'THEME_LIST'			=> 'default,blue,green',
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
	'PAGE_ARTICLE_NUM'		=> '20',						//每页显示多少条
	'LIMIT'					=> '20',
	'LIMIT_MIN'				=> '0',
	'z1'					=> array(
									'word'		=> '求祝福',
									/*最少配置两个，便于循环，没有做是否是数组的判断*/
									'keyword'	=> array('祝福','过百','过100','过1000','过千','过十','过10','顶到','多少靠大家了','给过就行','过520','过250','爱你'),
								),
	'z2'					=> array(
									'word'		=> 'XXOO区',
									'keyword'	=> array('XXOO','绿了','被绿','爱爱','动作电影','苍老师','女优','射了','she','kj','情趣','阳wei','日用','动作片'),
								),
	'z3'					=> array(
									'word'		=> '爆照求带走',
									'keyword'	=> array('带走','求联系','爆照','抱照','额头','素颜','美图秀秀'),
								),
	//替换关键字，
	'REPLACE_KEYWORDS'	=> array(
		array(array('糗百','糗事百科'),'糗星'),
	),
);
?>