<?php
// 本类由系统自动生成，仅供测试用途
class UsercenterAction extends HomeAction {
	var $u_info = array();
	var $user_id = null;
	public function _initialize(){
		$session = session('tsuser');
		$user_id = $session['userid'];
		if(empty($user_id)){
			$this->error('未登陆，请先登录',U('User/login'));
			exit();
		}else{
			$this->user_id = $user_id;
		}
		$user = M('user');
		$res = $user->where('user_id = '.$user_id)->find();
		if(empty($res['pic'])){
			$res['pic'] = '/public/images/default_pic.jpg';
		}
		$this->u_info = $res;
		$this->assign('user',$res);
	}
    public function index(){
		$this->center();
    }
	
	public function center(){
		
		$res = $this->u_info;
		$user_id = $this->user_id;
		$article = M('article');
		$image = M('image');
		$a_res = $article->where('user_id = '.$user_id)->select();
		foreach($a_res as $key => $value){
			$img = $image->where('in_article_id = '.$a_res[$key]['article_id'])->select();
			$a_res[$key]['image'] = $img;
		}
		$this->assign('content',$a_res);
		$this->assign('title','用户中心_糗星人网站');
		$this->display();
	}
	/**
	*	用户留言页面
	**/
	public function message(){
		$message = M('message');
		$user_id = $this->user_id;
		$user = M('user');

		$res_message = $message->where('to_user_id = '.$user_id)->order('add_time desc')->select();
		foreach($res_message as $key => $val){
			if($val['user_id']  > 0){
				//对方用户资料
				$u_from = $user->where('user_id = '.$val['user_id'])->find();
				if(!$u_from){
					$res_message[$key]['from']['user_name'] = '匿名用户';
				}else{
					if(empty($u_from['pic'])){
						$u_from['pic'] = '/public/images/default_pic.jpg';
					}
					$res_message[$key]['from'] = $u_from;
				}
			}
		}
		$message->where('to_user_id = '.$user_id)->save(array('is_read' => '1'));
		
		$this->assign('content',$res_message);
		$this->assign('title','查看我的留言_糗星人网站');
		$this->display();
	}
	
	//查看我的评论
	public function comment(){
		$comment = M('comment');
		$article = M('article');
		$image = M('image');
		$user_id = $this->user_id;
		$user = M('user');
		//用户中心资料
		$res = $this->u_info;
		$res_comment = $comment->where("user_id = ".$user_id)->order('comment_time desc')->select();
		
		foreach($res_comment as $key => $val){
			//如果没有此ID键，就查找对应的文章信息
			if(!array_key_exists($val['article_id'],$res_comment)){
				$a_res = $article->where('article_id = '.$val['article_id'])->find();
				if($a_res){
					$img_res = $image->where('in_article_id = '.$val['article_id'])->select();
					$res_comments[$val['article_id']]['image'] = $img_res;
				}
				
				$res_comments[$val['article_id']]['content'] = $a_res['content'];
				$res_comments[$val['article_id']]['former_id'] = $a_res['former_id'];
				$res_comments[$val['article_id']]['article_id'] = $val['article_id'];
			}
			
			//浏览内容数组
			$res_comments[$val['article_id']]['comments'][] = array('comment_content'=>$val['comment_content'],'comment_time'=>$val['comment_time']);
		}
		$this->assign('comment',$res_comments);
		$this->assign('title','我的评论_糗星人网站');
		$this->display();
	}
	
