<?php
class ArticleAction extends HomeAction{
	
	private $dA = '';		//D方法实例化 article 表
	private $dI = '';		//D方法实例化 image 表
	private $dC = '';		//D方法实例化 comment 表
	private $dU = '';		//D方法实例化 user 表
	private $dM = '';		//D方法实例化 message 表
	
	private $table = '';
	
	public function _initialize(){
		parent::_initialize();
		$this->dA = D('Article');
		$this->dI = D('Image');
		$this->dC = D('Comment');
		$this->dU = D('User');
		$this->dM = D('Message');
		
		$this->table = C('DB_PREFIX').'article';
	}
	
	public function index(){
		$this->late();
		return false;
	}
	
	/**
	*	最新更新
	**/
	public function late(){
		$this->late09();
		return false;
		$sql = 'select * from '.$this->table.' where is_show = 1 and add_time <= '.session('now').' order by id DESC';
		$article = $this->get_article($sql);
		$this->return_data($article);
		$count = $this->get_article_count($sql);
		$this->assign_pages($count);
		$this->assign('title','刚刚发生的糗事__'.C('WEB_NAME'));
		//$this->display('index');
		$this->display('index_201408');
	}
	
	public function late09(){
		$article = R('Get/get_zol_article',array('new'));
		$qiu_article = R('Get/get_qiubai_article',array('late',1));
		$article = array_merge($article,(array)$qiu_article);
		shuffle($article);
		$this->return_data($article);
		$count = $this->get_article_count($sql);
		$this->assign_pages($count);
		$this->assign('title','2014最新笑话__'.C('WEB_NAME'));
		//$this->display('index');
		$this->display('index_201408');
	}
	
	
	/**
	*	8小时内
	**/
	public function hot_8(){
		$time = 3600 * 8;
		$last_time = time() - $time;
		$sql = 'select * from '.$this->table.' where is_show = 1 and add_time >= '.$last_time.' and add_time <= '.session('now').' order by up DESC';
		$article = $this->get_article($sql);
		$article = R('Get/get_qiubai_article',array('8hr',1));
		$this->return_data($article);
		$count = $this->get_article_count($sql);
		$this->assign_pages($count);
		$this->assign('title','8小时内精华尴尬事__'.C('WEB_NAME'));
		$this->display('index_201408');
	}
	
	/**
	*	24小时内
	**/
	public function hot_24(){
		$time = 3600 * 24;
		$last_time = time() - $time;
		$sql = 'select * from '.$this->table.' where is_show = 1 and add_time >= '.$last_time.' and add_time <= '.session('now').' order by up DESC';
		$article = $this->get_article($sql);
		$article = R('Get/get_qiubai_article',array('hot',1));
		$this->return_data($article);
		$count = $this->get_article_count($sql);
		$this->assign_pages($count);
		$this->assign('title','24小时内精华尴尬事__'.C('WEB_NAME'));
		$this->display('index_201408');
	}
	
	/**
	*	一周内
	**/
	public function hot_week(){
		$time = 3600 * 24 * 7;
		$last_time = time() - $time;
		$sql = 'select * from '.$this->table.' where is_show = 1 and add_time >= '.$last_time.' and add_time <= '.session('now').' order by up DESC';
		$article = $this->get_article($sql);
		$article = R('Get/get_qiubai_article',array('week',1));
		$this->return_data($article);
		$count = $this->get_article_count($sql);
		$this->assign_pages($count);
		$this->assign('title','一周内精华尴尬事__'.C('WEB_NAME'));
		$this->display('index_201408');
	}
	
	/**
	*	8小时内
	**/
	public function hot_month(){
		$time = 3600 * 24 * 30;
		$last_time = time() - $time;
		$sql = 'select * from '.$this->table.' where is_show = 1 and add_time >= '.$last_time.' and add_time <= '.session('now').' order by up DESC';
		$article = $this->get_article($sql);
		$article = R('Get/get_qiubai_article',array('month',1));
		$this->return_data($article);
		$count = $this->get_article_count($sql);
		$this->assign_pages($count);
		$this->assign('title','一月内精华尴尬事__'.C('WEB_NAME'));
		$this->display('index_201408');
	}
	
