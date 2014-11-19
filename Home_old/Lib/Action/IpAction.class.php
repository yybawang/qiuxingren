<?php
/**
*	查看IP
**/

class IpAction extends HomeAction {
    public function index(){
		$page = I('get.page');
		$size = I('get.size');
		if(empty($size)){
			$size = 300;
		}
		$page = $page*$size;
		$ip_res = M('ip')->limit($page.','.$size)->select();
		$count =  M('ip')->count();
		print ('<style>span{display:inline-block;height:25px;}</style>'.
		'count='.$count.',a page number 300 , you can use page=\'num\' to limit page,'.
		'use size=\'num\' to limit page_size<br />');
		$str_ip = '';
		foreach($ip_res as $key => $val){
			$str_ip .= '<span style="width:30px;">'.(1+$key).'</span>ID:<span style="width:200px;">'.$val['id'].'</span><span style="width:300px;">'.$val['ip'].'</span>'.date("Y-m-d H:i:s",$val['add_time']).'<br />';
		}
		print ($str_ip);
    }
}
?>