	/**修改用户资料**/
	public function update(){
		$this->assign('title','修改用户资料_糗星人网站');
		$this->display();
	}
	public function change(){
		$user_id = $this->user_id;
		$user = M('user');
		$data['user_name'] = I('post.user_name');
		$pic = $_FILES['pic'];
		if($pic['name']){
			$data['pic'] = $this->upload_image();
		}
		$id = $user->where('user_id = '.$user_id)->data($data)->save();
		$id ? $this->success('修改成功!') : $this->error('未修改任何东西');
	}
	public function repwd(){
		$user_id = $this->user_id;
		if(!isset($_POST['old_pwd'])){
			$this->display();
		}else{
			$user = M('user');
			$old_pwd = I('post.old_pwd');
			$new_pwd =  I('post.new_pwd');
			$new_pwd2 =  I('post.new_pwd2');
			$new_pwd == $new_pwd2 ? $data['password'] = $new_pwd : $this->error('两次新密码输入不一致，请重试');
			$res = $user->where('user_id = '.$user_id)->find();
			if($old_pwd != $res['password']){
				$this->error('修改失败！原密码不符，请输入正确原密码');
			}else{
				$data['password'] = $new_pwd;
				$id = $user->where('user_id = '.$user_id)->data($data)->save();
				$id ? $this->success('修改成功!请用新密码登陆!',U('User/logout')) : $this->error('修改失败！请重试');
			}
		}
	}
	
	/**
	*	获取我的粉丝
	**/
	public function followers(){
		$user_id = $this->user_id;
		$res = M('guanzhu')->where('user_id_guanzhu = '.$user_id)->order('add_time desc')->select();
		foreach($res as $key => $val){
			$u_info = M('user')->where('user_id = '.$val['user_id'])->find();
			$res[$key]['pic'] = empty($u_info['pic']) ? __PUBLIC__.'/public/images/default_pic.jpg' : $u_info['pic'];
			$res[$key]['user_name'] = $u_info['user_name'];
			$res[$key]['add_time'] = date('Y-m-d H-m-s',$res[$key]['add_time']);
		}
		$this->assign('user_info',$res);
		$this->assign('title','我的粉丝_糗星人网站');
		$this->display();
	}
	
	
	/**
	*	获取的关注的用户
	**/
	public function followings(){
		$user_id = $this->user_id;
		$res = M('guanzhu')->where('user_id = '.$user_id)->order('add_time desc')->select();
		foreach($res as $key => $val){
			$u_info = M('user')->where('user_id = '.$val['user_id_guanzhu'])->find();
			$res[$key]['pic'] = empty($u_info['pic']) ? __PUBLIC__.'/public/images/default_pic.jpg' : $u_info['pic'];
			$res[$key]['user_name'] = $u_info['user_name'];
			$res[$key]['add_time'] = date('Y-m-d H:i:s',$res[$key]['add_time']);
		}
		$this->assign('user_info',$res);
		$this->assign('title','我的关注_糗星人网站');
		$this->display();
	}
	
	
	/**
	*	ajax 获取用户信息
	**/
	public function user_info_ajax(){
		$user_id = I('post.user_id');
		if(empty($user_id)){
			$this->ajaxReturn("","用户ID错误",0);
			exit;
		}
		$info = M('user')->where("user_id = ".$user_id)->find();
		if($info){
			empty($info['pic']) ? $info['pic'] = '/public/images/default_pic.jpg' : '';
			$info['reg_time'] = date("Y-m-d H:i:s",$info['reg_time']);
			$info['last_log_time'] = date("Y-m-d H:i:s",$info['last_log_time']);
			//设置一张背景图
			$info['user_bg'] = '/user_bg/default.jpg';
			$this->ajaxReturn($info,'获取成功',1);
		}
	}
	
	/**
	*	删除留言
	**/
	public function del_message_ajax(){
		$message_id = I('post.article_id');
		$line = M('message')->where('message_id = '.$message_id)->delete();
		if($line){
			$this->ajaxReturn('','成功',1);
		}else{
			$this->ajaxReturn('','删除失败',0);
		}
	}
	
	
	function upload_image(){
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = 4098000 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->savePath = './Public/user_logo/';// 设置附件上传目录  
		if(!$upload->upload()) {
			// 上传错误提示错误信息        
			$this->error($upload->getErrorMsg());    
		}else{
			// 上传成功
			$info =  $upload->getUploadFileInfo();
			$pic = '/user_logo/'.$info[0]['savename'];
			return $pic;
		}
	}

}

