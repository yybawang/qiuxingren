<?php
/**
*	真实IP管理
**/
class IpAction Extends AdminAction{
	public function index(){
		$this->view();
	}
	
	/**
	*	IP 查看
	**/
	public function view(){
		$page = $this->param_page();
		$limit = intval($page) * intval(C('LIMIT'));
		$ips = D('Ip')->get_ip('',$limit);
		foreach($ips as $key => $val){
			if(!empty($val['add_time'])){$ips[$key]['add_time'] = date('Y-m-d H:i:s',$val['add_time']);}
		}
		
		$count = D('Ip')->get_ip_count();
		$page_dom = $this->page_dom($count);
		$this->assign('pager',$page_dom);
		
		$this->assign('ips',$ips);
		$this->display();
	}
}