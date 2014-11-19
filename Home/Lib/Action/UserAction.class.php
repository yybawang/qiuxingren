<?php
class UserAction extends HomeAction{
	
	public $dU = '';
	public $dUInfo = '';
	
	public function _initialize(){
		parent::_initialize();
		$this->dU = D('User');
		$this->dUInfo = D('UserInfo');
	}
	/**
	*	登陆
	*/
	public function login(){
		$this->assign('title','登录_'.C('WEB_NAME'));
		$this->display();
	}
	
	/**
	*	登陆验证
	**/
	public function login_ajax(){
		$data['email'] = I('post.email');
		$data['password'] = I('post.password');
		
		if(filter_var($data['email'],FILTER_VALIDATE_EMAIL) == false){
			$this->_ajax_error('帐号验证失败，请使用邮箱登录');
		}
		$user_find = $this->dU->where("email = '".$data['email']."'")->find();
		if(!empty($user_find)){
			$uid = $user_find['user_id'];
			//验证密码
			$md5_passwrod = $this->dU->format_password($data['password']);
			if($md5_passwrod != $user_find['password']){
				$this->_ajax_error('密码验证失败，请检查输入');
			}else{
				//验证成功--做登陆处理
				$user_cookie = array(
					'user_id' => $user_find['user_id'],
					'user_name' => $user_find['user_name'],
					'email' => $user_find['email'],
				);
				cookie('user_cookie',$user_cookie,3600*24*30);
				
				$last['last_log_time'] = time();
				$last['last_log_ip'] = get_client_ip();
				$this->dU->where('user_id = '.$uid)->data($last)->save();			//更新最后登陆时间和IP
				$this->dU->where('user_id = '.$uid)->setInc('logins');				//更新最后登陆时间和IP 
				
				$this->_ajax_success('登陆成功,等待跳转..',$user_find);		//前台js做前端处理，不刷新页面
			}
		}else{
			$this->_ajax_error('没有找到此用户名，请检查输入');
		}
	}
	
	/**
	*	注册页面
	**/
	public function register(){
		$this->assign('title','注册_'.C('WEB_NAME'));
		$this->display();
	}
	
	/**
	*	注册验证
	**/
	public function register_ajax(){
		$u['email']	 = I('post.email');
		$u['user_name'] = I('post.user_name');
		$u['real_pass'] = I('post.password');
		$u['password'] = $this->dU->format_password(I('post.password'));
		$repassword = I('post.repassword');
		$u['pic'] = __PUBLIC__.'/public/images/default_pic.jpg';
		$u['reg_ip'] = get_client_ip();
		$u['reg_time'] = time();
		
		if(filter_var($u['email'],FILTER_VALIDATE_EMAIL) == false){
			$this->_ajax_error('输入帐号为非邮箱，邮箱验证失败！');
		}
		
		if(strlen($u['real_pass']) <= 4){
			$this->_ajax_error('密码长度必须大于4位');
		}
		
		if($u['real_pass'] !== $repassword){
			$this->_ajax_error('两次密码不相同！');
		}
		
		$user_find = $this->dU->where('email = "'.$u['email'].'"')->find();
		if(empty($user_find)){
			$uid = $this->dU->data($u)->add();
			$this->dUInfo->add(array('user_id'=>$uid));
			//成功--做登陆处理
			$user_cookie = array(
				'user_id' => $uid,
				'user_name' => $u['user_name'],
				'email' => $u['email'],
			);
			cookie('user_cookie',$user_cookie,3600*24*30);
			//给用户发送一个iframe专题
			send_mail($u['email'],'谢谢您！感谢为我们网站添砖加瓦！','<iframe id="iframe1" name="iframe1" width="100%" height="100%" framespacing=0 frameborder="NO" scrolling="yes"  noresize="noresize" src="'.U('article/index','','','',true).'"></iframe>');
			$this->_ajax_success('注册成功',$u);		//前台js做前端处理，不刷新页面
		}else{
			$this->_ajax_error('该邮箱已存在，请选用其他邮箱');
		}
	}
	
	/**
	*	登出
	**/
	public function logout_ajax(){
		cookie('user_cookie',null);
		$this->_ajax_success('退出成功');
	}
	public function logout(){
		cookie('user_cookie',null);
		$this->success('退出成功',U('user/login'));
	}
	
	public function get_pic(){
		$field = I('post.field');
		$value = I('post.value');
		$data = $this->_get_pic($field,$value);
		if(empty($data)){
			$this->_ajax_error('未知用户');
		}else{
			$this->_ajax_success('成功',$data);
		}
	}
	
	/**
	*	根据邮箱/user_id获取用户头像
	**/
	private function _get_pic($field,$value){
		$where[$field] = $value;
		$userinfo = $this->dU->field('user_id,pic')->where($where)->find();
		return $userinfo;
	}
	
	/**
	*	ajax 返回用户是否是登陆状态
	**/
	public function get_log_status_ajax(){
		if(user_id() > 0){
			echo true;
		}else{
			echo false;
		}
	}
	
	/**
	*	前台 ajax 刷新获取用户新信息
	**/
	public function new_message_ajax(){
		$user_id = user_id();
		$action = I('post.action');
		$new_message = D('Message')->getIncomeMessageNoReadByUserId($user_id);
		$count = count($new_message);
		
		D('Ip')->add(array('user_id'=>$user_id,'ip'=>get_client_ip(),'action'=>$action,'add_time'=>time()));
		
		$this->_ajax_success('',$count);
	}
	
	
}