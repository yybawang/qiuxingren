<?php
class NowAction extends HomeAction {
    public function index(){
		$site = 'http://www.qiushibaike.com';
		$ip = "117.59.224.61:80";			//代理IP:端口号，以防被封IP
		$client_ip = rand(1,250).'.'.rand(1,250).'.'.rand(1,250).'.'.rand(1,250);
		if(isset($_REQUEST['page'])){
			$html = curl($site.'/late/page/'.$_REQUEST['page']);	//加 /late 表示采集最新
		}else{
			$html = curl($site.'/late/index.php');	//加 /late 表示采集最新
		}
		if($html != false){
			$this->go($html,time());
			$this->assign('title','最新发布--实时更新不留缓存版__糗星人网站');
			$this->display();
		}
    }
	public function hot_8(){
		$site = 'http://www.qiushibaike.com';
		$ip = "117.59.224.61:80";			//代理IP:端口号，以防被封IP
		$client_ip = rand(1,250).'.'.rand(1,250).'.'.rand(1,250).'.'.rand(1,250);
		if(isset($_REQUEST['page'])){
			$html = curl($site.'/8hr/page/'.$_REQUEST['page']);
		}else{
			$html = curl($site.'/8hr/index.php');
		}
		if($html != false){
			$this->go($html,time() - 28800);
			$this->assign('title','8小时内精华--实时更新不留缓存版__糗星人网站');
			$this->display('index');
		}
	}
	public function hot_24(){
		$site = 'http://www.qiushibaike.com';
		$ip = "117.59.224.61:80";			//代理IP:端口号，以防被封IP
		$client_ip = rand(1,250).'.'.rand(1,250).'.'.rand(1,250).'.'.rand(1,250);
		if(isset($_REQUEST['page'])){
			$html = curl($site.'/hot/page/'.$_REQUEST['page']);	
		}else{
			$html = curl($site.'/hot/index.php');
		}
		if($html != false){
			$this->go($html,time() - 86400);
			$this->assign('title','24小时内精华--实时更新不留缓存版__糗星人网站');
			$this->display('index');
		}
	}
	public function week(){
		$site = 'http://www.qiushibaike.com';
		$ip = "117.59.224.61:80";			//代理IP:端口号，以防被封IP
		$client_ip = rand(1,250).'.'.rand(1,250).'.'.rand(1,250).'.'.rand(1,250);
		if(isset($_REQUEST['page'])){
			$html = curl($site.'/week/page/'.$_REQUEST['page']);	
		}else{
			$html = curl($site.'/week/index.php');
		}
		if($html != false){
			$this->go($html,time() - 86400*7);
			$this->assign('title','一周内精华--实时更新不留缓存版__糗星人网站');
			$this->display('index');
		}
	}
	public function month(){
		$site = 'http://www.qiushibaike.com';
		$ip = "117.59.224.61:80";			//代理IP:端口号，以防被封IP
		$client_ip = rand(1,250).'.'.rand(1,250).'.'.rand(1,250).'.'.rand(1,250);
		if(isset($_REQUEST['page'])){
			$html = curl($site.'/month/page/'.$_REQUEST['page']);	
		}else{
			$html = curl($site.'/month/index.php');
		}
		if($html != false){
			$this->go($html,time() - 86400*24);
			$this->assign('title','一月内精华--实时更新不留缓存版__糗星人网站');
			$this->display('index');
		}
	}
	public function imgrank(){
		$site = 'http://www.qiushibaike.com';
		$ip = "117.59.224.61:80";			//代理IP:端口号，以防被封IP
		$client_ip = rand(1,250).'.'.rand(1,250).'.'.rand(1,250).'.'.rand(1,250);
		if(isset($_REQUEST['page'])){
			$html = curl($site.'/imgrank/page/'.$_REQUEST['page']);	
		}else{
			$html = curl($site.'/imgrank/index.php');
		}
		if($html != false){
			$this->go($html);
			$this->assign('title','有图有真相之精华--实时更新不留缓存版__糗星人网站');
			$this->display('index');
		}
	}
	public function pic(){
		$site = 'http://www.qiushibaike.com';
		$ip = "117.59.224.61:80";			//代理IP:端口号，以防被封IP
		$client_ip = rand(1,250).'.'.rand(1,250).'.'.rand(1,250).'.'.rand(1,250);
		if(isset($_REQUEST['page'])){
			$html = curl($site.'/pic/page/'.$_REQUEST['page']);	
		}else{
			$html = curl($site.'/pic/index.php');
		}
		if($html != false){
			$this->go($html);
			$this->assign('title','有图有真相之最新--实时更新不留缓存版__糗星人网站');
			$this->display('index');
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	function go($html,$time){
		$this->assign('timeout',$timeout);
		$match = preg_list($html);
		$id = preg_id($match[0]);				//匹配原ID
		$content = preg_content($match[0]);		//匹配内容
		$thumb = preg_thumb($match[0]);			//匹配图片
		$up = preg_up($match[0]);
		$down = preg_down($match[0]);
		$author_name = preg_author_name($match[0]);
		$author_id = preg_author_id($match[0]);
		$author_pic = preg_author_pic($match[0]);
		
		
		//赋值到模板
		foreach($content as $key => $value){
			//替换关键字--比如把 糗百 替换成 糗星人
			foreach(C('REPLACE_KEYWORDS') as $val){
				$data['content'] = str_replace($val[0],$val[1],$content[$key]);
			}
			preg_match('/\"http.*?\"/is',$thumb[$key],$match_thumb);
			$match_thumb[0] = str_replace('"','',$match_thumb[0]);
			$get_data[$key] = array(
				'article_id'=>$id[$key],
				'former_user_name'=>$author_name[$key],
				'former_user_id'=>$author_id[$key],
				'content' => $value,
				'former_id' => $id[$key],
				'image' =>  empty($match_thumb[0]) ? null : array(array('image_link' => $match_thumb[0])),
				'up'=>$up[$key],
				'down'=>$down[$key],
				'pic'=>$author_pic[$key],
				'add_time' => date("Y-m-d H:i:s",time()),
				'comment_count' => 0,
			);
		}
		if(IS_AJAX){
			$this->ajaxReturn($get_data,"请求成功",1);
		}
		$this->assign('content',$get_data);
	}
}