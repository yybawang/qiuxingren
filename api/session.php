 <?php  
    ini_set('session.name', 'sid');				//设置色session id的名字  
    ini_set('session.use_trans_sid', 0);		//不使用 GET/POST 变量方式  
    ini_set('session.use_cookies', 1);		//使用 COOKIE 保存 SESSION ID 的方式  
    ini_set('session.cookie_path', '/');  
    ini_set('session.cookie_domain', '.qiuxingren.com');//多主机共享保存 SESSION ID 的 COOKIE,注意此处域名为一级域名  
?>