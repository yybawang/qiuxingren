<?php
class UsercenterAction extends HomeAction{
	
	public $dU = '';
	public $dUInfo = '';
	public $dA = '';
	public $dM = '';
	public $dF = '';
	public $dC = '';
	public $user = array();

	public function _initialize(){
		parent::_initialize();
		$this->dU = D('User');
		$this->dUInfo = D('UserInfo');
		$this->dA = D('Article');
		$this->dM = D('Message');
		$this->dF = D('Follow');
		$this->dC = D('Comment');
		//必须登录
		$user_cookie =  cookie('user_cookie');
		if(!empty($user_cookie)){
			$user_find = $this->dU->getUserInfoById($user_cookie['user_id']);
			$this->user = $user_find;
			$this->assign('user_info',$this->user);
		}else{
			//否则跳到登陆
			$this->display('User/login');
			exit;
		}
	}
	
	public function index(){
		$this->article();
	}
	
	//我的文章
	public function article(){
		$data = $this->dA->getArticleByUserId($this->user['user_id']);
		$this->assign('content',$data);
		$this->assign('title','我发布的文章__'.C('WEB_NAME'));
		$this->display('article');
	}
	
	//用户小纸条
	public function message(){
		$action = I('get.action');
		$user_id = $this->user['user_id'];
		if(empty($action)){$action = 'income';}
		if($action == 'income'){
			//收取到的小纸条
			$data = $this->dM->getIncomeMessageByUserId($user_id);
			foreach($data as $key => $val){
				$user_info = $this->dU->getUserInfoById($val['user_id']);
				$data[$key]['from'] = $user_info;
			}
			$this->dM->where(array('to_user_id'=>$user_id))->save(array('is_read'=>1));
		}elseif($action == 'send'){
			//发送的小纸条
			$data = $this->dM->getSendMessageByUserId($user_id);
			foreach($data as $key => $val){
				$user_info = $this->dU->getUserInfoById($val['to_user_id']);
				$data[$key]['from'] = $user_info;
			}
			$this->dM->where(array('user_id'=>$user_id))->save(array('is_read'=>1));
		}
		
		$this->assign('content',$data);
		$this->assign('title','我的留言/小纸条__'.C('WEB_NAME'));
		$this->display();
	}
	
	//用户评论过的文章
	public function comment(){
		$data = $this->dC->getCommentByUserId($this->user['user_id']);
		$i=-1;
		foreach($data as $key => $val){
			//如果以前没有
			if(!in_array($val['article_id'],$com)){
				
				$i++;
				$com[$i] = $val['article_id'];
				//找到文章ID对应的文章
				$article_select = $this->dA->get_article($val['article_id']);
				$return[$i] = $article_select[0];
			}
			$return[$i]['comments'][] = $val;
		}
		
		$this->assign('content',$return);
		$this->assign('title','我评论过的__'.C('WEB_NAME'));
		$this->display();
	}
	
	//获取我的粉丝
	public function followers(){
		$followers_res = $this->dF->getFollowersByUserId($this->user['user_id']);
		foreach($followers_res as $key => $val){
			$data[$key] = $this->dU->getUserInfoById($val['user_id']);
		}
		
		$this->assign('content',$data);
		$this->assign('title','我的粉丝__'.C('WEB_NAME'));
		$this->display();
	}
	
	//获取我关注的用户
	public function followings(){
		$followers_res = $this->dF->getFollowingsByUserId($this->user['user_id']);
		foreach($followers_res as $key => $val){
			$return[$key] = $this->dU->getUserInfoById($val['user_id']);
		}
		$this->assign('content',$return);
		$this->assign('title','我的关注__'.C('WEB_NAME'));
		$this->display();
	}
	
	/**
	*	修改用户资料
	**/
	public function update(){
		$this->assign('title','修改用户资料__'.C('WEB_NAME'));
		$this->display();
	}
	
	public function update_check(){
		$user_id = $this->user['user_id'];
		$data['user_name'] = I('post.user_name');
		$data_info['sex'] = intval(I('post.sex'));
		$data_info['resume'] = I('post.resume');
		$pic = $_FILES['pic'];
		if($pic['name']){
			$upload = $this->upload_image(__UPLOAD__.'/user_logo/');
			if($upload['status'] == 1){
				$data['pic'] =  __PUBLIC__.'/user_logo/'.$upload['data'][0]['savename'];
			}else{
				$this->error($upload['info']);
			}
		}
		
		$user_cookie = array(
			'user_id' => $user_id,
			'user_name' => $data['user_name'],
			'email' => I('post.email'),
		);
		cookie('user_cookie',$user_cookie,3600*24*30);		//修改用户信息也要更新用户名
		
		$this->dU->where('user_id = '.$user_id)->data($data)->save();
		$this->dUInfo->where('user_id = '.$user_id)->data($data_info)->save();
		$this->success('修改成功!');
	}
	
	/**
	*	修改密码
	**/
	public function repwd(){
		$user_id = $this->user['user_id'];
		if(!isset($_POST['old_pwd'])){
			$this->display();
		}else{
			$old_pwd = I('post.old_pwd');
			$new_pwd =  I('post.new_pwd');
			$new_pwd2 =  I('post.new_pwd2');
			$new_pwd == $new_pwd2 ? '' : $this->error('两次新密码输入不一致，请检查输入');
			
			$user_res = $this->dU->where('user_id = '.$user_id)->find();
			//加密老密码
			$md5_old_pwd = $this->dU->format_password($old_pwd);
			if($md5_old_pwd != $user_res['password']){
				$this->error('修改失败！原密码不符，请输入正确原密码');
			}else{
				$data['real_pass'] = $new_pwd;
				$data['password'] = $this->dU->format_password($new_pwd);
				$id = $this->dU->where('user_id = '.$user_id)->data($data)->save();
				$id ? $this->success('修改成功!请用新密码登陆!',U('User/logout')) : $this->error('服务器错误--修改失败！');
			}
		}
	}
	
	/**
	*	ajax 修改用户简介
	**/
	public function edit_ajax(){
		$user_id = $this->user['user_id'];
		$name = I('get.name');
		$content = I('get.content');
		$where['user_id'] = $user_id;
		switch($name){
			case 'resume':
				$data['resume'] = $content;
				$this->dUInfo->where($where)->save($data);
				break;
			
			
		}
		$this->_ajax_success();
	}
	
	/**
	*	签到
	**/
	public function sign(){
		$user_id = $this->user['user_id'];
		$jifen = $this->dU->sign_commit($user_id);
		$this->_ajax_success('签到成功',$jifen);
	}
	
	/**
	*	ajax 获取用户信息
	**/
	public function user_info_ajax(){
		$user_id = I('post.user_id');
		if(empty($user_id)){
			$this->_ajax_error('用户ID错误');
			return false;
		}
		$user_info = $this->dU->getUserInfoById($user_id);
		$user_info['reg_time'] = format_time($user_info['reg_time']);
		$user_info['last_log_time'] = format_time($user_info['last_log_time']);
		$user_info['user_bg'] = __PUBLIC__.'/user_bg/default.jpg';
		$this->_ajax_success('获取成功',$user_info);
	}
	
}