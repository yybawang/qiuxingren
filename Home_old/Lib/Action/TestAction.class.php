<?php
// 本类由系统自动生成，仅供测试用途
class TestAction extends HomeAction {
    public function index(){
		$site = 'http://www.qiushibaike.com';
		$ip = "117.59.224.61:80";			//代理IP:端口号，以防被封IP
		$client_ip = rand(1,250).'.'.rand(1,250).'.'.rand(1,250).'.'.rand(1,250);
		
		$html = curl($site.'/late/index.php');	//加 /late 表示采集最新
		if($html != false){
			$this->go($html,time());
			$this->display();
		}
    }
	public function hot_8(){
		$site = 'http://www.qiushibaike.com';
		$ip = "117.59.224.61:80";			//代理IP:端口号，以防被封IP
		$client_ip = rand(1,250).'.'.rand(1,250).'.'.rand(1,250).'.'.rand(1,250);
		
		$html = curl($site.'/8hr/index.php');	//加 /late 表示采集最新
		if($html != false){
			$this->go($html,time() - 28800);
			$this->display('index');
		}
	}
	public function hot_24(){
		$site = 'http://www.qiushibaike.com';
		$ip = "117.59.224.61:80";			//代理IP:端口号，以防被封IP
		$client_ip = rand(1,250).'.'.rand(1,250).'.'.rand(1,250).'.'.rand(1,250);
		
		$html = curl($site.'/hot/index.php');	//加 /late 表示采集最新
		if($html != false){
			$this->go($html,time() - 86400);
			$this->display('index');
		}
	}
	public function week(){
		$site = 'http://www.qiushibaike.com';
		$ip = "117.59.224.61:80";			//代理IP:端口号，以防被封IP
		$client_ip = rand(1,250).'.'.rand(1,250).'.'.rand(1,250).'.'.rand(1,250);
		
		$html = curl($site.'/week/index.php');	//加 /late 表示采集最新
		if($html != false){
			$this->go($html,time() - 86400*7);
			$this->display('index');
		}
	}
	public function month(){
		$site = 'http://www.qiushibaike.com';
		$ip = "117.59.224.61:80";			//代理IP:端口号，以防被封IP
		$client_ip = rand(1,250).'.'.rand(1,250).'.'.rand(1,250).'.'.rand(1,250);
		
		$html = curl($site.'/month/index.php');	//加 /late 表示采集最新
		if($html != false){
			$this->go($html,time() - 86400*24);
			$this->display('index');
		}
	}
	public function imgrank(){
		$site = 'http://www.qiushibaike.com';
		$ip = "117.59.224.61:80";			//代理IP:端口号，以防被封IP
		$client_ip = rand(1,250).'.'.rand(1,250).'.'.rand(1,250).'.'.rand(1,250);
		
		$html = curl($site.'/imgrank/index.php');	//加 /late 表示采集最新
		
		if($html != false){
			$this->go($html);
			$this->display('index');
		}
	}
	public function pic(){
		$site = 'http://www.qiushibaike.com';
		$ip = "117.59.224.61:80";			//代理IP:端口号，以防被封IP
		$client_ip = rand(1,250).'.'.rand(1,250).'.'.rand(1,250).'.'.rand(1,250);
		
		$html = curl($site.'/pic/index.php');	//加 /late 表示采集最新
		if($html != false){
			$this->go($html);
			$this->display('index');
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	function go($html,$time){
		$hour = (int)date("H");					//获取小时
		switch($hour){
			case 1:
			case 2:
			case 3:
			case 4:
			case 5:
			case 6:
			case 7: $timeout = 4000;break;
			case 8:
			case 9:
			case 10:
			case 11:
			case 12: $timeout = 2400;break;
			default: $timeout = 2400;
		}
		$this->assign('timeout',$timeout);
		$match = preg_list($html);
		$id = preg_id($match[0]);				//匹配原ID
		$content = preg_content($match[0]);		//匹配内容
		$thumb = preg_thumb($match[0]);			//匹配图片
		$up = preg_up($match[0]);
		$down = preg_down($match[0]);
		$author_name = preg_author_name($match[0]);
		$author_id = preg_author_id($match[0]);
		
		//赋值到模板
		foreach($content as $key => $value){
			$get_data[] = array('content' => $value,'former_id' => $id[$key],'image_link' => $thumb[$key]);
		}
		$this->assign('content',$get_data);
	}
}