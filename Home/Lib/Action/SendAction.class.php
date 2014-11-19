<?php
class SendAction extends HomeAction{
	
	public $dA = '';
	public $dI = '';
	
	public function _initialize(){
		parent::_initialize();
		$this->dA = D('Article');
		$this->dI = D('Image');
	}
	
	public function index(){
		$this->send();
	}
	
	/**
	*	投稿
	**/
	public function send(){
		$this->assign('title','投递新稿__'.C('WEB_NAME'));
		$this->display();
	}
	
	
	public function send_check(){
		$data['content'] = I('post.content');
		$data['zone'] = I('post.zone');
		$data['add_time'] = time();
		
		$hid_me = I('post.hid_me');
		if(!empty($hid_me)){
			$cookie_user = cookie('cookie_user');
			$data['user_id'] = $cookie_user['user_id'];
		}
		$files = implode($_FILES['image']['name']);
		if(!empty($files)){
			$info = $this->upload_image(__UPLOAD__.'/article_images/');
			if($info['status'] == 1){
				
			}else{
				$this->error($info['info']);
			}
		}
		
		$article_id = $this->dA->data($data)->add();
		foreach($info['data'] as $key => $val){
			$img_data[$key]['image_link'] = __PUBLIC__.'/article_images/'.$val['savename'];
			$img_data[$key]['article_id'] = $article_id;
		}
		$this->dI->addAll($img_data);
		$this->success('<h2>非常感谢您的分享!</h2>您刚刚提交的糗事将在审核通过之后发表。<br />作为回报，本站已将您的人品 +1，<br />接下来的日子，您将生活的更加幸福快乐。<br />',U('Article/index'));
	}
	
	/**
	*	审帖
	**/
	public function audit(){
		$this->assign('title','新稿审核__'.C('WEB_NAME'));
		$this->display();
	}
	
	public function audit_check(){
		$action = I('post.action');
		$article_id = I('post.article_id');
		switch($action){
			case 'yes':
				$data['is_show'] = 1;
				$data['check_time'] = time();
				$this->dA->where('id = '.$article_id)->data($data)->save();
				//加入了通知用户审核通过的邮件
				$article_find = $this->dA->get_article($article_id);
				$user_id = $article_find[0]['user_id'];
				if(!empty($user_id)){
					$aUserInfo = D('User')->getUserInfoById($user_id);
					$sUsername = '昵称为 "'.$aUserInfo['user_name'].'" 的';
					@send_mail($aUserInfo['email'],'太棒了！你的文章发表成功了！','文章被'.$sUsername.' 网友审核通过了！看来你的故事非常的有趣！点击<a href="'.U('index/single',array('article' =>$article_id),'','',true).'">这里</a>查看你的成果吧！');
				}
			break;
			case 'no': 
				$data['is_show'] = -1;
				$data['check_time'] = time();
				$this->dA->where('id = '.$article_id)->data($data)->save();
			break;
			case 'pass':
				break;
			default:break;
		}
		$data = $this->next_audit();
		$this->_ajax_success('获取成功',$data[0]);
	}
	
	public function next_audit(){
		$data = $this->dA->getArticleByRand();
		return $data;
	}
}