<?php
/** 小纸条页面，用户对用户-----用户对管理员(反馈) **/
class MessageAction extends AdminAction{
	
	public function index(){
		$this->view_fankui();
	}
	
	/**
	*	查看网站的用户反馈
	**/
	public function view_fankui(){
		$page = $this->param_page();
		$limit = intval($page) * intval(C('LIMIT'));
		$fankuis = D('Message')->get_fankui('',$limit);
		
		foreach($fankuis as $key => $val){
			if(!empty($val['add_time'])){$fankuis[$key]['add_time'] = date('Y-m-d H:i:s',$val['add_time']);}
		}
		
		$count = D('Message')->get_fankui_count();
		$page_dom = $this->page_dom($count);
		$this->assign('pager',$page_dom);
		
		$this->assign('datas',$fankuis);
		$this->display();
	}
	
	/**管理员回复用户的反馈**/
	public function replay_fankui(){
		$fankui = I('post.fankui');
		$uid = I('post.uid');
		$line = D('Message')->add_fankui($uid,$fankui);
		if($line >= 1){
			$this->ajaxReturn('','回复成功',1);
		}else{
			$this->ajaxReturn('','失败！数据表插入失败',0);
		}
	}
}