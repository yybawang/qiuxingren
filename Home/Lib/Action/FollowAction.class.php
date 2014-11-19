<?php
class FollowAction extends HomeAction{

	public function index(){
		$this->following();
	}
	/**
	*	已登陆用户关注其他用户
	**/
	public function following(){
		$data['user_id_follow'] = I('post.uid');
		if(empty($data['user_id_follow'])){
			$this->ajaxReturn('','',-1);
		}
		$dF = D('Follow');
		$dU = D('User');
		$user_res = $dU->where(array('user_id'=>$data['user_id_follow']))->find();		//查询是否有此用户
		if(empty($user_res)){
			$this->_ajax_error('此用户非本网站用户，无法关注');
		}
		$data['user_id'] = user_id();
		$follow_res = $dF->where($data)->find();
		if(!$follow_res){
			$data['add_time'] = time();
			$dF->data($data)->add();
			$this->_ajax_success('关注成功，现在可以在用户中心查看了');
		}else{
			$this->_ajax_error('您已经关注过此用户，您可以在个人中心中查看');
		}
	}
}