	/**
	*	有图有真相之 时令
	**/
	public function pic(){
		$sql = 'select art.* from '.$this->table.' art right join '.C('DB_PREFIX').'image img on art.id = img.article_id where art.is_show = 1 and art.add_time <= '.session('now').' order by art.id DESC';
		$article = $this->get_article($sql);
		$this->return_data($article);
		$count = $this->get_article_count($sql);
		$this->assign_pages($count);
		$this->assign('title','有图有真相之时令__'.C('WEB_NAME'));
		$this->display('index_201408');
	}
	
	
	/**
	*	有图有真相之 硬菜
	**/
	public function imgrand(){
		$this->imgrand09();return false;
		$time = 3600 * 24;
		$last_time = time() - $time;
		$sql = 'select art.* from '.$this->table.' art right join '.C('DB_PREFIX').'image img on art.id = img.article_id where art.is_show = 1 and art.add_time >= '.$last_time.' and art.add_time <= '.session('now').' order by art.up DESC';
		$article = $this->get_article($sql);
		$this->return_data($article);
		$count = $this->get_article_count($sql);
		$this->assign_pages($count);
		$this->assign('title','有图有真相之时令__'.C('WEB_NAME'));
		$this->display('index_201408');
	}
	
	/**
	*	有图有真相之 时令
	**/
	public function imgrand09(){
		$article = R('Get/get_zol_article',array('qutu'));
		$qiu_article = R('Get/get_qiubai_article',array('imgrank',1));
		$article = array_merge($article,(array)$qiu_article);
		shuffle($article);
		$this->return_data($article);
		$count = $this->get_article_count($sql);
		$this->assign_pages($count);
		$this->assign('title','有图有真相之时令__'.C('WEB_NAME'));
		$this->display('index_201408');
	}
	
	/**文章顶**/
	public function up(){
		$article_id = I('post.article_id');
		//写入已顶的cookie
		$up = (array)cookie('article_has');
		$search = array_key_exists($article_id,$up);
		if($search === false){
			$this->dA->where('id='.$article_id)->setInc('up');
			$up[$article_id] = 1;
			cookie('article_has',$up,86400);
			$this->_ajax_success();
		}else{
			
		}
		$this->_ajax_error('你已经顶过该贴');
	}
	
	
	/**文章拍**/
	public function down(){
		$article_id = I('post.article_id');
		//写入已顶的cookie
		$up = (array)cookie('article_has');
		$search = array_key_exists($article_id,$up);
		if($search === false){
			$this->dA->where('id='.$article_id)->setDec('down');
			$up[$article_id] = 2;
			cookie('article_has',$up,86400);
			$this->_ajax_success();
		}
		
		$this->_ajax_error('你已经拍过该贴');
	}
	
	/**
	*	举报给管理员，管理员来做调整和回复
	**/
	public function report(){
		$article_id = I('post.article_id');
		$text = I('post.text');
		if(empty($article_id) || empty($text)){
			$this->_ajax_error('举报失败...某参数为空');
		}
		$data['user_id'] = user_id();
		$data['add_time'] = time();
		$data['add_ip'] = get_client_ip();
		$data['to_user_id'] = 1;		//给管理员的
		$data['content'] = '举报了文章ID为 '.$article_id.' 的文章，动作为：'.$text;
		$this->dM->data($data)->add();
		$this->_ajax_success('举报成功！感谢您的参与');
	}
	
