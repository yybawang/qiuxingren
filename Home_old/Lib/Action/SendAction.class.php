<?php
// 本类由系统自动生成，仅供测试用途
class SendAction extends HomeAction {
    public function index(){
		$this->send();
    }
	public function send(){
		$this->assign('title','投递新稿__糗星人网站');
		$this->display('send');
	}
	public function add(){
		$data['content'] = $_POST['content'];	//得到文章
		if(empty($data['content'])){
			$this->error('糗事不能为空，即使你上传了图片~~~');
		}
		$data['add_time'] = time();
		$hid_me = $_POST['hid_me'];
		$session = session('tsuser');
		$user_id = $session['userid'];
		if(!empty($hid_me) || empty($user_id)){
			$user_id=0;		///设置0则为匿名
		}
		$data['user_id'] = $user_id;
		$data['is_show'] = 0;
		$data['zone'] = $_POST['zone'];
		$article = M('article');
		$files = implode($_FILES['image']['name']);
		if(!empty($files)){
			$file = $this->upload_image();
		}
		$id = $a_id = $article->data($data)->add();
		if(!empty($files)){
			$image = M('image');
			$data_image['in_article_id'] = $a_id;
			foreach($file as $key => $info){
				$data_image['image_link'] = '/self_images/'.$info['savename'];
				$image->data($data_image)->add();
			}
		}
		if($id){
			$this->success('<h2>非常感谢您的分享!</h2>您刚刚提交的糗事将在审核通过之后发表。<br />作为回报，本站已将您的人品 +1，<br />接下来的日子，您将生活的更加幸福快乐。<br />',U('Index/index'));
		}else{
			$this->error('服务器错误---');
		}
	}
	function upload_image(){
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = 4098000 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->savePath = './Public/self_images/';// 设置附件上传目录  
		if(!$upload->upload()) {
			// 上传错误提示错误信息        
			$this->error($upload->getErrorMsg());    
		}else{
			// 上传成功
			$info =  $upload->getUploadFileInfo();
			return $info;
		}
	}
	//审核
	public function audit(){	
		$article = M('article');
		$image = M('image');
		//查询出条数
		$res = $article->where('is_show = 0')->select();
		$count = 0;
		foreach($res as $val){
			$count++;
		}
		$rand = rand(1,$count);
		
		$res = $article->where('article_id = '.$res[$rand-1]['article_id'])->find();
		$img = $image->where('in_article_id = '.$res['article_id'])->select();
		
		if($img){
			foreach($img as $k => $v){
				if(!stripos($v['image_link'],'ttp://')){
					$img[$k]['image_link'] = __ROOT__.'/Public'.$v['image_link'];
				}
			}
			$res['image'] = $img;
		}
		$this->assign('title','新稿审核__糗星人网站');
		$this->assign('content',$res);
		$this->display();
	}
	public function check(){
		$action = $_POST['action'];
		$article_id = $_POST['article_id'];
		$article = M('article');
		$image = M('image');
		if(!empty($article_find[0]['user_id'])){
			$aUserInfo = D('User')->getUserInfoById($article_find[0]['user_id']);
			$sUsername = '昵称为 "'.$auserInfo['user_name'].'" 的';
		}
		switch($action){
			case 'yes':
				$data['is_show'] = 1;
				$data['check_time'] = time();
				$article->where('article_id = '.$article_id)->data($data)->save();
				$article_find = D('Article')->get_article($article_id);
				
				@send_mail($aUserInfo['email'],'太棒了！你的文章发表成功了！','文章被'.$sUsername.' 网友审核通过了！看来你的故事非常的有趣！点击<a href="'.U('index/single',array('article' =>$article_id),'','',true).'">这里</a>查看你的成果吧！');
				break;
			case 'no': 
				$data['is_show'] = -1;
				$data['check_time'] = time();
				$article->where('article_id = '.$article_id)->data($data)->save();
				$article_find = D('Article')->get_article($article_id);
				
				@send_mail($aUserInfo['email'],'很遗憾的通知您','很遗憾的通知，您的文章被'.$sUsername.'网友审核未通过，您还可以点击再次投稿，点击<a href="'.U('usercenter/center','','','',true).'">这里</a>查看你发布的文章');
				break;
			case 'pass': 
				break;
			default:exit();
		}
		$res = $this->_next_audit();
		$this->ajaxReturn($res);
	}
	private function _next_audit(){
		$article = M('article');
		$image = M('image');
		//查询出条数
		$res = $article->where('is_show = 0')->select();
		$count = 0;
		foreach($res as $val){
			$count++;
		}
		$rand = rand(1,$count);
		$find = $article->where('article_id = '.$res[$rand-1]['article_id'])->find();
		$img = $image->where('in_article_id = '.$find['article_id'])->select();
		if($img){
			foreach($img as $k => $v){
				if(!stripos($v['image_link'],'ttp://')){
					$img[$k]['image_link'] = __ROOT__.'/Public'.$v['image_link'];
				}
			}
			$find['image'] = $img;
		}
		return $find;
	}
}
?>