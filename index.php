<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//全局301
if(stripos($_SERVER['HTTP_HOST'],'www.qiuxingren.com') === false && stripos($_SERVER['HTTP_HOST'],'localhost') === false){
	header("HTTP/1.1 301 Moved Permanently");
	header("Location:http://www.qiuxingren.com/");
}
//定义项目名称
    define('APP_NAME', '.');
    //定义项目路径
    define('APP_PATH', './Home/');
	define('APP_DEBUG',true);
	
	define('FILE_DIR',dirname(__FILE__));
    //加载框架入文件
	//require './api/session.php';
    require './ThinkPHP/ThinkPHP.php';
// 亲^_^ 后面不需要任何代码了 就是如此简单
?>