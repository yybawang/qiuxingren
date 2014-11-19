<?php
// 本类由系统自动生成，仅供测试用途
class MessageAction extends HomeAction {
    public function index(){
		
	}
	
	
	//ajax post接收值
	function send(){
		$data['user_id'] = $_POST['user_id'];
		$data['content'] = $_POST['content'];
		$null = preg_match('/\s*/',$data['content']);
		//如果没有登陆而且内容全为空白
		if(empty($data['user_id']) || !$null){
			$error = 'empty';
			exit();
		}else{
			//这里要判断是否是自家用户，如果不是，就用CURL，否则为本地数据库
			//暂时搁置，因为我登陆是本地，发送给糗事百科，又要登陆，无法完成
			$message = M('message');
			$data['add_time'] = time();
			$data['to_user_id'] = $_POST['to_user_id'];
			$data['is_read'] = 0;
			$data['add_ip'] = get_client_ip();
			$res = $message->data($data)->add();
			$res > 0 ? $error = 'success' : $error = 'error';
			$this->ajaxReturn($error);
		}
	}
	
	public function proposal(){
		$article = $_POST['content'];
		if(!empty($article) || !preg_match('/\s*/',$article)){
			$message = M('message');
			$u_info = session('tsuser');
			$user_id = $u_info['userid'];
			$data['user_id'] = $user_id ? $user_id : 0;
			$data['to_user_id'] = 1;	//1为管理员
			$data['content'] = $article;
			$data['add_time'] = time();
			$data['add_ip'] = get_client_ip();
			$data['is_read'] = 0;
			$id = $message->data($data)->add();
			if($id){
				$this->success("反馈已接收！感谢您的反馈。");
			}else{
				$this->error("服务器又TM的出问题了，反馈未接收。");
			}
		}
	}
}
?>