	/**
	*	客户自助移动版区方法
	**/
	public function move_zone(){
		$article_id = I('post.article_id');
		$zone = I('post.zone');
		if(empty($article_id) || empty($zone)){
			$this->_ajax_error('失败...某参数为空');
		}
		$where['id'] = $article_id;
		$data['zone'] = $zone;
		$this->dA->data($data)->where($where)->save();
	}
	
	
	/**
	*	搜索
	**/
	public function search(){
		$keyword = I('post.keyword');
		if($keyword === '' || $keyword === null){
			$this->index();
		}
		$sql = 'select * from '.$this->table.' where is_show = 1 and content like "%'.$keyword.'%"';
		$article = $this->get_article($sql);
		$this->assign('article_data',$article);
		$this->assign('title','糗事搜索__'.C('WEB_NAME'));
		$this->display('index_201408');
	}
	
	/**
	*	查看文章下评论
	**/
	public function comment(){
		$article_id = I('post.article_id');
		$comment_res = $this->dC->getCommentByAId($article_id);
		$comment_res = array_slice($comment_res,0,10);
		if(empty($comment_res)){
			$comment_res =array();
			$this->_ajax_success('成功',$comment_res);
		}
		foreach($comment_res as $key => $val){
			if($val['user_id'] > 0){
				$user_info = $this->dU->getUserInfoById($val['user_id']);
				$comment_res[$key]['pic'] = $user_info['pic'];
				$comment_res[$key]['user_name'] = $user_info['user_name'];
			}else{
				$comment_res[$key]['pic'] = __PUBLIC__.'/public/images/default_pic.jpg';
				$comment_res[$key]['user_name'] = '匿名';
			}
		}
		$this->_ajax_success('成功',$comment_res);
	}
	
	/**
	*	提交留言
	**/
	public function add_comment(){
		$article_id = I('post.article_id');
		$comment = I('post.comment');
		$user_cookie = cookie('user_cookie');
		if(empty($user_cookie)){
			$user_id = 0;
			
		}else{
			$user_id = $user_cookie['user_id'];
		}
		$data['user_id'] = $user_id;
		$data['article_id'] = $article_id;
		$data['content'] = $comment;
		$data['add_time'] = time();
		$cid = $this->dC->data($data)->add();
		
		//返回用户信息
		if($user_id > 0){
			$user_info = $this->dU->getUserInfoById($data['user_id']);
			$return['user_id'] = $user_id;
			$return['user_name'] = $user_info['user_name'];
			$return['pic'] = $user_info['pic'];
		}else{
			$return['user_id'] = $user_id;
			$return['user_name'] = '匿名';
			$return['pic'] = __PUBLIC__.'/public/images/default_pic.jpg';
		}
		$this->_ajax_success('',$return);
	}
	
	
	
	/**
	*	通用获取文章-图片-评论-顶/拍方法
	**/
	public function get_article($sql=''){
		$limit = $this->format_limit();
		$article_res = M()->query($sql.' limit '.$limit);
		foreach($article_res as $key => $val){
			//获取文章对应图片
			$val['image'] = $this->dI->getImageByAId($val['id']);
			//如果有用户信息就查询用户信息，赋值到原信息
			if($val['user_id'] > 0){
				$user_info = $this->dU->getUserInfoById($val['user_id']);
				$val['former_user_id'] = $user_info['user_id'];
				$val['former_user_name'] = $user_info['user_name'];
				$val['former_user_email'] = $user_info['email'];
				$val['pic'] = $user_info['pic'];
			}else{
				//否则是抓取的文章，抓取也有空头像
				if(empty($val['pic'])){
					$val['pic'] = __PUBLIC__.'/public/images/default_pic.jpg';
				}
			}
			//评论数量
			$val['comment_count'] = $this->dC->getCommentCount($val['id']);
			
			$article_res[$key] = $val;
		}
		return $article_res;
	}
	
	
	/**
	*	传入 sql 语句获取总数
	**/
	private function get_article_count($sql){
		$count_sql = str_replace('*','count(*) as count',$sql);
		$count_res = M()->query($count_sql);
		return $count_res[0]['count'];
	}
	
}