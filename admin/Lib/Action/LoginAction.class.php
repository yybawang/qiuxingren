<?php
class LoginAction extends Action{
	
	/** 管理员登录操作，不是邮箱登陆 **/
	public function login(){
		$user_name = I('post.user_name');
		$password = I('post.password');
		if(empty($user_name) || empty($password)){
			return false;
		}
		$user_res = M('user')->field('user_id')->where("user_name='$user_name' and password='$password'")->find();
		if($user_res['user_id'] > 0){
			//判断是否是管理员ID
			if($user_res['user_id'] != 1){
				if(IS_AJAX){
					$this->ajaxReturn('','非管理员帐号',2);
				}else{
					$this->error('非管理员帐号');
				}
				return false;
			}
			session('admin_id',$user_res['user_id']);
			if(IS_AJAX){
				$this->ajaxReturn('','登录成功',1);
			}else{
				$this->success('登录成功',U('index/index'));
			}
		}else{
			if(IS_AJAX){
				$this->ajaxReturn('','用户名或密码错误',0);
			}else{
				$this->error('用户名或密码错误');
			}
		}
	}
	
	public function logout(){
		session('admin_id',null);
		$this->success('注销成功',U('index/index'));
	}
}
