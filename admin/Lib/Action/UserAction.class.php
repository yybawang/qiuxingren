<?php
/**
*	后台
**/
class UserAction extends AdminAction{
	public function index(){
		$this->view();
	}
	
	/**
	*	查看用户
	**/
	public function view(){
		$page = $this->param_page();
		$limit = intval($page) * intval(C('LIMIT'));
		$user_data = D('User')->get_user('',$limit);
		foreach($user_data as $key => $val){
			if(!empty($val['reg_time'])){$user_data[$key]['reg_time'] = date('Y-m-d H:i:s',$val['reg_time']);}
			if(!empty($val['last_log_time'])){$user_data[$key]['last_log_time'] = date('Y-m-d H:i:s',$val['last_log_time']);}
		}
		
		$user_count = D('User')->get_user_count();
		$page_dom = $this->page_dom($user_count);
		$this->assign('pager',$page_dom);
		
		$this->assign('users',$user_data);
		$this->display();
	}
	
	/**
	*	添加用户
	**/
	public function add(){
		if(IS_POST){
			$u['email']	 = trim($_POST['email']);
			$u['user_name'] = trim($_POST['user_name']);
			$u['password'] = trim($_POST['password']);
			$u['reg_ip'] = get_client_ip();
			$u['reg_time'] = time();
			//注册到表
			$uid = M('user')->data($u)->add();
			if($uid <= 0) {
				$this->error('用户注册失败,可能是服务器原因,您可以重试此操作');
			}else{
				$this->success('添加成功',U('User/view'));
			}
		}else{
			$this->display();
		}
	}
	
	/**
	*	编辑用户(弹窗形式)
	**/
	public function edit(){
		$uid = I('post.uid');
		$user_info = D('User')->get_user($uid);
		$user = $user_info[0];
		$dom = '<table class="table_add_user" cellpadding="0" cellspacing="1"><tr><th colspan="3">编辑用户</th></tr><tr><td>邮箱(登录帐号)<span class="red">*</span></td><td><input type="text" name="email" value="'.$user['email'].'" /></td><td><span class="prompt"></span></td></tr><tr><td>密码<span class="red">*</span></td><td><input type="text" name="password" value="'.$user['real_pass'].'" /></td><td><span class="prompt"></span></td></tr><tr><td>昵称</td><td><input type="text" name="user_name" value="'.$user['user_name'].'" /></td><td><span class="prompt"></span></td></tr><tr><td></td><td colspan="2"><input class="bottom" style="width:125px;" type="submit" value="保　存" /></td></tr></table>'; 
		$this->ajaxReturn($dom,'',1);
	}
	
	/**
	*	ajax保存用户
	**/
	public function save(){
		$uid = I('post.uid');
		$save['user_name'] = I('post.user_name');
		$save['email'] = I('post.email');
		$password = I('post.password');
		empty($password) ? '' : $save['password'] = $password;
		$line = D('User')->where('user_id='.$uid)->save($save);
		if($line > 0 ){
			$this->ajaxReturn('','成功',1);
		}
	}
}
?>