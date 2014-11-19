<?php
// 本类由系统自动生成，仅供测试用途
class UserAction extends HomeAction {

    public function index(){
		$this->login();
    }
	public function login(){
		$this->assign('title','登录_糗星人网站');
		$this->display();
	}
	public function check(){
		$data['email'] = $_POST['email'];
		$data['password'] = $_POST['password'];
		
		if(filter_var($data['email'],FILTER_VALIDATE_EMAIL) == false){
			$this->error('帐号验证失败，请使用邮箱登录');
		}
		
		//先查找论坛表是否对应此用户和密码
		$saas = M('user');
		$saas_res = $saas->where("email = '".$data['email']."'")->find();
		//如果查到了数据，表示用这个用户，再验证密码
		if($saas_res != null){
			$uid = $saas_res['user_id'];
			if($saas_res['password'] != $data['password']){
				$this->error('密码验证失败，请检查输入');
			}else{
				//否则登陆成功，做session等处理
				$last['last_log_time'] = time();
				$last['last_log_ip'] = get_client_ip();
				$saas->where('user_id = '.$uid)->data($last)->save();			//更新最后登陆时间和IP
				$saas->where('user_id = '.$uid)->setInc('logins');			//更新最后登陆时间和IP
				//生成同步登录的代码
				//用户session信息
				$sessionData = array(
					'userid' => $saas_res['user_id'],
					'username'	=> $saas_res['user_name'],
					'expire'	=> 3600*24,	//为期一天的session
				);
				session("tsuser",$sessionData);
				cookie('email',$saas_res['email'],3600*24*30); // 保留一个月cookies
				$this->success('登陆成功',U('Index/index'));
			}
		}else{
			$this->error('没有找到此用户名，请检查输入');
		}
	}
	public function register(){
		$this->assign('title','注册_糗星人网站');
		$this->display();
	}
	public function add(){
		$u['email']	 = I('post.email');
		$u['user_name'] = I('post.user_name');
		$u['password'] = I('post.password');
		$repassword = I('post.repassword');
		$u['reg_ip'] = get_client_ip();
		$u['reg_time'] = time();
		
		if(filter_var($u['email'],FILTER_VALIDATE_EMAIL) == false){
			$this->error('输入帐号为非邮箱，邮箱验证失败！');
		}
		
		if($u['password'] !== $repassword){
			$this->error('两次密码不相同！');
		}
		
		$user = M('user');
		$find_user = $user->where('email = "'.$u['email'].'"')->find();
		if(empty($find_user)){
			//注册到表
			$uid = $user->data($u)->add();
			if($uid <= 0) {
				$this->error('用户注册失败,可能是服务器原因,您可以重试此操作');
			} else {
				//用户session信息
				$sessionData = array(
					'userid' => $uid,
					'username'	=> $u['user_name'],
					'expire'	=> 3600*24,	//为期一天的session
				);
				session("tsuser",$sessionData);
				send_mail($u['email'],'谢谢您！感谢为我们网站添砖加瓦！','感谢注册,现在可以畅游<a target="blank" href="http://qiuxingren.com">糗星人网站</a>了！');
				$this->success('注册成功，现在返回首页并登录',U('Index/index'));
			}
		}else{
			$this->error('该帐号已存在，请选用其他帐号');
		}
	}
	
	
	public function logout(){
		session("tsuser",null);
		cookie('email',null);
		$this->success('退出成功',U('User/login'));
	}
	
	
	
	/**
	*	关注用户的点击增加
	**/
	public function guanzhu(){
		$session = session("tsuser");
		$user_id = $session['userid'];
		if(empty($user_id)){
			$this->ajaxReturn('','未登录',0);
			exit;
		}
		$res = M('user')->where('user_id = '.$_POST['uid'])->find();
		if(!$res){
			$this->ajaxReturn('','此用户非本网站用户，无法关注',-3);
			exit;
		}
		$res = M('guanzhu')->where('user_id = '.$user_id.' and user_id_guanzhu = '.$_POST['uid'])->find();
		if(!$res){
			$data['user_id'] = $user_id;
			$data['user_id_guanzhu'] = $_POST['uid'];
			$data['add_time'] = time();
			$id = M('guanzhu')->add($data);
			if($id){
				$this->ajaxReturn('','成功',1);
			}else{
				$this->ajaxReturn('','服务器错误，您可以重试此操作',-2);
			}
		}else{
			$this->ajaxReturn('','已经关注过此用户',-1);
		}
	}
	
	/**
	*	获取新信息
	**/
	public function new_message_ajax(){
		$session = session("tsuser");
		$user_id = $session['userid'];
		if(empty($user_id)){
			$this->ajaxReturn('','未登录',0);
			exit;
		}
		$data['to_user_id'] = $user_id;
		$data['is_read'] = 0;
		$count = M('message')->where($data)->count();
		$this->ajaxReturn(intval($count),'成功',1);
	}
	
}

